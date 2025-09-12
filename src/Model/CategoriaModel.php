<?php

// src/Model/CategoriaModel.php

namespace App\Model;

use App\Core\Database;
use PDO;

class CategoriaModel
{
    private $pdo;

    /**
     * Construtor que obtém a instância da conexão PDO.
     */
    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    /**
     * Busca todas as categorias no banco de dados.
     *
     * @return array Uma lista de categorias.
     */
    public function findAll(): array
    {
        $sql = "SELECT id, nome, descricao FROM categorias ORDER BY nome ASC";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}