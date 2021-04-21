$( "#spinner" ).spinner({
    min:1,
    max:10
});

$('#id-form-novo-pedido').on('submit', function(event){
    event.preventDefault();
    const endereco_id = $('#id-selecao-endereco').val();
    // Cria uma requisição assíncrona
    $.ajax({
        type: "POST",
        url: `/pedido/${endereco_id}`, // /pedido/1 ou /pedido/null
        data: $(this).serialize(),
        dataType: 'json',
        // Quando o servidor consegue responder (mesmo que positivo ou negativo)
        success: function (response){
            $("#list-pedidos").html("");
            response.return.forEach(element => {
                $("#list-pedidos").append(`<a href="#" class="list-group-item list-group-item-action" data-toggle="list" value=${element.id}>Pedido ${element.id}</a>`);
            });
            $("#list-pedidos a:first-child").click();
            //console.log(response.success);
            //console.log(response.message);
            //console.log(response.return);
        },
        // Quando o servidor não consegue responder
        error: function(error){
            //console.log(error.responseJSON);
        }
    });
});

$("#id-selecao-tipo-produto").on('change', function(){
    const tipoProdutoId = $('#id-selecao-tipo-produto').val();
    $.ajax({
        type: "GET",
        url: `/pedidoproduto/getTodosProdutosDeTipo/${tipoProdutoId}`,
        data: null,
        dataType: 'json',
        success: function(response) {
            $('#id-selecao-produto').html("");
            response.return.forEach(element => {
                $('#id-selecao-produto').append(`<option value=${element.id}>${element.nome}</option>`);
            });
        },
        error: function(error) {
        }
    });
});

$("#id-botao-adicionar-produto").on('click', function(event){
    event.preventDefault();
    let id_pedido;
    if($("#list-pedidos a.active")[0]){
        id_pedido = $("#list-pedidos a.active")[0].getAttribute("value");
    }
    const id_produto = $("#id-selecao-produto").val();
    const quantidade = $("#spinner").val();
    const id_endereco = $("#id-selecao-endereco").val();
    if(id_pedido && id_produto && quantidade && id_endereco){
        $.ajax({
            type: "post",
            url: `/pedidoproduto/${id_pedido}/${id_produto}/${id_endereco}/${quantidade}`,
            data: $('#id-form-add-pedido-produto').serialize(),
            dataType: "json",
            success: function(response){
                //console.log(response);
                $("#list-pedidos a.active").click();
            },
            error: function(error){

            }
        });
    }
});

$("#list-pedidos").on('click', function(event){
    const pedido_id = event.target.getAttribute("value");
    $.ajax({
        type: "get",
        url: `/pedidoproduto/getPedidoProdutosList/${pedido_id}`,
        data: null,
        dataType: "json",
        success: function(response){
            let preco = 0;
            //console.log(response);
            $("#list-produtos").html("");
            response.return.forEach(element => {
                preco += Number(element.produto_preco)*Number(element.quantidade);
                $("#id-selecao-endereco").val(String(element.endereco_id));
                $("#list-produtos").append(`<span href="#" class="list-group-item" value1=${element.pedido_id} value2=${element.produto_id}>
                                                ${element.tipo_descricao} - ${element.produto_nome} - ${element.quantidade}x
                                                <svg data-toggle="modal" data-target="#destroyModal" value="/pedidoproduto/${element.pedido_id}/${element.produto_id}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash icons-list-produto destroyButton" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </span>`);
            });

            const destroyButtons = document.querySelectorAll(".destroyButton");
            const destroyForm = document.querySelector("#destroyForm");
            destroyButtons.forEach(destroyButton => {
                destroyButton.addEventListener('click', configureAction);
            });
            function configureAction(){
                destroyForm.setAttribute('action', this.getAttribute('value'));
            }

            $("#id-spam-preco").html(preco.toLocaleString('pt-BR', {minimumFractionDigits: 2}));
            //console.log(response.return.length);
            if(response.return.length == 0)
                $("#id-text-status").val("Estado: Sem produtos");
            else {
                if(response.return[0].pedido_status == "A")
                    $("#id-text-status").val("Estado: Aberto");
                else
                    $("#id-text-status").val("Estado: Enviado");
            }
        },
        error: function(error){

        }
    });
});


$('#id-form-enviar-pedido').on('submit', function(event){
    event.preventDefault();
    const pedido_id = $("#list-pedidos a.active").get(0).getAttribute("value");
    //console.log(pedido_id);
    $.ajax({
        type: "post",
        url: `/pedido/enviarPedido/${pedido_id}`,
        data: $(this).serialize(),
        dataType: "json",
        success: function(response){
            $("#list-pedidos a.active").click();
        },
        error: function(error){

        }
    });
});


$('#id-form-endereco').on('change', function(){
    const pedido_id = $('#list-pedidos a.active').get(0).getAttribute("value");
    const endereco_id = $("#id-selecao-endereco").val();
    console.log(pedido_id);
    console.log(endereco_id);
    $.ajax({
        type: "post",
        url: `/pedido/alterarEndereco/${pedido_id}/${endereco_id}`,
        data: $(this).serialize(),
        dataType: "json",
        success: function(response){
            //console.log(response);
        },
        error: function(error){
            //console.log(error);
        }
    });
});


$('#destroyForm').on('submit', function(event){
    event.preventDefault();
    const url_remove = this.getAttribute('action');
    $.ajax({
        type: "delete",
        url: url_remove,
        data: $(this).serialize(),
        dataType: "json",
        success: function(response){
            $('#destroyModal').modal('hide')
            $("#list-pedidos a.active").click();
        },
        error: function(error){
            $('#destroyModal').modal('hide')
            $("#list-pedidos a.active").click();
        }
    });
});


