<?php

/**
 * Arquivo de configuração do banco de dados.
 * Lê as credenciais das variáveis de ambiente ($_ENV)
 * carregadas pelo Dotenv.
 */
return [
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'dbname' => $_ENV['DB_DATABASE'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD']
];