<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use Core\BaseController;
use App\Models\Admin\Produto;
use Core\Funcoes;
use Core\Validator;

/**
 * Description of AdminController
 *
 * @author laboratorio
 */
class AdminController extends BaseController {

    public function index() {
        $this->setPageTitle("Admin");
        $this->Render('admin/index', 'layoutadmin');
    }

    public function produto() {
        (array) $dados = Produto::with('fornecedor')->get();
        $this->view->Produtos = json_decode($dados, true);
        $this->Render('admin/produtos', 'layoutadmin');
    }

    public function viewCadastroProduto() {
        $this->Render('admin/adicionarProdutos', 'layoutadmin');
    }

    public function cadastroProduto($request) {
        //atribui a ua variavel todos os dados passados por post
        $post = (array) $request->post;
        //chama o metodo resposavel pelo cadastro
        $data = [
            "nomeProduto" => $post['nomeProduto'], "descricaoProduto" => $post['descricaoProduto'], "qtdEstoque" => $post['quantidadeProduto'],
            "valor" => $post['valor'], "cnpjFornecedor" => $post['cnpjFornecedor'], "nomeFornecedor" => $post['nomeFornecedor'],
            "telefoneFornecedor" => $post['telefoneFornecedor'], "email" => $post['emailFornecedor']
        ];

        $rules = [
            'nomeProduto' => 'required', 'descricaoProduto' => 'required|email', 'qtdEstoque' => 'required|min:6',
            'valor' => 'required', 'cnpj' => 'required', 'nomeFornecedor' => 'required', 'telefone' => 'required', 'email' => 'required'
        ];
//        if(Validator::make($data, $rules)){
//            $this->redirect('admin/cadastro/produto');
//            exit();
//        }



        if ($_FILES['imagem'] && !empty($_FILES['imagem']['tmp_name'])) {
            $_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');
            //Tamanho máximo do arquivo em Bytes
            $_UP['tamanho'] = 1024 * 1024 * 100; //5mb
            // Faz a verificação da extensao do arquivo			
            $extensao = explode('.', $_FILES['imagem']['name']);
            $extensao_saida = end($extensao);

            $novo_nome = md5(time()) . "." . $extensao_saida;
            //$novo_nome = $_POST["nomeProduto"] . "." . $extensao_saida;            
            $diretorio = __DIR__ . "/../../public/img/produtos/";

            if (array_search($extensao_saida, $_UP['extensoes']) === false) {
                echo "A imagem não foi cadastrada extesão inválida.";
            } else if ($_UP['tamanho'] < $_FILES['imagem']['size']) {
                echo "Arquivo muito grande.";
            } else {
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio . $novo_nome)) {
                    $dadosForm = [
                        "nomeProduto" => $post['nomeProduto'], "descricaoProduto" => $post['descricaoProduto'], "qtdEstoque" => $post['quantidadeProduto'],
                        "valor" => $post['valor'], "fotoProduto" =>$novo_nome, "DataModificado" =>Funcoes::dataAtual(2), "cnpj" => $post['cnpjFornecedor'],
                        "nomeFornecedor" => $post['nomeFornecedor'],"telefone" => $post['telefoneFornecedor'], "email" => $post['emailFornecedor'], 
                        "DataModificado" => Funcoes::dataAtual(2)
                    ];
                    
                    $produto = Produto::create($dadosForm);
                    if ($produto) {
                        $produto->fornecedor()->create($dadosForm);
                        $this->redirect('admin/produtos', '1', 'Cadastrado com sucesso');
                    } else {
                        $this->redirect('admin/produtos', '4', 'Erro ao tentar cadastrar');
                    }
                }
            }
        } else {
            $produto = Produto::create($data);
            if ($produto) {
                $this->redirect('admin/produtos', '1', 'Cadastrado com sucesso');
            } else {
                $this->redirect('admin/produtos', '4', 'Erro ao tentar cadastrar');
            }
        }
    }

    public function listarCliente() {

        $this->view->clientes = $this->Cliente->listarAll();
        $this->Render("admin/lista-cliente");
    }

    public function editarCliente($id) {

        $clientesEditar = $this->Cliente->listarWhere($id);
        $this->view->clientesEditar = $clientesEditar;
        $this->Render("admin/editar-clientes");
    }

    public function updateCliente($request) {
        $id = $request->post->id;


        $data = [
            'nome' => $request->post->nome, 'cpf' => $request->post->cpf, 'senha' => $request->post->senha,
            'confirmaSenha' => $request->post->confirmaSenha, 'tipoCliente' => $request->post->tipoCliente,
            'email' => $request->post->email, 'login' => $request->post->login, 'cidade' => $request->post->cidade,
            'cep' => $request->post->cep, 'endereco' => $request->post->endereco, 'uf' => $request->post->uf,
            'complemento' => $request->post->complemento
        ];

        $rules = [
            'nome' => 'required', 'cpf' => 'required', 'email' => 'required', 'login' => 'required',
            'senha' => 'required|min:6', 'confirmaSenha' => 'required|min:6', 'tipoCliente' => 'required',
            'cidade' => 'required', 'cep' => 'required', 'endereco' => 'required', 'uf' => 'required',
            'complemento' => 'required'
        ];


        if (Validator::make($data, $rules)) {
            $this->redirect("dashboard/alterar/cliente/{$id}");
        }

//        $dados = $request->post;        
//        if($this->Cliente->atualizar($dados)){
//            $this->redirect('dashboard/listar/clientes', '2', 'Atualizado com sucesso');
//        } else {
//            $this->redirect('dashboard/listar/clientes', '4', 'Erro ao tentar atualizar');
//        }
    }

    public function deleteCliente($id) {

        if ($this->Cliente->deletar($id)) {
            $this->redirect('dashboard/listar/clientes', '3', 'cadastrado Deletado');
        } else {
            $this->redirect('dashboard/listar/clientes', '4', 'Erro ao tentar deletar cadastro');
        }
    }
    
    public function logout(){
            session_start();
            session_destroy();
            session_unset();
            $this->redirect('index');
    }

}
