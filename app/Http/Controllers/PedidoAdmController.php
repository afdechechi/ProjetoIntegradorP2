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

class PedidoAdmController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
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
        $produtos = []; 
        // Buscar os dados que estão na tabela Tipo_Produtos
        $tipoProdutos = TipoProduto::all();
        $produtosPedido = DB::select("select Pedido_Produtos.Pedidos_id, Pedido_Produtos.Produtos_id, Pedido_Produtos.quantidade, Produtos.nome, Tipo_Produtos.descricao from Pedido_Produtos
                                          join Produtos on Pedido_Produtos.Produtos_id = Produtos.id
                                          join Tipo_Produtos on Produtos.Tipo_Produtos_id = Tipo_Produtos.id");
        if(!$pedidos->isEmpty()){
            $ultimoPedidoRealizado = $pedidos->first();
            // Buscar os produtos dentro de um determinado pedido
            $produtosPedido = DB::select("select Pedido_Produtos.Pedidos_id, Pedido_Produtos.Produtos_id, Pedido_Produtos.quantidade, Produtos.nome, Tipo_Produtos.descricao from Pedido_Produtos
                                          join Produtos on Pedido_Produtos.Produtos_id = Produtos.id
                                          join Tipo_Produtos on Produtos.Tipo_Produtos_id = Tipo_Produtos.id
                                          ");
            // Calcula o total de R$ do pedido
            if(!empty($produtosPedido)){
                $totalPedido = DB::select("select sum(Pedido_Produtos.quantidade * Produtos.preco) as total_pedido from Pedido_Produtos
                                            join Produtos on Pedido_Produtos.Produtos_id = Produtos.id
            ");
            }
        }
        
        return view('PedidoAdm.index')->with('pedidos', $pedidos)->with('tipoProdutos', $tipoProdutos)->with('produtosPedido', $produtosPedido)->with('ultimoPedidoRealizado', $ultimoPedidoRealizado)->with('produtos', $produtos);
            
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
    public function store(Request $request)
    {
        //
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
}