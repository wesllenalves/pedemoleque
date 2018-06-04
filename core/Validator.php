<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;
use Core\Session;
/**
 * Description of Validator
 *
 * @author Wesllen
 */
class Validator
{
    public static function make(array $data, array $rules)
    {
        $errors = null;
        foreach ($rules as $ruleKey => $ruleValue) {
            foreach ($data as $dataKey => $dataValue) {
                if ($ruleKey == $dataKey) {
                    $itemsValue = [];
                    if(strpos($ruleValue, "|")){
                        $itemsValue = explode("|", $ruleValue);
                        foreach ($itemsValue as $itemValue){
                            $subItems = [];
                            if(strpos($itemValue, ":")){
                                $subItems = explode(":", $itemValue);
                                switch ($subItems[0]) {
                                    case 'min':
                                        if (strlen($dataValue) < $subItems[1])
                                            $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> deve ter um mínimo de {$subItems[1]} caracteres.";
                                        break;
                                    case 'max' :
                                        if (strlen($dataValue) > $subItems[1])
                                            $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> deve ter um máximo de {$subItems[1]} caracteres.";
                                        break;
                                    case 'unique' :
                                        $objModel = "\\App\\Models\\" . $subItems[1];
                                        $model = new $objModel;
                                        $find = $model->where($subItems[2], $dataValue)->first();
                                        if($find->$subItems[2]){
                                            if(isset($subItems[3]) && $find->id == $subItems[3]){
                                                break;
                                            }else{
                                                $errors["$ruleKey"] = "{<b>$ruleKey}</b> já registrado no banco de dados.";
                                                break;
                                            }
                                        }
                                        break;
                                }
                            }else{
                                switch ($itemValue) {
                                    case 'required':
                                        if ($dataValue == ' ' || empty($dataValue))
                                            $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> deve ser preenchido.";
                                        break;
                                    case 'email':
                                        if (!filter_var($dataValue, FILTER_VALIDATE_EMAIL))
                                            $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> não é válido.";
                                        break;
                                    case 'float':
                                        if (!filter_var($dataValue, FILTER_VALIDATE_FLOAT))
                                            $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> deve conter número decimal.";
                                        break;
                                    case 'int':
                                        if (!filter_var($dataValue, FILTER_VALIDATE_INT))
                                            $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> deve conter número inteiro.";
                                        break;
                                    default :
                                        break;
                                }
                            }
                        }
                    }elseif (strpos($ruleValue, ":")) {
                        $items = explode(":", $ruleValue);
                        switch ($items[0]) {
                            case 'min':
                                if (strlen($dataValue) < $items[1])
                                    $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> deve ter um mínimo de {$items[1]} caracteres.";
                                break;
                            case 'max' :
                                if (strlen($dataValue) > $items[1])
                                    $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> deve ter um máximo de {$items[1]} caracteres.";
                                break;
                            case 'unique' :
                                $objModel = "\\App\\Models\\" . $subItems[1];
                                $model = new $objModel;
                                $find = $model->where($subItems[2], $dataValue)->first();
                                if($find->$subItems[2]){
                                    if(isset($subItems[3]) && $find->id == $subItems[3]){
                                        break;
                                    }else{
                                        $errors["$ruleKey"] = "<b>{$ruleKey}</b> já registrado no banco de dados.";
                                        break;
                                    }
                                }
                                break;
                        }
                    } else {
                        switch ($ruleValue) {
                            case 'required':
                                if ($dataValue == ' ' || empty($dataValue))
                                    $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> deve ser preenchido.";
                                break;
                            case 'email':
                                if (!filter_var($dataValue, FILTER_VALIDATE_EMAIL))
                                    $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> não é válido.";
                                break;
                            case 'float':
                                if (!filter_var($dataValue, FILTER_VALIDATE_FLOAT))
                                    $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> deve conter número decimal.";
                                break;
                            case 'int':
                                if (!filter_var($dataValue, FILTER_VALIDATE_INT))
                                    $errors["$ruleKey"] = "O campo <b>{$ruleKey}</b> deve conter número inteiro.";
                                break;
                            default :
                                break;
                        }
                    }
                }
            }
        }
        if ($errors) { 
            $data = Session::getInstance();
            $data->danger = $errors;
            
            //Session::set('inputs', $data);
            return true;
        } else {
            session_start();
            session_destroy();
//            Session::destroy('danger');
           // Session::destroy(['danger', 'inputs']);
            return false;
        }
    }
}

