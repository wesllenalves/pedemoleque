<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Home;
use FrameworkWesllen\Date\Session;
use FrameworkWesllen\Date\Model;
/**
 * Description of MinhaConta
 *
 * @author laboratorio
 */
class MinhaConta extends Model {
    protected $tabela1 = "Cliente";
    protected $tabela2 = "Endereco";
    
    
    
    
    public function ler(){
        session_start();
       $id =  $_SESSION['id'];
        $sql = "Cliente as c JOIN Endereco as e ON c.codigoCliente = e.codigoEndereco";
        $dados = $this->readChave($sql, "*", "codigoCliente = '$id'");
        return $dados;
    }
}
