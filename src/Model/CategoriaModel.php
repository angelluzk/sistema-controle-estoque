<?php

// src/Model/CategoriaModel.php

namespace App\Model;

use App\Core\Database;
use PDO;

class CategoriaModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function findAll(): array
    {
        $sql = "SELECT id, nome, descricao FROM categorias ORDER BY nome ASC";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Salva uma nova categoria no banco de dados.
     *
     * @param array $data Dados da categoria (nome, descricao).
     * @return bool True se salvou com sucesso, False caso contrário.
     */
    public function save(array $data): bool
    {
        $sql = "INSERT INTO categorias (nome, descricao) VALUES (:nome, :descricao)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $data['nome']);
        $stmt->bindValue(':descricao', $data['descricao'] ?: null);

        return $stmt->execute();
    }
}