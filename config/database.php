<?php

class Database{

  public static function conexion(){

    $database = new mysqli('localhost','root','123456','labotadenoel');

    //$database->set_charset("utf8");
    $database->query("SET NAMES 'utf8'");
    if($database->connect_error){//si nos da error y ponemos conexion falida y nos muestra el error
      die("Conexion fallida" . $this->database->connect_error);
    }

    return $database;


  }



}





 ?>
