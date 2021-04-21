<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Produto;
use App\TipoProduto;

class ProdutoController extends Controller
{

    public function __construct(){
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna a execução do método indexMessage
        return $this->indexMessage(null);
    }

    /**
     * Display a listing of the resource. With message message
     *
     * @return \Illuminate\Http\Response
     */
    private function indexMessage($message)
    {
        // Buscar os dados que estão na tabela Produtos
        $produtos = DB::select("select Produtos.id, Produtos.nome, Produtos.preco, Tipo_Produtos.descricao from Produtos
                                join Tipo_Produtos on Produtos.Tipo_Produtos_id = Tipo_Produtos.id");                        
        return view('Produto.index')->with('produtos', $produtos)->with('message', $message);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Buscar os dados que estão na tabela Tipo_Produtos
        $tipoProdutos = DB::select('select * from Tipo_Produtos');
        return view('Produto.create')->with('tipoProdutos', $tipoProdutos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produto = new Produto();
        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->Tipo_Produtos_id = $request->Tipo_Produtos_id;
        try{
            $produto->save();
        } catch (\Throwable $th) {
            // Constrói a mensagem
            $message['type'] = 'danger';
            $message['message'] = "Problema ao salvar um recurso: " . $th->getMessage();
            // Retorna a execução do método indexMessage
            return $this->indexMessage($message);
        }
        // Constrói a mensagem
        $message['type'] = 'success';
        $message['message'] = 'Recurso cadastrado com sucesso';
        // Retorna a execução do método indexMessage
        return $this->indexMessage($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Buscar o dado que está na tabela Produtos
        $produto = Produto::find($id);
        if(isset($produto))
        {
            // Busca o dado que está na tabela Tipo_Produtos
            $tipoProduto = TipoProduto::find($produto->Tipo_Produtos_id);
            return view('Produto.show')->with('produto', $produto)->with('tipoProduto', $tipoProduto);
        }
        // Constrói a mensagem
        $message['type'] = 'danger';
        $message['message'] = 'Recurso não encontrado';
        // Retorna a execução do método indexMessage
        return $this->indexMessage($message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Buscar os dados que estão na tabela Tipo_Produtos
        $produto = Produto::find($id);
        if(isset($produto))
        {
            $tipoProdutos = DB::select('select * from Tipo_Produtos');
            return view('Produto.edit')->with('produto', $produto)->with('tipoProdutos', $tipoProdutos);
        }
        // Constrói a mensagem
        $message['type'] = 'danger';
        $message['message'] = 'Recurso não encontrado';
        // Retorna a execução do método indexMessage
        return $this->indexMessage($message);
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
        // Buscar os dados que estão na tabela Tipo_Produtos
        $produto = Produto::find($id);
        if(isset($produto))
        {
            $produto->nome = $request->nome;
            $produto->preco = $request->preco;
            $produto->Tipo_Produtos_id = $request->Tipo_Produtos_id;
            try {
                $produto->update();
            } catch (\Throwable $th) {
                // Constrói a mensagem
                $message['type'] = 'danger';
                $message['message'] = "Problema ao atualizar um recurso: " . $th->getMessage();
                // Retorna a execução do método indexMessage
                return $this->indexMessage($message);
            }
            // Constrói a mensagem
            $message['type'] = 'success';
            $message['message'] = 'Recurso atualizado com sucesso';
            // Retorna a execução do método indexMessage
            return $this->indexMessage($message);
        }
        // Constrói a mensagem
        $message['type'] = 'danger';
        $message['message'] = 'Recurso não encontrado';
        // Retorna a execução do método indexMessage
        return $this->indexMessage($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Produto::find($id);
        if(isset($produto))
        {
            try {
                $produto->delete();
            } catch (\Throwable $th) {
                // Constrói a mensagem
                $message['type'] = 'danger';
                $message['message'] = "Problema ao remover um recurso: " . $th->getMessage();
                // Retorna a execução do método indexMessage
                return $this->indexMessage($message);
            }
            // Constrói a mensagem
            $message['type'] = 'success';
            $message['message'] = 'Recurso removido com sucesso';
            // Retorna a execução do método indexMessage
            return $this->indexMessage($message);
        }
        // Constrói a mensagem
        $message['type'] = 'danger';
        $message['message'] = 'Recurso não encontrado';
        // Retorna a execução do método indexMessage
        return $this->indexMessage($message);
    }
}
