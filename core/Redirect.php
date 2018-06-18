<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;
use Core\Session;
/**
 * Description of Redirect
 *
 * @author laboratorio
 */
class Redirect {   
    
    private $redirect;
    private $tipo;    
    private $mensagem;


    public static function redirect($redirect, $tipo = null, $mensagem = null) {
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
