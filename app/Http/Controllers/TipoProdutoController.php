<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoProduto;
use DB;

class TipoProdutoController extends Controller
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
        // Buscar os dados que estão na tabela Tipo_Produtos
        $tipoProdutos = DB::select('select * from Tipo_Produtos');
        return view('TipoProduto.index')->with('tipoProdutos', $tipoProdutos)->with('message', $message);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('TipoProduto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipoProduto = new TipoProduto();
        $tipoProduto->descricao = $request->descricao;
        try {
            $tipoProduto->save();
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
        // Buscar os dados que estão na tabela Tipo_Produtos
        $tipoProduto = TipoProduto::find($id);
        if(isset($tipoProduto))
            return view('TipoProduto.show')->with('tipoProduto', $tipoProduto);
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
        $tipoProduto = TipoProduto::find($id);
        if(isset($tipoProduto))
            return view('TipoProduto.edit')->with('tipoProduto', $tipoProduto);
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
        $tipoProduto = TipoProduto::find($id);
        if(isset($tipoProduto))
        {
            $tipoProduto->descricao = $request->descricao;
            try {
                $tipoProduto->update();
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
        $tipoProduto = TipoProduto::find($id);
        if(isset($tipoProduto))
        {
            try {
                $tipoProduto->delete();
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
