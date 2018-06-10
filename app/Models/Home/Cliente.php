<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Home;

use App\Models\Home\Loginatteempt;
use Core\EloquentModel;
use Core\Funcoes;
use Core\Session;

/**
 * Description of Cliente
 *
 * @author Wesllen
 */
class Cliente extends EloquentModel {

    public $table = "cliente";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = ['id', 'nomeCliente', 'email', 'senha', 'salt', 'cpf', 'dataNas', 'celular', 'telefoneFixo', 'tipoUsuario', 'dataCadas'];

    public function endereco() {
        return $this->hasOne(Endereco::class, 'cliente_id', 'id');
    }

    public function loginatteempt() {
        return $this->hasOne(Loginatteempt::class, 'user_id', 'id');
    }

    //verifica se o cpf digitado e valido
    public function CheckCpf(array $array) {
        $cpf = strlen($array['cpf']);

        if ($cpf >= 12 || $cpf < 11) {
            return TRUE;
        }
        return FALSE;
    } 
    
    //verifica se as senhas são iguais
    public static function CheckRepitaSenha(array $array) {
        if ($array['senha'] != $array['ReSenha']) {
            return TRUE;
        }
        return FALSE;
    }

    //Verifica se ja existe usuarios com os dados de email e cpf cadastrados
    public static function ExitsUser(array $array) {
        $dadosUser = Cliente::where('email', '=', $array['email'])->where('cpf', '=', $array['cpf']);        
        if (count($dadosUser) > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public static function VerificarTentativas(array $array) {
        $dadosUser = Cliente::where('email', '=', $array['email'])->first();
        $id = $dadosUser['id'];
        $result = Loginatteempt::TotalDeTentativas($id);
        if ($result <= 9) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Verifica se existe usuario cadastrado. Cria sessao caso exista
    public static function autentication(array $array) {
                
        $dadosUser = Cliente::where('email', '=', $array['email'])->where('senha', '=', Funcoes::base64($array['senha'], 1))->first();
        
        if($dadosUser){
        
        if (count($dadosUser) > 0) {
            
            $salt = $dadosUser['salt'];
            if (password_verify($array["senha"], $salt)) {                
                $id = $dadosUser['id'];            
                Loginatteempt::LimparTentativa($id);
                $data = Session::getInstance();
                $data->authenticado = TRUE;
                $data->nome = $dadosUser["nomeCliente"];
                $data->logado = "sim";
                $data->id = $dadosUser['id'];
                $data->tipoUsuario = $dadosUser['tipoUsuario'];
                return TRUE;
            }
        }
        $tentativas = Cliente::where('email', '=', $array['email'])->first();
        $id = $tentativas['id'];
        Loginatteempt::RegistraTentativa($id);
        return FALSE;
    }else {
        return FALSE;
    
            }


}

}
