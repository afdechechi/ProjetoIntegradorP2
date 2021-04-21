<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\TipoProduto;
use App\Produto;
use App\Pedido;
use App\Endereco;
use App\PedidoProduto;
use Carbon\Carbon;

class PedidoController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



       // selecionar id do usuário que está logado.
        $user_id = \Auth::user()->id;
        // Buscar os dados que estão na tabela Pedidos
        $pedidos = Pedido::where('Users_id', $user_id)->orderBy('Pedidos.id', 'DESC')->get();
        // Buscar os dados que estão na tabela Tipo_Produtos
        $tipoProdutos = TipoProduto::all();
        // Buscar os produtos do primeiro tipo encontrado
        $produtos = [];
        if(!$tipoProdutos->isEmpty()){
            $firstTipoProduto = $tipoProdutos->first();
            // Buscar o produto com determinado id
            $produtos = Produto::where('Tipo_Produtos_id', $firstTipoProduto->id)->get();
        }
        // Buscar os endereços do usuário logado
        $enderecos = DB::select("select * from Enderecos where Users_id = ?", [$user_id]);
        // Buscar os produtos dentro do ultimo pedido
        $produtosPedido = [];
        $totalPedido = 0;
        $estado = "";
        if(!$pedidos->isEmpty()){
            $ultimoPedidoRealizado = $pedidos->first();
            // Buscar os produtos dentro de um determinado pedido
            $produtosPedido = DB::select("select Pedido_Produtos.Pedidos_id, Pedido_Produtos.Produtos_id, Pedido_Produtos.quantidade, Produtos.nome, Tipo_Produtos.descricao from Pedido_Produtos
                                          join Produtos on Pedido_Produtos.Produtos_id = Produtos.id
                                          join Tipo_Produtos on Produtos.Tipo_Produtos_id = Tipo_Produtos.id
                                          where Pedido_Produtos.Pedidos_id = ?", [$ultimoPedidoRealizado->id]);
            // Calcula o total de R$ do pedido
            if(!empty($produtosPedido)){
                $totalPedido = DB::select("select sum(Pedido_Produtos.quantidade * Produtos.preco) as total_pedido from Pedido_Produtos
                                            join Produtos on Pedido_Produtos.Produtos_id = Produtos.id
                                            where Pedido_Produtos.Pedidos_id = ?", [$ultimoPedidoRealizado->id])[0];
                $totalPedido = $totalPedido->total_pedido;
            }
            // Verifica o estado do pedido e envia para view
            switch ($ultimoPedidoRealizado->status) {
                case 'R':
                    $estado = "Recebido";
                    break;
                case 'C':
                    $estado = "Cancelado";
                    break;
                case 'P':
                    $estado = "Produção";
                    break;
                case 'E':
                    $estado = "Enviado";
                    break;
                case 'A':
                    $estado = "Aberto";
                    break;
            }
        }
        return view('Pedido.index')->with('pedidos', $pedidos)->with('tipoProdutos', $tipoProdutos)->with('produtos', $produtos)->with('enderecos', $enderecos)->with('produtosPedido', $produtosPedido)->with('totalPedido', $totalPedido)->with('estado', $estado);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $endereco_id)
    {
        // Pega o id do usuário logado
        $user_id = \Auth::user()->id;
        // Verificar de o conteúdo da variável $endereco_id é nulo (se á variável foi definida)
        if( isset($endereco_id) && $endereco_id != 'null' ) {
            $endereco = Endereco::find($endereco_id);
            // Verifico se foi encontrado algo e se o que foi encontrado pertence ao usuário logado
            if($endereco && $endereco->Users_id == $user_id)
            {
                $pedido = new Pedido();
                $pedido->dataEHora = Carbon::now()->toDateTimeString();
                $pedido->status = "A";
                $pedido->Users_id = $user_id;
                $pedido->Enderecos_id = $endereco_id;
                try {
                    $pedido->save();
                } catch (\Throwable $th) {
                    $response['success'] = false;
                    $response['message'] = "Erro ao salvar pedido.";
                    $response['return'] = [];
                    return response()->json($response, 507);
                }
                $pedidos = Pedido::where('Users_id', $user_id)->orderBy('id', 'DESC')->get();
                $response['success'] = true;
                $response['message'] = "Pedido criado com sucesso.";
                $response['return'] = $pedidos;
                return response()->json($response, 201);
            }
            $response['success'] = false;
            $response['message'] = "Endereço não pertence ao usuário.";
            $response['return'] = [];
            return response()->json($response, 403);
        }
        $pedido = new Pedido();
        $pedido->dataEHora = Carbon::now()->toDateTimeString();
        $pedido->status = "A";
        $pedido->Users_id = $user_id;
        $pedido->Enderecos_id = null;
        try {
            $pedido->save();
        } catch (\Throwable $th) {
            $response['success'] = false;
            $response['message'] = "Erro ao salvar pedido.";
            $response['return'] = [];
            return response()->json($response, 507);
        }
        $pedidos = Pedido::where('Users_id', $user_id)->orderBy('id', 'DESC')->get();
        $response['success'] = true;
        $response['message'] = "Pedido criado com sucesso.";
        $response['return'] = $pedidos;
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enviarPedido(Request $request, $pedido_id)
    {
        $pedido = Pedido::find($pedido_id);
        if(isset($pedido)){
            try {
                $pedido->status = 'E';
                $pedido->update();
            } catch (\Throwable $th) {
                $response['success'] = false;
                $response['message'] = "Não foi possível atualizar o pedido.";
                $response['return'] = [];
                return response()->json($response, 507);
            }
            $response['success'] = true;
            $response['message'] = "Pedido enviado com sucesso.";
            $response['return'] = $pedido;
            return response()->json($response, 201);
        }
        $response['success'] = false;
        $response['message'] = "Pedido não encontrado.";
        $response['return'] = [];
        return response()->json($response, 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function alterarEndereco(Request $request, $pedido_id, $endereco_id){
        // Pego o id do usuário logado
        $user_id = \Auth::user()->id;
        // Verificar se o pedido existe
        $pedido = Pedido::find($pedido_id);
        if(isset($pedido_id)) {
            // Verificar se o pedido pertence ao usuário logado
            if($pedido->Users_id == $user_id) {
                // Verificar se o endereço pertence ao usuário
                if($endereco_id != 'null') {
                    // Verifico se o endereço existe e se pertence ao usuário logado
                    $endereco = Endereco::find($endereco_id);
                    if(isset($endereco) && $endereco->Users_id == $user_id) {
                        $pedido->Enderecos_id = $endereco_id;
                        try {
                            $pedido->update();
                        } catch (\Throwable $th) {
                            $response['success'] = false;
                            $response['message'] = "Não foi possível atualizar o pedido.";
                            $response['return'] = [];
                            return response()->json($response, 507);
                        }
                        $response['success'] = true;
                        $response['message'] = "Endereço do pedido alterado com sucesso.";
                        $response['return'] = $pedido;
                        return response()->json($response, 201);
                    }
                    $response['success'] = false;
                    $response['message'] = "Endereço não pertence ao usuário.";
                    $response['return'] = [];
                    return response()->json($response, 404);
                }
                $pedido->Enderecos_id = null;
                try {
                    $pedido->update();
                } catch (\Throwable $th) {
                    $response['success'] = false;
                    $response['message'] = "Não foi possível atualizar o pedido.";
                    $response['return'] = [];
                    return response()->json($response, 507);
                }
                $response['success'] = true;
                $response['message'] = "Endereço do pedido alterado com sucesso.";
                $response['return'] = $pedido;
                return response()->json($response, 201);
            }
            $response['success'] = false;
            $response['message'] = "Pedido não pertence ao usuário.";
            $response['return'] = [];
            return response()->json($response, 404);
        }
        $response['success'] = false;
        $response['message'] = "Pedido inválido.";
        $response['return'] = [];
        return response()->json($response, 404);
    }
}
