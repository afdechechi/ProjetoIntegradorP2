@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                        <p></p>
                        <a href='pedido' class="btn btn-lg btn-primary">Fazer Pedido</a>
                        <p></p>
                        <a href='endereco' class="btn btn-lg btn-primary">Adicionar Endereço</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
