<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\Home\Produtos;
use App\Models\Home\Cliente;
use Core\Validator;
use Core\Funcoes;

class HomeController extends BaseController {

    public function index() {
        //seta o titulo da pagina
        echo $this->setPageTitle("Home");
        $dados = Produtos::with('Fornecedor')->get();
        $this->view->Produtos = json_decode($dados, true);
        //renderiza a pagina e o layout
        $this->Render('home/index', 'layoutHome');
    }

    public function login() {
        //seta o titulo da pagina
        echo $this->setPageTitle("Login");
        //renderiza a pagina e o layout
        $this->Render("home/login", 'layoutHome');
    }

    public function verificaLogin($request) {
        $post = (array) $request->post;        
        $data = [
            'email' => $post['email'], 'senha' => $post['senha']
        ];
        $rules = [
            'email' => 'required|email',
            'senha' => 'required|min:6'
        ];

        if (Validator::make($data, $rules)) {
            $this->redirect('index/login');
            exit();
        } else {
            if (isset($request->post->fazerLog)) {
                if (Cliente::VerificarTentativas($post) != TRUE) {
                    $this->redirect('index/login', '4', 'Você alcançou o numero de 10 tentativas frustadas de login entre em contato com o administrador');
                    exit;
                } elseif (Cliente::autentication($post)) {
                    if (($_SESSION['tipoUsuario']) === "comun") {
                        $this->redirect('index');
                        exit;
                    } else {
                        $this->redirect('admin');
                        exit;
                    }
                } else {
                    $this->redirect('index/login', '4', 'Usuário inválido');
                    exit;
                }
            }
        }
    }

    function indexCadastro() {
        //seta o titulo da pagina 
        $this->setPageTitle('Cadastrar');
        //renderiza a pagina
        $this->Render('home/cadastro', 'layoutHome');
    }

    function cadastroCliente($request) {
        session_start();
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

        $data = [
            "nomeCliente" => $nome, "email" => $email, "senha" => Funcoes::base64($senha, 1), "cpf" => $cpf,
            "dataNas" => $dataNasc, "celular" => $celular, "telefoneFixo" => $telefoneFixo,
            "tipoUsuario" => $tipoUsuario, "dataCadas" => Funcoes::dataAtual(2), "cep" => $cep, "rua" => $rua,
            "bairro" => $bairro, "cidade" => $cidade, "estado" => $estado, "complemento" => $complemento
        ];
        $rules = [
            'nomeCliente' => 'required', 'email' => 'required|email', 'senha' => 'required|min:6',
            'cpf' => 'required', 'dataNas' => 'required', 'celular' => 'required', 'telefoneFixo' => 'required',
            'tipoUsuario' => 'required', 'cep' => 'required', 'rua' => 'required', 'bairro' => 'required',
            'cidade' => 'required', 'estado' => 'required', 'complemento' => 'required'
        ];

        if (Validator::make($data, $rules)) {
            $this->redirect('index/cadastro');
        }


        if (Cliente::CheckCpf($post) == TRUE) {
            //verifica se o cpf e valido se nao redireciono para a pagina cadastro com uma sessao de erro            
            $this->redirect('index/cadastro', '4', 'Por favor digite um CPF válido!');
            exit;
        } elseif (Cliente::CheckRepitaSenha($post)) {
            //Verifica se as senhas conicidem se não volta para pagina de castrados com uma sessao de erro
            $this->redirect('index/cadastro', '4', 'Por favor digite as senhas iguais');
            exit;
        } elseif (Cliente::ExitsUser($post)) {
            $this->redirect('index/cadastro', '4', 'Ja Existe os Mesmos Dados Cadastrados no Banco');
            exit;
        } else {
            $dadosForm = [
                "nomeCliente" => $nome, "email" => $email, "senha" => Funcoes::base64($senha, 1), "salt" => $salt,
                "cpf" => $cpf, "dataNas" => $dataNasc, "celular" => $celular, "telefoneFixo" => $telefoneFixo,
                "tipoUsuario" => $tipoUsuario, "dataCadas" => Funcoes::dataAtual(2), "cep" => $cep, "rua" => $rua,
                "bairro" => $bairro, "cidade" => $cidade, "estado" => $estado, "complemento" => $complemento
            ];
            $cliente = Cliente::create($dadosForm);
            if ($cliente) {
                $cliente->endereco()->create($dadosForm);
                $this->redirect('index/cadastro', '1', 'Cadastrado com Sucesso');
                exit;
            } else {
                $this->redirect('index/cadastro', '4', 'Não foi possivel fazer seu Cadastro por favor entre em contato com email suporte@suport.com');
                exit;
            }
        }
    }

