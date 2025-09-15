<?php

namespace App\Core;

/**
 * Classe Router (Roteador)
 *
 * O "cérebro" da aplicação. Sua função é analisar a URL e o método HTTP
 * (GET, POST) da requisição para determinar qual método de qual Controller
 * deve ser executado. Ele também centraliza as regras de segurança, como
 * a proteção de rotas para usuários não autenticados.
 */
class Router
{
    /**
     * Método principal que executa o roteamento.
     */
    public function run()
    {
        // A sessão já foi iniciada em public/index.php

        // Extrai a URI da requisição (ex: "/produtos", "/categorias/novo").
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Extrai o método HTTP (ex: "GET", "POST").
        $method = $_SERVER['REQUEST_METHOD'];

        // Define um array de rotas que são públicas e não precisam de login.
        $rotasPublicas = [
            '/login' => ['GET', 'POST'],
            '/registrar' => ['GET', 'POST']
        ];
        
        // Verifica se a rota atual (URI e método) está na lista de rotas públicas.
        $rotaAtualEhPublica = isset($rotasPublicas[$uri]) && in_array($method, $rotasPublicas[$uri]);

        // REGRA DE SEGURANÇA 1: Proteger rotas privadas.
        // Se a rota NÃO é pública E o usuário NÃO tem um ID na sessão...
        if (!$rotaAtualEhPublica && !isset($_SESSION['usuario_id'])) {
            // ...redireciona para a página de login e encerra a execução.
            header('Location: /login');
            exit;
        }

        // REGRA DE SEGURANÇA 2: Impedir acesso a páginas de login/registro se já estiver logado.
        // Se a rota É pública E o usuário JÁ ESTÁ logado...
        if ($rotaAtualEhPublica && isset($_SESSION['usuario_id'])) {
             // ...redireciona para o dashboard.
             header('Location: /');
             exit;
        }

        // O 'switch (true)' permite uma estrutura de roteamento limpa baseada em condições.
        switch (true) {
            // ROTA PRINCIPAL É O DASHBOARD
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

            // Se nenhuma das rotas acima corresponder, retorna um erro 404.
            default:
                http_response_code(404);
                echo "<h1>Página não encontrada!</h1>";
                return; // Encerra a execução.
        }

        // Após encontrar a rota, instancia o Controller correspondente.
        $controller = new $controllerName();
        // E chama o método correspondente para lidar com a requisição.
        $controller->$methodName();
    }
}