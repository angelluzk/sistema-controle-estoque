<?php

// src/Core/Router.php

namespace App\Core;

class Router
{
    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        switch (true) {
            // ROTA PRINCIPAL AGORA É DO CategoriaController
            case ($uri === '/' && $method === 'GET'):
                $controllerName = 'App\Controller\CategoriaController';
                $methodName = 'index';
                break;
            
            // NOVAS ROTAS DE CATEGORIA
            case ($uri === '/categorias/novo' && $method === 'GET'):
                $controllerName = 'App\Controller\CategoriaController';
                $methodName = 'create';
                break;
            case ($uri === '/categorias' && $method === 'POST'):
                $controllerName = 'App\Controller\CategoriaController';
                $methodName = 'store';
                break;
            
            // ROTAS DE PRODUTOS (EXISTENTES)
            case ($uri === '/produtos' && $method === 'GET'):
                $controllerName = 'App\Controller\ProdutoController';
                $methodName = 'index';
                break;
            case ($uri === '/produtos/novo' && $method === 'GET'):
                $controllerName = 'App\Controller\ProdutoController';
                $methodName = 'create';
                break;
            case ($uri === '/produtos' && $method === 'POST'):
                $controllerName = 'App\Controller\ProdutoController';
                $methodName = 'store';
                break;
            case ($uri === '/produtos/editar' && $method === 'GET'):
                $controllerName = 'App\Controller\ProdutoController';
                $methodName = 'edit';
                break;
            case ($uri === '/produtos/atualizar' && $method === 'POST'):
                $controllerName = 'App\Controller\ProdutoController';
                $methodName = 'update';
                break;
            case ($uri === '/produtos/excluir' && $method === 'POST'):
                $controllerName = 'App\Controller\ProdutoController';
                $methodName = 'delete';
                break;

            default:
                http_response_code(404);
                echo "<h1>Página não encontrada!</h1>";
                return;
        }

        $controller = new $controllerName();
        $controller->$methodName();
    }
}