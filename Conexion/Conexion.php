<?php

class Connetion
{

    static public function Conexcion()
    {
        try {
            $conn = new PDO("mysql:host=127.0.0.1;dbname=registros_db", "root", "");
            $conn->exec("set names utf8");
            return $conn;
        } catch (PDOException $e) {
            dir("ERRO A LA CONEXION ". $e->getMessage() ."");
        }
    }
}