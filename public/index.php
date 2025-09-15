<?php

/**
 * ---------------------------------------------------------------
 * PONTO DE ENTRADA DA APLICAÇÃO (FRONT CONTROLLER)
 * ---------------------------------------------------------------
 *
 * Este arquivo é o único ponto de acesso público da aplicação.
 * Este padrão, chamado "Front Controller", garante que todas as
 * requisições passem por um único script, centralizando o controle,
 * a segurança e o carregamento de recursos.
 *
 * Responsabilidades:
 * 1. Iniciar a sessão.
 * 2. Carregar o autoloader do Composer (para carregar classes automaticamente).
 * 3. Carregar as variáveis de ambiente do arquivo .env (banco de dados, etc.).
 * 4. Iniciar o Roteador para que ele analise a URL e execute a ação correta.
 */

// Garante que a sessão seja iniciada em todas as requisições.
// É essencial para o sistema de login.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Carrega o autoloader do Composer. A partir daqui, as classes dos namespaces
// definidos em composer.json (como App\) serão carregadas sob demanda.
require_once '../vendor/autoload.php';

// 2. Importa as classes que serão usadas neste arquivo para facilitar a leitura.
use Dotenv\Dotenv;
use App\Core\Router;

// 3. Cria uma instância do Dotenv, apontando para o diretório raiz do projeto ('../').
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
// Carrega as variáveis do arquivo .env para as variáveis superglobais ($_ENV, $_SERVER).
$dotenv->load();

// 4. Cria uma nova instância do nosso Roteador.
$router = new Router();
// Executa o método "run", que é o coração do roteamento.
$router->run();