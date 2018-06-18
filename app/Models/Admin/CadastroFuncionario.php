<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Admin;
use Core\BaseModel;

class CadastroFuncionario extends BaseModel{
     protected $tabela = "funcionario";
    //Definir a quantidade de tabelas que serao usadas maximo de 4
    protected $tabelaUse = 1;
    
    protected function CheckIsNull($request) {
        
        if ( $request->nome === '' ||  $request->cpf === '' ||   $request->perfil === '' || 
             $request->login === '' ||  $request->senha === '' || $request->senha2 === '' || 
             $request->cidade === '' || $request->cep === '' ||   $request->endereco === '' ||   $request->uf === '' ||  
             $request->complemento === ''
                ) {
            return TRUE;
        }
        return FALSE;
    }
    
    protected function checkExists($request){
        $sql = "cpf = '{$request->cpf}' and login = '{$request->login}'";
       $check = $this->read("*", $sql);
        if (count($check) > 0) {

            return TRUE;
        }
        return FALSE;
    }
    
    
    
    public function cadastrar($request){    
        
        
        if($this->CheckIsNull($request) != TRUE){            
           if($this->checkExists($request) !=TRUE){
        
                $array = array(
                    "0" => array(
                        'nome' => $request->nome, 'cpf' => $request->cpf, 
                        'perfil' => $request->perfil, 'login' => $request->login, 'senha' => $request->senha, 
                        'cidade' => $request->cidade, 'cep' => $request->cep, 'endereco' => $request->endereco, 
                        'uf' => $request->uf, 'complemento' => $request->complemento
                    )
                );

                if($this->insert($array)){
                    return TRUE;
                }else{
                    return False;
                }
        }else{
              $this->redirect("dashboard/funcionario", "2", 'Dados ja cadastrado');
             exit(); 
           }    
        }else{
            $this->redirect("dashboard/funcionario", "4", "Preencha todos os campos");
            exit();
        }
    }
}
