<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PedidoProduto extends Model
{
    public $primaryKey = 'Pedidos_id';

    protected function setKeysForSaveQuery(Builder $query){
        $query->where('Pedidos_id', '=', $this->Pedidos_id);
        $query->where('Produtos_id', $this->Produtos_id);
        return $query; 
    }
}

