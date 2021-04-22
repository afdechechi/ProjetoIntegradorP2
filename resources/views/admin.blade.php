@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-light">Admin Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                        <p></p>
                        <a href='pedido' class="btn btn-lg btn-primary">Pedidos</a>
                        <p></p>
                        <a href='produto' class="btn btn-lg btn-primary">Produtos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