    public function checkout($request) {
        $id = $request->get;
        
        
//        $dados = Produtos::with('Fornecedor')->where("id","=", $id->id)->get();
//        $this->view->Checkouts = $dados;
        
        $this->Render('home/checkout', 'layoutHome'); 
    }

//    public function minhaconta() {
//        session_start();        
//        $id = $_SESSION['id']; 
//        
//        $dados = Cliente::with('endereco')->where('id', '=', $id)->get();
//        
//        $this->view->Clientes = json_decode($dados, true);
//        $this->Render("home/minhaconta", 'layoutHome');        
//    }
//    
//    public function minhacontaeditar(){
//        session_start();
//        
//        $id = $_SESSION['id']; 
//                
//        $dados = Cliente::with('endereco')->where('id', '=', $id)->get();        
//        $this->view->Clientes = json_decode($dados, true);
//        
//        $this->Render("home/editar", 'layoutHome');
//    }
//    
//    public function minhacontaeditarenviar($request){
//        $post = (array) $request->post;
//        
//        $nome = addslashes($post['nome']);
//        $email = addslashes($post['email']);
//        $senha = addslashes($post['senha']);
//        $salt = password_hash($senha, PASSWORD_DEFAULT);
//        $cpf = addslashes($post['cpf']);
//        $dataNasc = addslashes($post['dataNasc']);
//        $celular = addslashes($post['celular']);
//        $telefoneFixo = addslashes($post['telefoneFixo']);
//        $tipoUsuario = "comun";
//        $cep = addslashes($post['cep']);
//        $rua = addslashes($post['rua']);
//        $bairro = addslashes($post['bairro']);
//        $cidade = addslashes($post['cidade']);
//        $estado = addslashes($post['uf']);
//        $complemento = addslashes($post['complemento']);
//        $id = addslashes($post['id']);
//        
//        $data = [
//            "nomeCliente" => $nome, "email" => $email, "senha" => Funcoes::base64($senha, 1), "cpf" => $cpf,
//            "dataNas" => $dataNasc, "celular" => $celular, "telefoneFixo" => $telefoneFixo,
//            "dataCadas" => Funcoes::dataAtual(2), "cep" => $cep, "rua" => $rua,
//            "bairro" => $bairro, "cidade" => $cidade, "estado" => $estado, "complemento" => $complemento
//        ];
//        $rules = [
//            'nomeCliente' => 'required', 'email' => 'required|email', 'senha' => 'required|min:6',
//            'cpf' => 'required', 'dataNas' => 'required', 'celular' => 'required', 'telefoneFixo' => 'required',
//             'cep' => 'required', 'rua' => 'required', 'bairro' => 'required',
//            'cidade' => 'required', 'estado' => 'required', 'complemento' => 'required'
//        ];
//        
//        if(Validator::make($data, $rules)){
//            $this->redirect('index/cliente/minhaconta');
//        }
//        
//        if (Cliente::CheckCpf($post) == TRUE) {
//            //verifica se o cpf e valido se nao redireciono para a pagina cadastro com uma sessao de erro            
//            $this->redirect('index/cliente/minhaconta/editar', '4', 'Por favor digite um CPF válido!');
//            exit;
//        } elseif (Cliente::CheckRepitaSenha($post)) {
//            //Verifica se as senhas conicidem se não volta para pagina de castrados com uma sessao de erro
//            $this->redirect('index/cliente/minhaconta/editar', '4', 'Por favor digite as senhas iguais');
//            exit;
//        }
//        
//        $dadosForm = [
//                "nomeCliente" => $nome, "email" => $email, "senha" => Funcoes::base64($senha, 1), "salt" => $salt,
//                "cpf" => $cpf, "dataNas" => $dataNasc, "celular" => $celular, "telefoneFixo" => $telefoneFixo,
//                "tipoUsuario" => $tipoUsuario, "dataCadas" => Funcoes::dataAtual(2)];
//        
//        $dadosformEnder = ["cep" => $cep, "rua" => $rua,
//                "bairro" => $bairro, "cidade" => $cidade, "estado" => $estado, "complemento" => $complemento
//            ];
//        
//        
//        $cliente = Cliente::find($id);        
//        
//        if ($cliente) {
//                $cliente->update($dadosForm);
//                $cliente->endereco()->update($dadosformEnder);
//                $this->redirect('index/cliente/minhaconta/editar', '1', 'Cadastrado com Sucesso');
//                exit;
//            } else {
//                $this->redirect('index/cliente/minhaconta/editar', '4', 'Não foi possivel fazer seu Cadastro por favor entre em contato com email suporte@suport.com');
//                exit;
//            }
//    }

}
