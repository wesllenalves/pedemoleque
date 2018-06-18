<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Home;
use Core\EloquentModel;

class Endereco extends EloquentModel{
    public $table = "endereco";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = ['id', 'cliente_id', 'cep', 'rua', 'bairro', 'cidade', 'estado', 'complemento'];
    
    public function cliente(){
        return $this->hasOne(Cliente::class);
    }    
    
}
