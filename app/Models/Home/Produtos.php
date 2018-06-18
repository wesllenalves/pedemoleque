<?php
namespace App\Models\Home;
use Core\EloquentModel;
use App\Models\Home\Fornecedor;

class Produtos extends EloquentModel{
    
    public $table = "produto";
    public $timestamps = false;
    
    protected $fillable   = ['user_id', 'nomeProduto', 'descricaoProduto', 'qtdEstoque', 'valor', 'fotoProduto', 'DataModificado', 'FKFornecedor'];
    
    public function Fornecedor(){
        return $this->hasMany(Fornecedor::class, 'user_id');
    }

//        public function produto(){
//        return $this->where('codigoProduto', '=', 1)->get();
//    }

    

//    public function ler(){
//        $codicoes =  "produto as p JOIN fornecedor as f ON p.FKFornecedor = f.  codigoFornecedor";
//        $dados = $this->readChave($codicoes);        
//        return $dados;
//    }
}
