<?php

require_once './app/models/productAPIModel.php';
require_once './app/views/APIView.php';

 class productAPIController{
 private $model;
 private $view;

 public function __construct(){
    $this ->model = new productAPIModel();
    $this ->view = new APIView();
 }

function getProducts($req, $res) {

        if(!$res->user) { //bloque auth
            return $this->view->response("No autorizado", 401);
        }

        $filtroCategoria =null;
        if (isset ($req->query->category)) {
         $filtroCategoria = $req->query->category;
        }

        $filtroHayStock = null;
        if(isset($req->query->stock)) {
            $filtroHayStock = $req->query->stock;
        }
        
        $orderBy = false; //indica por cual campo ordenar
        if(isset($req->query->orderBy))
            $orderBy = $req->query->orderBy;

        $order = 'ASC'; //indica si ordena ASC o DESC
        if (isset($req->query->order))
            $order = $req->query->order;

        $page = null;
        if (isset ($req->query->page))
            $page = $req->query->page;

        $products = $this->model->getProducts($filtroCategoria, $filtroHayStock, $orderBy, $order, $page);
        
        return $this->view->response($products);
}

function getProduct($req, $res){

    if(!$res->user) { //bloque auth
        return $this->view->response("No autorizado", 401);
    }
   
    if (isset($req-> query->id)){
        $id = $req->params->id;
        
    } else $this->view->response("Envie el id del producto deseado", 400);

    $subrecurso = null;
    if (isset($req->query->subrecurso)){
        $subrecurso = $req->query->subrecurso;
    }

    $product = $this->model->getProduct($id, $subrecurso);
    return $this->view->response($product);
}

public function addProduct($req, $res) { //esta bien validado?

    if(!$res->user) { //bloque auth
        return $this->view->response("No autorizado", 401);
    }

    if (($req->query->name) || ($req->query->category) 
        || ($req->query->price) || ($req->query->stock)){
    $name = $req->body->product_name;
    $category = $req->body->category_id;
    $price = $req->body->product_price;
    $stock = $req->body->product_stock;
    $product = $this->model->addProduct($name,$category, $price, $stock);
    $this->view->response("Producto creado con éxito", 201);
    } 
    else $this->view->response("Complete todos los campos", 400);
}

public function deleteProduct($req,$res) {

    if(!$res->user) { //bloque auth
        return $this->view->response("No autorizado", 401);
    }

    $product_id = $req->params->id;
    $product = $this->model->getProduct($product_id, null);

    if ($product) {
        $this->model->deleteProduct($product_id);
        $this->view->response("Producto id=$product_id eliminado con éxito", 200);
    }
    else 
        $this->view->response("Producto id=$product_id no encontrado", 404);
}

public function updateProduct($req, $res) {

    if(!$res->user) { //bloque auth
        return $this->view->response("No autorizado", 401);
    }

    $product_id = $req->params->id;
    $product = $this->model->getProduct($product_id, null); //el null porque no pasa subrecurso

    if ($product) {
        $name = $req->body->product_name;
        $stock = $req->body->product_stock;
        $price = $req->body->product_price;
        $category = $req->body->category_id;
        $product = $this->model->updateProduct($name, $stock, $price, $category, $id);
        $this->view->response("Producto id=$product_id actualizado con éxito", 200);
        $this->view->response($product,200);
    }
    else 
        $this->view->response("Producto id=$product_id not found", 404);
}
}