<?php

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

    /**
     * Exclui um produto do banco de dados pelo seu ID.
     *
     * @param int $id O ID do produto a ser excluído.
     * @return bool True se a exclusão foi bem-sucedida, False caso contrário.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

 /**
     * Retorna a contagem total de produtos cadastrados.
     */
    public function getTotalCount(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(id) FROM produtos");
        return $stmt->fetchColumn();
    }

    /**
     * Retorna a soma da quantidade de todos os itens em estoque.
     */
    public function getTotalStockQuantity(): int
    {
        $stmt = $this->pdo->query("SELECT SUM(quantidade) FROM produtos");
        return (int)$stmt->fetchColumn(); // Cast para int para garantir
    }

    /**
     * Retorna os N produtos com maior quantidade em estoque.
     */
    public function getTopStockProducts(int $limit = 5): array
    {
        $stmt = $this->pdo->query("SELECT nome, quantidade FROM produtos ORDER BY quantidade DESC LIMIT {$limit}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}