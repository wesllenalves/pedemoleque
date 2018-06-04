<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;
use Core\Session;

/**
 * Description of BaseController
 *
 * @author Wesllen
 */
class BaseController {

    protected $view;
    private $viewPath;
    private $layoutPath;
    private $pageTitle;
    private $redirect;
    private $tipo;
    private $extenção;
    private $mensagem;
    

    public function __construct() {
        $this->view = new \stdClass();
    }

    protected function Render($view, $layoutPath = null, $extenção = null) {
        $this->viewPath = $view;
        $this->layoutPath = $layoutPath;
        $this->extenção = $extenção;
        

        //Se existir layout passa o caminho dele caso contrario passa so o caminho do arquivo da view
        if ($layoutPath) {
            return $this->layout();
        } else {
            return $this->content();
        }
    }
    
    protected function alerta(){
        if(isset($_SESSION['success'])){
            echo "<div class='row'> 
                    <div class='col-xs-12 col-md-12'>
                        <div class='alert alert-success' role='alert'>{$_SESSION['success']}</div>
                    </div>
                </div>";          
                unset($_SESSION['success']);
        }
        
        if(isset($_SESSION['info'])){
            echo "<div class='row'> 
                    <div class='col-xs-12 col-md-12'>
                        <div class='alert alert-info' role='alert'>{$_SESSION['info']}</div>
                    </div>
                </div>";          
                unset($_SESSION['info']);
        }
        
        if(isset($_SESSION['warning'])){
            echo "<div class='row'> 
                    <div class='col-xs-12 col-md-12'>
                        <div class='alert alert-warning' role='alert'>{$_SESSION['warning']}</div>
                    </div>
                </div>";          
                unset($_SESSION['warning']);
        }
        
        if(isset($_SESSION['danger'])){
            echo "<div class='row'> 
                    <div class='col-xs-12 col-md-12'>
                    <div class='alert alert-danger' role='alert'>";
            if(is_array($_SESSION['danger'])){
                foreach ($_SESSION['danger'] as $sessao ){
                   echo "{$sessao}<br>";
                }
                echo '</div></div>
                </div>';
            } else {
                echo $_SESSION['danger'].'</div></div>
                </div>';
            }
           
            
                      
                unset($_SESSION['danger']);
        }
    }

    protected function content() {
        $ext = empty($this->extenção) ? ".phtml" : ".". $this->extenção;
        if (file_exists(__DIR__ . "/../app/Views/{$this->viewPath}{$ext}")) {
            return require_once __DIR__ . "/../app/Views/{$this->viewPath}{$ext}";
        } else {          
            return Container::pageNotFoundView();
        }
    }

    protected function layout() {
        if (file_exists(__DIR__ . "/../app/Views/tamplate/{$this->layoutPath}.phtml")) {
            return require_once __DIR__ . "/../app/Views/tamplate/{$this->layoutPath}.phtml";
        } else {
            return Container::pageNotFoundLayout();
        }
    }

    protected function setPageTitle($pageTitle) {
        $this->pageTitle = $pageTitle;
    }

    protected function getPageTitle($separator = null) {
        if ($separator) {
            return $this->pageTitle . " " . $separator . " ";
        } else {
            return $this->pageTitle;
        }
    }

    protected function redirect($redirect, $tipo = null, $mensagem = null) {
        $this->redirect = $redirect;
        $this->tipo = $tipo;
        $this->mensagem = $mensagem;
        $this->getRedirect() === TRUE ?: Container::pageNotFoundLayout();
        $this->setSession();
    }

    protected function getRedirect() {
        header('Location:' . base_url('/') . '' . $this->redirect);
        return TRUE;
    }

    
    protected function setSession() {        
        $data = Session::getInstance();
        //fornece qual sera o nome da sessao e sua mensagem
        switch ($this->tipo){
            
             case 1: $data->success = $this->mensagem;
                break;
            case 2: $data->info = $this->mensagem;
                break;
            case 3: $data->warning = $this->mensagem;
                break;
            case 4: $data->danger = $this->mensagem;
                break;
        }
        
        
    }

}
