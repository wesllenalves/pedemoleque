<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Admin;

use Core\BaseModel;

/**
 * Description of Cadastro
 *
 * @author laboratorio
 */
class CadastroProduto extends BaseModel {
    //definir os nomes da tabelas maximo de 4
    protected $tabela = "produto";
    
    //Definir a quantidade de tabelas que serao usadas maximo de 4
    protected $tabelaUse = 1;    

    public function cadastrar($dados) {

        
        $array = array(
            "0" =>
            array(
                "nome" => $dados->nome, "valorUnitario" => $dados->valorUnitario, "valorGasto" => $dados->valorGasto,
                "qtd" => $dados->qtd, "qtdMin" => $dados->qtdMin, "validade" => $dados->validade,
                "categoria" => $dados->categoria
            )
            
        );


        if ($this->insert($array)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
