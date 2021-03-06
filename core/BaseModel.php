<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

use Core\DataBase;
use Core\Session;

/**
 * Description of Model
 *
 * @author Wesllen
 */
abstract class BaseModel {

    private $con;
    protected $tabela;
    protected $tabela2;
    protected $tabela3;
    protected $tabelaUse;
    protected $chaveEstrangeira;
    protected $chaveEstrangeira1;
    protected $chaveEstrangeira2;
    private $redirect;
    private $tipo;
    private $mensagem;

    public function __construct() {
        $this->con = new DataBase();
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function __get($atributo) {
        return $this->$atributo;
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
        switch ($this->tipo) {
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

    public function insert(array $campos_values) {
        //atribui a uma variavel a quantidade de tabelas a ser usadas
        $total = $this->tabelaUse;
        switch ($total) {
            Case 1:
                try {
                    $campos_array_0 = array_keys($campos_values[0]);
                    $values_array_0 = array_values($campos_values[0]);

                    $insert_campos_0 = implode(",", $campos_array_0);
                    $insert_values_0 = implode("','", $values_array_0);

                    $query1 = $this->con->conecta()->prepare("INSERT INTO $this->tabela ({$insert_campos_0}) VALUES('{$insert_values_0}');");
                    if ($query1->execute()) {
                        return TRUE;
                    } else {
                        print_r($query1->errorInfo());
                        return FALSE;
                    }
                } catch (PDOException $ex) {
                    echo $ex->getMessage();
                }

                break;
            Case 2:
                try {
                    $campos_array_0 = array_keys($campos_values[0]);
                    $values_array_0 = array_values($campos_values[0]);

                    $insert_campos_0 = implode(",", $campos_array_0);
                    $insert_values_0 = implode("','", $values_array_0);

                    $query1 = $this->con->conecta()->prepare("INSERT INTO $this->tabela ({$insert_campos_0}) VALUES('{$insert_values_0}');");

                    if ($query1->execute()) {
                        $id = $this->con->conecta()->lastInsertId();

                        $campos_array_1 = array_keys($campos_values[1]);
                        $values_array_1 = array_values($campos_values[1]);

                        $insert_campos_1 = implode(",", $campos_array_1);
                        $insert_values_1 = implode("','", $values_array_1);
                        $query2 = $this->con->conecta()->prepare("INSERT INTO $this->tabela2 ({$insert_campos_1}, $this->chaveEstrangeira) VALUES('{$insert_values_1}','{$id}');");

                        if ($query2->execute()) {

                            return TRUE;
                        } else {
                            print_r($query2->errorInfo());
                            return FALSE;
                        }
                    } else {
                        print_r($query->errorInfo());
                        return FALSE;
                    }
                } catch (PDOException $ex) {
                    echo $ex->getMessage();
                }
                break;
            Case 3:
                try {
                    $campos_array_0 = array_keys($campos_values[0]);
                    $values_array_0 = array_values($campos_values[0]);

                    $insert_campos_0 = implode(",", $campos_array_0);
                    $insert_values_0 = implode("','", $values_array_0);

                    $query1 = $this->con->conecta()->prepare("INSERT INTO $this->tabela ({$insert_campos_0}) VALUES('{$insert_values_0}');");


                    if ($query1->execute()) {
                        $id = $this->con->conecta()->lastInsertId();

                        $campos_array_1 = array_keys($campos_values[1]);
                        $values_array_1 = array_values($campos_values[1]);

                        $insert_campos_1 = implode(",", $campos_array_1);
                        $insert_values_1 = implode("','", $values_array_1);

                        $query2 = $this->con->conecta()->prepare("INSERT INTO $this->tabela2 ({$insert_campos_1}, $this->chaveEstrangeira) VALUES('{$insert_values_1}','{$id}');");

                        if ($query2->execute()) {

                            $id = $this->con->conecta()->lastInsertId();

                            $campos_array_2 = array_keys($campos_values[2]);
                            $values_array_2 = array_values($campos_values[2]);

                            $insert_campos_2 = implode(",", $campos_array_2);
                            $insert_values_2 = implode("','", $values_array_2);

                            $query3 = $this->con->conecta()->prepare("INSERT INTO $this->tabela3 ({$insert_campos_2}, $this->chaveEstrangeira1) VALUES('{$insert_values_2}','{$id}');");

                            if ($query3->execute()) {
                                return TRUE;
                            } else {
                                print_r($query3->errorInfo());
                                return FALSE;
                            }
                        } else {
                            print_r($query2->errorInfo());
                            return FALSE;
                        }
                    } else {
                        print_r($query1->errorInfo());
                        return FALSE;
                    }
                } catch (PDOException $ex) {
                    echo $ex->getMessage();
                }
                break;
            Case 4:
                try {
                    $campos_array_0 = array_keys($campos_values[0]);
                    $values_array_0 = array_values($campos_values[0]);

                    $insert_campos_0 = implode(",", $campos_array_0);
                    $insert_values_0 = implode("','", $values_array_0);

                    $query1 = $this->con->conecta()->prepare("INSERT INTO $this->tabela ({$insert_campos_0}) VALUES('{$insert_values_0}');");

                    if ($query1->execute()) {
                        $id = $this->con->conecta()->lastInsertId();

                        $campos_array_1 = array_keys($campos_values[1]);
                        $values_array_1 = array_values($campos_values[1]);

                        $insert_campos_1 = implode(",", $campos_array_1);
                        $insert_values_1 = implode("','", $values_array_1);

                        $query2 = $this->con->conecta()->prepare("INSERT INTO $this->tabela2 ({$insert_campos_1}, $this->chaveEstrangeira) VALUES('{$insert_values_1}','{$id}');");

                        if ($query2->execute()) {

                            $id = $this->con->conecta()->lastInsertId();

                            $campos_array_2 = array_keys($campos_values[2]);
                            $values_array_2 = array_values($campos_values[2]);

                            $insert_campos_2 = implode(",", $campos_array_2);
                            $insert_values_2 = implode("','", $values_array_2);

                            $query3 = $this->con->conecta()->prepare("INSERT INTO $this->tabela3 ({$insert_campos_2}, $this->chaveEstrangeira1) VALUES('{$insert_values_2}','{$id}');");

                            if ($query3->execute()) {

                                $id = $this->con->conecta()->lastInsertId();

                                $campos_array_3 = array_keys($campos_values[3]);
                                $values_array_3 = array_values($campos_values[3]);

                                $insert_campos_3 = implode(",", $campos_array_3);
                                $insert_values_3 = implode("','", $values_array_3);

                                $query4 = $this->con->conecta()->prepare("INSERT INTO $this->tabela3 ({$insert_campos_3}, $this->chaveEstrangeira1) VALUES('{$insert_values_3}','{$id}');");

                                if ($query4->execute()) {
                                    return TRUE;
                                } else {
                                    print_r($query4->errorInfo());
                                    return FALSE;
                                }
                            } else {
                                print_r($query3->errorInfo());
                                return FALSE;
                            }
                        } else {
                            print_r($query2->errorInfo());
                            return FALSE;
                        }
                        return TRUE;
                    } else {
                        print_r($query1->errorInfo());
                        return FALSE;
                    }
                } catch (PDOException $ex) {
                    echo $ex->getMessage();
                }
                break;
        }
    }

    public function read($campos = "*", $where = null) {
        try {

            $where_sql = empty($where) ? "" : "WHERE " . $where;
            $r = $this->con->conecta()->prepare("SELECT {$campos} FROM $this->tabela {$where_sql};");

            if ($r->execute()) {
                return $r->fetchAll();
            } else {
                print_r($r->errorInfo());
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function readChave(array $campos_values, $campos = "*", $where = null) {
        try {

            $condicoes_array = array_values($campos_values);
            $insert_values = implode("", $condicoes_array);

            $where_sql = empty($where) ? "" : "WHERE " . $where;
            $r = $this->con->conecta()->prepare("SELECT {$campos} FROM $this->tabela  {$insert_values} {$where_sql};");

            if ($r->execute()) {
                return $r->fetchAll();
            } else {
                print_r($r->errorInfo());
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function update(array $campos_values, $where = null) {
        try {
            $where_sql = empty($where) ? "" : "WHERE " . $where;

            $sql_text_array = array();
            foreach ($campos_values as $campo => $valor) {
                array_push($sql_text_array, "{$campo}='{$valor}'");
            }
            $sql_text = implode(",", $sql_text_array);

            $r = $this->con->conecta()->prepare("UPDATE {$this->tabela} SET {$sql_text} {$where_sql}");

            $r->execute();
            if ($r->rowCount()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function delete($where_sql) {
        try {
            $r = $this->con->conecta()->prepare("DELETE FROM $this->tabela WHERE {$where_sql}");
            

            $r->execute();
            if($r->rowCount()) {
              return TRUE;  
            } else {
                return FALSE; 
            }
        } catch (\PDOException $ex) {
             echo $ex->getMessage();
        }
        
        
    }

}
