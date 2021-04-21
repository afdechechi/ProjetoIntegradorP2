<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Create de Produto</title>
</head>
<body>
    <div class="container">
        <form method="post" action={{route('produto.store')}}>
            @csrf
            <div class="form-group">
              <label for="input-ID">ID</label>
              <input type="text" class="form-control" id="input-ID" aria-describedby="ID-help" value="#" disabled>
              <small id="ID-help" class="form-text text-muted">Não é necessário informor um ID para cadastrar um novo recurso</small>
            </div>
            <div class="form-group">
              <label for="input-nome">Nome</label>
              <input name="nome" type="text" class="form-control" id="input-nome" placeholder="Informe o nome do recurso">
            </div>
            <div class="form-group">
                <label for="input-preco">Preço</label>
                <input name="preco" type="text" class="form-control" id="input-preco" placeholder="Informe o preço do recurso">
            </div>
            <div class="form-group">
                <label for="input-tipo-produto">Tipo de Produto</label>
                <select id="input-tipo-produto" class="form-control" name="Tipo_Produtos_id">
                    @foreach ($tipoProdutos as $tipoProduto)
                        <option value={{$tipoProduto->id}}>{{$tipoProduto->descricao}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
            <a href={{route('produto.index')}} class="btn btn-primary">Voltar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>