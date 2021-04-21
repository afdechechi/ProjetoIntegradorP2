<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Show de Tipo Produto</title>
</head>
<body>
    <div class="container">
        <div class="form-group">
            <label for="input-ID">ID</label>
            <input type="text" class="form-control" id="input-ID" value={{$tipoProduto->id}} disabled>
        </div>
        <div class="form-group">
            <label for="input-desc">Descrição</label>
            <input type="text" class="form-control" id="input-desc" value={{$tipoProduto->descricao}} disabled>
        </div>
        <div class="form-group">
            <label for="input-update-at">Data de atualização</label>
            <input type="text" class="form-control" id="input-update-at" value={{$tipoProduto->updated_at}} disabled>
        </div>
        <div class="form-group">
            <label for="input-create-at">Data de criação</label>
            <input type="text" class="form-control" id="input-create-at" value={{$tipoProduto->created_at}} disabled>
        </div>
        <a href={{route('tipoproduto.index')}} class="btn btn-primary">Voltar</a>
    </div>      
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>