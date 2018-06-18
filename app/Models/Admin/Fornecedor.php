<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Admin;
use Core\EloquentModel;

class Fornecedor extends EloquentModel{
    public $table = "fornecedor";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = ['id', 'user_id', 'cnpj', 'nomeFornecedor', 'telefone', 'email', 'DataModificado'];
    
    public function fornecedor(){
        return $this->hasOne(Produto::class);
    }
}
