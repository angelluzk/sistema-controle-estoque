<?php

// 1. Carrega o autoloader do Composer
require_once '../vendor/autoload.php';

// 2. Importa a classe Dotenv
use Dotenv\Dotenv;

// 3. Carrega as variáveis de ambiente do arquivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// 4. Importa a classe Router (como antes)
use App\Core\Router;

// 5. Inicia o roteador (como antes)
$router = new Router();
$router->run();