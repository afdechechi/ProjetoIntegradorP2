<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Endereco;

class EnderecoController extends Controller
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
        // Pega o usuário logado
        $user_id = 1;
        // Buscar os dados que estão na tabela Produtos
        $enderecos = Endereco::where('Users_id', $user_id)->get();
        return view('Endereco.index')->with('enderecos', $enderecos)->with('message', $message);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Endereco.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Pega o id do usuário logado
        $user_id = 1;
        
        $endereco = new Endereco();
        $endereco->Users_id = $user_id;
        $endereco->bairro = $request->bairro;
        $endereco->logradouro = $request->logradouro;
        $endereco->numero = $request->numero;
        $endereco->complemento = $request->complemento;
        try{
            $endereco->save();
        } catch (\Throwable $th) {
            // Constrói a mensagem
            $message['type'] = 'danger';
            $message['message'] = "Problema ao salvar o endereço: " . $th->getMessage();
            // Retorna a execução do método indexMessage
            return $this->indexMessage($message);
        }
        // Constrói a mensagem
        $message['type'] = 'success';
        $message['message'] = 'Endereço cadastrado com sucesso';
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
        $endereco = Endereco::find($id);
        if(isset($endereco))
        {
            return view('Endereco.show')->with('endereco', $endereco);
        }
        // Constrói a mensagem
        $message['type'] = 'danger';
        $message['message'] = 'Endereço não encontrado';
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
        $endereco = Endereco::find($id);
        if(isset($endereco))
        {
            return view('Endereco.edit')->with('endereco', $endereco);
        }
        // Constrói a mensagem
        $message['type'] = 'danger';
        $message['message'] = 'Endereco não encontrado.';
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
        // Buscar os dados que estão na tabela Endereco
        $endereco = Endereco::find($id);
        if(isset($endereco))
        {
            $endereco->bairro = $request->bairro;
            $endereco->logradouro = $request->logradouro;
            $endereco->numero = $request->numero;
            $endereco->complemento = $request->complemento;
            try {
                $endereco->update();
            } catch (\Throwable $th) {
                // Constrói a mensagem
                $message['type'] = 'danger';
                $message['message'] = "Problema ao atualizar o endereço: " . $th->getMessage();
                // Retorna a execução do método indexMessage
                return $this->indexMessage($message);
            }
            // Constrói a mensagem
            $message['type'] = 'success';
            $message['message'] = 'Endereço atualizado com sucesso';
            // Retorna a execução do método indexMessage
            return $this->indexMessage($message);
        }
        // Constrói a mensagem
        $message['type'] = 'danger';
        $message['message'] = 'Endereço não encontrado';
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
        $endereco = Endereco::find($id);
        if(isset($endereco))
        {
            try {
                $endereco->delete();
            } catch (\Throwable $th) {
                // Constrói a mensagem
                $message['type'] = 'danger';
                $message['message'] = "Problema ao remover o endereço: " . $th->getMessage();
                // Retorna a execução do método indexMessage
                return $this->indexMessage($message);
            }
            // Constrói a mensagem
            $message['type'] = 'success';
            $message['message'] = 'Endereço removido com sucesso';
            // Retorna a execução do método indexMessage
            return $this->indexMessage($message);
        }
        // Constrói a mensagem
        $message['type'] = 'danger';
        $message['message'] = 'Endereço não encontrado';
        // Retorna a execução do método indexMessage
        return $this->indexMessage($message);
    }
}
