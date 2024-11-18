<?php
    require_once 'app/config.php';
    require_once './libs/router.php';
    require_once 'app/controllers/productAPIController.php';
    require_once 'app/controllers/adminAPIController.php';
    require_once 'app/middlewares/JWTauthMiddleware.php';

    $router = new Router();

    $router->addMiddleware(new JWTauthMiddleware());

    $router->addRoute('products', 'GET', 'productAPIController', 'getProducts');
    $router->addRoute('products/:id', 'GET', 'productAPIController', 'getProduct');
    $router->addRoute('products',     'POST',   'productAPIController', 'addProduct');
    $router->addRoute('products/:id', 'PUT',    'productAPIController', 'updateProduct');
    $router->addRoute('products/:id', 'DELETE',    'productAPIController', 'deleteProduct');

    $router->addRoute('admins/token', 'GET',     'adminAPIController',   'getToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
    