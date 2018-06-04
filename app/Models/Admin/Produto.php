<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Admin;
use Core\EloquentModel;
/**
 * Description of Produto
 *
 * @author Wesllen
 */
class Produto extends EloquentModel{
    public $table = "produto";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = ['id', 'nomeProduto', 'descricaoProduto', 'qtdEstoque', 'valor', 'fotoProduto', 'DataModificado'];
    
    
    public function fornecedor(){
        return $this->hasOne(Fornecedor::class, 'user_id', 'id');
    }
    
}
