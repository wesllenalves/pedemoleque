<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;
use Core\BaseController;
use App\Models\Home\Produtos;
use App\Models\Home\Cliente;
use Core\Validator;
use Core\Funcoes;
use Core\Session;
/**
 * Description of ClienteController
 *
 * @author Wesllen
 */
class ClienteController extends BaseController{
    
    public function minhaconta() {
        session_start();
        $id = $_SESSION['id']; 
        
        $dados = Cliente::with('endereco')->where('id', '=', $id)->get();
        
        $this->view->Clientes = json_decode($dados, true);
        $this->Render("home/minhaconta", 'layoutHome');        
    }
    
    public function minhacontaeditar(){
        session_start();
        
        $id = $_SESSION['id']; 
                
        $dados = Cliente::with('endereco')->where('id', '=', $id)->get();        
        $this->view->Clientes = json_decode($dados, true);
        
        $this->Render("home/editar", 'layoutHome');
    }
    
    public function minhaContaEditarEnviar($request){
        $post = (array) $request->post;
        
        $nome = addslashes($post['nome']);
        $email = addslashes($post['email']);
        $senha = addslashes($post['senha']);
        $salt = password_hash($senha, PASSWORD_DEFAULT);
        $cpf = addslashes($post['cpf']);
        $dataNasc = addslashes($post['dataNasc']);
        $celular = addslashes($post['celular']);
        $telefoneFixo = addslashes($post['telefoneFixo']);
        $tipoUsuario = "comun";
        $cep = addslashes($post['cep']);
        $rua = addslashes($post['rua']);
        $bairro = addslashes($post['bairro']);
        $cidade = addslashes($post['cidade']);
        $estado = addslashes($post['uf']);
        $complemento = addslashes($post['complemento']);
        $id = addslashes($post['id']);
        
        $data = [
            "nomeCliente" => $nome, "email" => $email, "senha" => Funcoes::base64($senha, 1), "cpf" => $cpf,
            "dataNas" => $dataNasc, "celular" => $celular, "telefoneFixo" => $telefoneFixo,
            "dataCadas" => Funcoes::dataAtual(2), "cep" => $cep, "rua" => $rua,
            "bairro" => $bairro, "cidade" => $cidade, "estado" => $estado, "complemento" => $complemento
        ];
        $rules = [
            'nomeCliente' => 'required', 'email' => 'required|email', 'senha' => 'required|min:6',
            'cpf' => 'required', 'dataNas' => 'required', 'celular' => 'required', 'telefoneFixo' => 'required',
             'cep' => 'required', 'rua' => 'required', 'bairro' => 'required',
            'cidade' => 'required', 'estado' => 'required', 'complemento' => 'required'
        ];
        
        if(Validator::make($data, $rules)){
            $this->redirect('cliente/minhaconta');
        }
        
        if (Cliente::CheckCpf($post) == TRUE) {
            //verifica se o cpf e valido se nao redireciono para a pagina cadastro com uma sessao de erro            
            $this->redirect('cliente/minhaconta/editar', '4', 'Por favor digite um CPF válido!');
            exit;
        } elseif (Cliente::CheckRepitaSenha($post)) {
            //Verifica se as senhas conicidem se não volta para pagina de castrados com uma sessao de erro
            $this->redirect('cliente/minhaconta/editar', '4', 'Por favor digite as senhas iguais');
            exit;
        }
        
        $dadosForm = [
                "nomeCliente" => $nome, "email" => $email, "senha" => Funcoes::base64($senha, 1), "salt" => $salt,
                "cpf" => $cpf, "dataNas" => $dataNasc, "celular" => $celular, "telefoneFixo" => $telefoneFixo,
                "tipoUsuario" => $tipoUsuario, "dataCadas" => Funcoes::dataAtual(2)];
        
        $dadosformEnder = ["cep" => $cep, "rua" => $rua,
                "bairro" => $bairro, "cidade" => $cidade, "estado" => $estado, "complemento" => $complemento
            ];
        
        
        $cliente = Cliente::find($id);        
        
        if ($cliente) {
                $cliente->update($dadosForm);
                $cliente->endereco()->update($dadosformEnder);
                $data = Session::getInstance();
                $data->id = $id;
                $data->logado = "sim";
                $this->redirect('cliente/minhaconta', '1', 'Cadastrado com Sucesso');
                exit;
            } else {
                $data->logado = "sim";
                $data->id = $id;
                $this->redirect('cliente/minhaconta/editar', '4', 'Não foi possivel fazer seu Cadastro por favor entre em contato com email suporte@suport.com');
                exit;
            }
    }
    
    public function ListaCompras($request){
        $post = (array) $request->get;
        $id = addslashes($post['id']);
        print_r($id);
    }
    public function comprar($request){
        $post = (array) $request->post;
        
        print_r($post);
    }

    public function deletar($request){
        $post = (array) $request->get;
        $id = addslashes($post['id']);
        $cliente = Cliente::where("id", "=", $id)->delete();        
        if($cliente){
            session_start();
            session_destroy();
            session_unset();
            $this->redirect('index');
        }
    }
}
