<?php

namespace App\Core;

class Router
{
    public function run()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $rotasPublicas = [
            '/login' => ['GET', 'POST'],
            '/registrar' => ['GET', 'POST']
        ];
        
        $rotaAtualEhPublica = isset($rotasPublicas[$uri]) && in_array($method, $rotasPublicas[$uri]);

        if (!$rotaAtualEhPublica && !isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit;
        }

        if ($rotaAtualEhPublica && isset($_SESSION['usuario_id'])) {
             header('Location: /');
             exit;
        }

        switch (true) {
            // ROTA PRINCIPAL AGORA É O DASHBOARD
            case ($uri === '/' && $method === 'GET'):
                $controllerName = 'App\Controller\DashboardController';
                $methodName = 'index';
                break;
            
            // ROTAS DE AUTENTICAÇÃO
            case ($uri === '/registrar' && $method === 'GET'):
                $controllerName = 'App\Controller\AuthController';
                $methodName = 'showRegistrationForm';
                break;
            case ($uri === '/registrar' && $method === 'POST'):
                $controllerName = 'App\Controller\AuthController';
                $methodName = 'register';
                break;
            case ($uri === '/login' && $method === 'GET'):
                $controllerName = 'App\Controller\AuthController';
                $methodName = 'showLoginForm';
                break;
            case ($uri === '/login' && $method === 'POST'):
                $controllerName = 'App\Controller\AuthController';
                $methodName = 'login';
                break;
            case ($uri === '/logout' && $method === 'POST'):
                $controllerName = 'App\Controller\AuthController';
                $methodName = 'logout';
                break;

            // ROTA PARA A LISTA DE CATEGORIAS
            case ($uri === '/categorias' && $method === 'GET'):
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

            // ROTAS DE MOVIMENTAÇÃO
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