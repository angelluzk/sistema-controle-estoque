<?php

// public/index.php

/**
 * ---------------------------------------------------------------
 * PONTO DE ENTRADA DA APLICAÇÃO (FRONT CONTROLLER)
 * ---------------------------------------------------------------
 *
 * Este arquivo é o único ponto de acesso para todas as requisições.
 * Ele é responsável por:
 * 1. Carregar o autoloader do Composer.
 * 2. Iniciar o nosso roteador para que ele decida qual
 * controller e método deve ser executado.
 */

// 1. Carrega o autoload do Composer para termos acesso a todas as nossas classes
require_once '../vendor/autoload.php';

// 2. Importa a classe Router para que possamos usá-la.
use App\Core\Router;

// 3. Cria uma nova instância do nosso Roteador.
$router = new Router();

// 4. Executa o roteador, que vai cuidar de todo o resto.
$router->run();