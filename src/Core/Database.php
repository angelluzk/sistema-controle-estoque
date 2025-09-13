<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Classe de Conexão com o Banco de Dados (Singleton Pattern)
 *
 * Garante que apenas uma instância da conexão PDO seja criada.
 */
class Database
{
    private static $instance = null;

    /**
     * Construtor privado para prevenir a instanciação direta.
     */
    private function __construct() {}

    /**
     * Método clone privado para prevenir a clonagem da instância.
     */
    private function __clone() {}

    /**
     * Método estático que retorna a única instância da conexão PDO.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            // Se a instância ainda não foi criada, cria uma nova.
            $config = require_once '../config/database.php';

            // DSN (Data Source Name) para PostgreSQL
            $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

            try {
                self::$instance = new PDO(
                    $dsn,
                    $config['user'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erros
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Retorna resultados como arrays associativos
                    ]
                );
            } catch (PDOException $e) {
                // Em caso de falha na conexão, encerra a aplicação e mostra o erro.
                // Em um ambiente de produção, você logaria o erro em vez de exibi-lo.
                die("Erro na conexão com o banco de dados: " . $e->getMessage());
            }
        }

        // Retorna a instância da conexão.
        return self::$instance;
    }
}