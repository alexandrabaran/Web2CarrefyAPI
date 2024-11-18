<?php

class APIView {

  public function response($body, $status = 200) {
      header("Content-Type: application/json");
      $statusText = $this ->_requestStatus($status);
      header("HTTP/1.1 $status $statusText");
      echo json_encode($body);
  }

  private function _requestStatus($code){ //le paso codigo de status, compara con los del arreglo  
      $status = array(
        200 => "OK",
        201 => "Created",
        400 => "Bad Request",
        401 => "Unauthorized",
        404 => "Not found",
        500 => "Internal Server Error"
      );
      return (isset($status[$code])) ? $status[$code] : $status[500];

      //si el codigo esta en el arreglo status devuelve el texto de ese codigo, sino devuelve el de 500.
      //operador ternario
    }

}