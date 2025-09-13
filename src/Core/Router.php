<?php

namespace App\Core;

class Router
{
    public function run()
    {
        // Precisamos garantir que a sessão seja iniciada em todas as requisições
        // para que as mensagens de erro funcionem.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        switch (true) {
            // ROTAS DE CATEGORIA
            case ($uri === '/' && $method === 'GET'):
                $controllerName = 'App\Controller\CategoriaController';
                $methodName = 'index';
                break;
            case ($uri === '/categorias/novo' && $method === 'GET'):
                $controllerName = 'App\Controller\CategoriaController';
                $methodName = 'create';
                break;
            case ($uri === '/categorias' && $method === 'POST'):
                $controllerName = 'App\Controller\CategoriaController';
                $methodName = 'store';
                break;
            case ($uri === '/categorias/editar' && $method === 'GET'):
                $controllerName = 'App\Controller\CategoriaController';
                $methodName = 'edit';
                break;
            case ($uri === '/categorias/atualizar' && $method === 'POST'):
                $controllerName = 'App\Controller\CategoriaController';
                $methodName = 'update';
                break;
            case ($uri === '/categorias/excluir' && $method === 'POST'):
                $controllerName = 'App\Controller\CategoriaController';
                $methodName = 'delete';
                break;
            
            // ROTAS DE PRODUTOS
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

            // ROTAS DE MOVIMENTAÇÕES
            case ($uri === '/movimentos' && $method === 'GET'):
                $controllerName = 'App\Controller\MovimentoController';
                $methodName = 'index';
                break;
            case ($uri === '/movimentos' && $method === 'POST'):
                $controllerName = 'App\Controller\MovimentoController';
                $methodName = 'store';
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