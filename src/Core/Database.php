<?php

namespace App\Core;

// Importa as classes nativas do PHP para conexão (PDO) e tratamento de erros (PDOException).
use PDO;
use PDOException;

/**
 * Classe de Conexão com o Banco de Dados (Padrão de Projeto Singleton)
 *
 * O Singleton garante que exista apenas UMA instância da conexão com o banco
 * de dados durante toda a execução do script. Isso economiza recursos e
 * evita a sobrecarga de abrir e fechar múltiplas conexões.
 */
class Database
{
    /**
     * @var PDO|null A única instância da conexão PDO.
     * É estática para pertencer à classe, e não a um objeto específico.
     */
    private static $instance = null;

    /**
     * O construtor é privado para impedir a criação de novas instâncias
     * com o operador 'new' de fora da classe.
     */
    private function __construct() {}

    /**
     * O método clone é privado para impedir a clonagem da instância.
     */
    private function __clone() {}

    /**
     * Ponto de acesso global e estático para a instância da conexão.
     * É a única maneira de obter a conexão com o banco de dados.
     *
     * @return PDO A instância única e configurada do objeto PDO.
     */
    public static function getInstance(): PDO
    {
        // Se a instância ainda não foi criada...
        if (self::$instance === null) {
            
            // DSN (Data Source Name) para PostgreSQL. É a string de conexão.
            // As informações são lidas das variáveis de ambiente carregadas em public/index.php.
            $dsn = "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']}";

            try {
                // ...cria a nova instância do PDO.
                self::$instance = new PDO(
                    $dsn,
                    $_ENV['DB_USERNAME'],
                    $_ENV['DB_PASSWORD'],
                    [
                        // Configura o PDO para lançar exceções em caso de erros de SQL.
                        // Isso nos permite usar blocos try-catch para tratar erros.
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        // Configura o modo de busca padrão para retornar arrays associativos (chave => valor).
                        // Ex: $resultado['nome'] em vez de $resultado[0].
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                // Se a conexão falhar, a aplicação é interrompida e uma mensagem de erro é exibida.
                // Em um ambiente de produção, este erro seria registrado em um arquivo de log.
                die("Erro na conexão com o banco de dados: " . $e->getMessage());
            }
        }

        // Retorna a instância da conexão (seja ela recém-criada ou a que já existia).
        return self::$instance;
    }
}