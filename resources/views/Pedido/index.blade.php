<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href={{ asset('css/pedido.css') }}>
    <title>Index de Pedidos</title>
</head>
<body>
    <div class="container">
        <div class="row">
            {{-- Parte esquerda --}}
            <div class="col-lg-4">
                <div class="row my-3">
                    <div class="col-5">
                        <a href="#" class="btn btn-primary w-100">Voltar</a>
                    </div>
                    <form id="id-form-novo-pedido" class="col-7" method="POST" action="/pedido/1">
                        @csrf
                        <input type="submit" class="btn btn-info w-100" value="Novo Pedido">
                    </form>
                </div>
                <div id="list-pedidos" class="list-group my-3">
                    @foreach ($pedidos as $pedido)
                        @if ($loop->first)
                            <a href="#" class="list-group-item list-group-item-action active" data-toggle="list" value={{$pedido->id}}>Pedido {{$pedido->id}}</a>    
                        @else
                            <a href="#" class="list-group-item list-group-item-action" data-toggle="list" value={{$pedido->id}}>Pedido {{$pedido->id}}</a>    
                        @endif
                    @endforeach
                </div>
            </div>
            {{-- Parte do meio --}}
            <div class="col-lg-4">
                <h2 class="text-center my-3">Adicione Produtos</h2>
                {{-- Formulario de Tipo de Produto --}}
                <form action="">
                    @csrf
                    <div class="form-group">
                        <select id="id-selecao-tipo-produto" class="form-control">
                            @foreach ($tipoProdutos as $tipoProduto)
                                <option value={{$tipoProduto->id}}>{{$tipoProduto->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                {{-- Formulario de Produto --}}
                <form action="">
                    @csrf
                    <div class="form-group">
                        <select id="id-selecao-produto" class="form-control">
                            @foreach ($produtos as $produto)
                                <option value={{$produto->id}}>{{$produto->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <input id="spinner" name="value" value=1>
                {{-- Botão adicionar produto no pedido --}}
                <form id="id-form-add-pedido-produto" method="POST" class="my-3" action="#">
                    @csrf
                    <input id="id-botao-adicionar-produto" type="submit" class="btn btn-success w-100" value="Adicionar Produto">
                </form>
                {{-- Formulario de Endereço --}}
                <form id="id-form-endereco" action="">
                    @csrf
                    <div class="form-group">
                        <select id="id-selecao-endereco" class="form-control">
                            @foreach ($enderecos as $endereco)
                                @if ($pedidos[0]->Enderecos_id == $endereco->id)
                                    <option value={{$endereco->id}} selected>
                                        {{$endereco->logradouro}}, nº {{$endereco->numero}}. {{$endereco->bairro}}
                                        @if ($endereco->complemento)
                                            . {{$endereco->complemento}}    
                                        @endif
                                    </option>
                                @else
                                    <option value={{$endereco->id}}>
                                        {{$endereco->logradouro}}, nº {{$endereco->numero}}. {{$endereco->bairro}}
                                        @if ($endereco->complemento)
                                            . {{$endereco->complemento}}    
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                            @if (isset($pedidos[0]) && $pedidos[0]->Enderecos_id == null)
                                <option value=null selected>Retirar no local</option>
                            @else
                                <option value=null>Retirar no local</option>
                            @endif
                        </select>
                    </div>
                </form>
                {{-- Botão enviar --}}
                <form id="id-form-enviar-pedido" method="POST" class="my-3" action="#">
                    @csrf
                    <input type="submit" class="btn btn-info w-100" value="Enviar Pedido">
                </form>
            </div>
            {{-- Parte da direita --}}
            <div class="col-lg-4">
                <div class="form-group my-3">
                    <input id="id-text-status" type="text" class="form-control text-center" id="id-text-status" value="Estado: {{$estado}}" readonly>
                </div>
                <div id="list-produtos" class="list-group my-3">
                    @foreach ($produtosPedido as $produtoPedido)
                        <span href="#" class="list-group-item" value1={{$produtoPedido->Pedidos_id}} value2={{$produtoPedido->Produtos_id}}>
                            {{$produtoPedido->descricao}} - {{$produtoPedido->nome}} - {{$produtoPedido->quantidade}}x
                            <svg data-toggle="modal" data-target="#destroyModal" value="/pedidoproduto/{{$produtoPedido->Pedidos_id}}/{{$produtoPedido->Produtos_id}}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash icons-list-produto destroyButton" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </span>
                    @endforeach
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Valor total">
                    <div class="input-group-append">
                        <span class="input-group-text">R$</span>
                        <span id="id-spam-preco" class="input-group-text">{{$totalPedido}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="destroyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Remover recurso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            Deseja realmente remover este recurso?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <form id="destroyForm" method="POST" action="">
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <input type="submit" class="btn btn-danger" value="Confirmar">
            </form>
            </div>
        </div>
        </div>
    </div>

    <script>
        const destroyButtons = document.querySelectorAll(".destroyButton");
        const destroyForm = document.querySelector("#destroyForm");
        destroyButtons.forEach(destroyButton => {
            destroyButton.addEventListener('click', configureAction);
        });
        function configureAction(){
            destroyForm.setAttribute('action', this.getAttribute('value'));
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src={{ asset('js/pedido.js') }}></script>
</body>
</html>