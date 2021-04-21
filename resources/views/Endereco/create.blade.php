<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Create de Endereço</title>
</head>
<body>
    <div class="container">
        <form method="post" action={{route('endereco.store')}}>
            @csrf
            <div class="form-group">
              <label for="input-ID">ID</label>
              <input type="text" class="form-control" id="input-ID" aria-describedby="ID-help" value="#" disabled>
              <small id="ID-help" class="form-text text-muted">Não é necessário informor um ID para cadastrar um novo endereço</small>
            </div>
            <div class="form-group">
              <label for="input-bairro">Bairro</label>
              <input name="bairro" type="text" class="form-control" id="input-bairro" placeholder="Informe o bairro do endereço">
            </div>
            <div class="form-group">
                <label for="input-logradouro">Logradouro</label>
                <input name="logradouro" type="text" class="form-control" id="input-logradouro" placeholder="Informe o logradouro do endereço">
            </div>
            <div class="form-group">
                <label for="input-numero">Número</label>
                <input name="numero" type="text" class="form-control" id="input-numero" placeholder="Informe o número do endereço">
            </div>
            <div class="form-group">
                <label for="input-complemento">Complemento</label>
                <input name="complemento" type="text" class="form-control" id="input-complemento" placeholder="Informe o complemento do endereço">
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
            <a href={{route('endereco.index')}} class="btn btn-primary">Voltar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>