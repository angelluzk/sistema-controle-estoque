<?php

// src/Model/ProdutoModel.php

namespace App\Model;

use App\Core\Database;
use PDO;

class ProdutoModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function findAll(): array
    {
        $sql = "SELECT p.id, p.nome, p.sku, p.preco, p.quantidade, c.nome AS nome_categoria FROM produtos p LEFT JOIN categorias c ON p.categoria_id = c.id ORDER BY p.nome ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(array $data): bool
    {
        $sql = "INSERT INTO produtos (nome, sku, preco, quantidade, categoria_id) VALUES (:nome, :sku, :preco, :quantidade, :categoria_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $data['nome']);
        $stmt->bindValue(':sku', $data['sku'] ?: null);
        $stmt->bindValue(':preco', $data['preco']);
        $stmt->bindValue(':quantidade', $data['quantidade']);
        $stmt->bindValue(':categoria_id', $data['categoria_id'] ?: null);
        return $stmt->execute();
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $data): bool
    {
        $sql = "UPDATE produtos SET nome = :nome, sku = :sku, preco = :preco, quantidade = :quantidade, categoria_id = :categoria_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $data['id']);
        $stmt->bindValue(':nome', $data['nome']);
        $stmt->bindValue(':sku', $data['sku'] ?: null);
        $stmt->bindValue(':preco', $data['preco']);
        $stmt->bindValue(':quantidade', $data['quantidade']);
        $stmt->bindValue(':categoria_id', $data['categoria_id'] ?: null);
        return $stmt->execute();
    }
}