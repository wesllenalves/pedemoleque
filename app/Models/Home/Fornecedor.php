<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Home;
use Core\EloquentModel;
use App\Models\Home\Produtos;

class Fornecedor extends EloquentModel{
   public $table = "fornecedor";
   public $timestamps = false;
   protected $primaryKey = 'user_id';
  protected $fillable   = ['user_id', 'cnpj', 'nomeFornecedor', 'telefone', 'email', 'DataModificado'];
    
   public function Produtos() {
        return $this->belongsTo(Produtos::class);
    }
   
}
