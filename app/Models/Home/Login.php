<?php
namespace App\Models\Home;

use Core\Funcoes;
use Core\Session;
use Core\EloquentModel;
use App\Models\Home\Loginatteempt;


class Login extends EloquentModel {

    //seleciona a tabela
    protected $tabela = "cliente";

    //verifica se os dados enviados pelo cliente estão vazios
    public function CheckIsNull(array $array) {
        if ($array['email'] == '' || $array['senha'] == '') {
            return TRUE;
        }
        return FALSE;
    }  
    
    
    public function VerificarTentativas(array $array){
        $attp = new Loginatteempt();
        
        $email1 = addslashes($array['email']);
        $sql1 = "email='{$email1}';";
        $dadosUser1 = $this->read('*', $sql1);
        $user_id = $dadosUser1[0]; 
        $user_id = $user_id['codigoCliente'];        
        $r = $attp->TotalDeTentativas($user_id);
        if($r < 9){
            return TRUE; 
        }else{
            return FALSE;
        }
    }

    //Verifica se existe usuario cadastrado. Cria sessao caso exista
    public function autentication(array $array) {
        $attp = new Loginatteempt();
        $funcao = new Funcoes();
        $email = addslashes($array['email']);
        $senha = addslashes($array['senha']);      
        $sql = "email='{$email}' and senha='{$funcao->base64($senha, 1)}';";       
        $dadosUser = $this->read("*", $sql);
        if (count($dadosUser) > 0) {
            
               $salt = $dadosUser[0]['salt'];
               
            if (password_verify($array["senha"], $salt)) {
                
                $login = $dadosUser[0];
                $id = $dadosUser[0];
                $user_id = $id['codigoCliente'];
                $attp->LimparTentativa($user_id);
                $data = Session::getInstance();
                $data->authenticado = TRUE;
                $data->login = $login["nome"];
                $data->logado = "";
                $data->id = $id['codigoCliente'];         
                $data->tipoUsuario = $login['tipoUsuario'];                   
                return TRUE;
            
            }
            
        }
        
        $email1 = addslashes($array['email']);
        $sql1 = "email='{$email1}';";
        $dadosUser1 = $this->read('*', $sql1);
        $user_id = $dadosUser1[0]; 
        $user_id = $user_id['codigoCliente'];
        
        
                
        $attp->TotalDeTentativas($user_id);
        $attp->RegistraTentativa($user_id);
        
        return FALSE;
    }
    
    
    
    public function isAuth(){
        $data = Session::getInstance();
        
        if($data->authenticado){
           return TRUE; 
        }
        return FALSE;
        
    }
    
    
    
}
