<?php

// src/Core/Router.php

namespace App\Core;

class Router
{
    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD']; // Captura o método: GET ou POST

        // Definindo as rotas
        switch (true) {
            // Rota para a página inicial (Categorias)
            case ($uri === '/' && $method === 'GET'):
                $controllerName = 'App\Controller\HomeController';
                $methodName = 'index';
                break;

            // Rota para a listagem de produtos
            case ($uri === '/produtos' && $method === 'GET'):
                $controllerName = 'App\Controller\ProdutoController';
                $methodName = 'index';
                break;
            
            // Rota para exibir o formulário de cadastro de produto
            case ($uri === '/produtos/novo' && $method === 'GET'):
                $controllerName = 'App\Controller\ProdutoController';
                $methodName = 'create';
                break;

            // Rota para salvar o novo produto (recebe os dados do formulário)
            case ($uri === '/produtos' && $method === 'POST'):
                $controllerName = 'App\Controller\ProdutoController';
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