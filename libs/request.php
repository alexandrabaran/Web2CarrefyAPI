<?php 

class Request {
public $body = null; //la info en si
public $params = null; //parametro que le pasamos ej id de producto id
public $query = null; //

    public function __construct(){
        try { //leer el body y parsearlo a json
            $this -> body = json_decode(file_get_contents('php://input'), true);
        }
        catch (Exception $e) {
            $this -> body = null;
        }
        $this ->query = (object) $_GET; //los parametros get parseados como objeto
    }
   
}