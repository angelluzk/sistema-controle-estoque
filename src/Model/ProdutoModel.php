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
        // ... (código existente)
        $sql = "SELECT p.id, p.nome, p.sku, p.preco, p.quantidade, c.nome AS nome_categoria FROM produtos p LEFT JOIN categorias c ON p.categoria_id = c.id ORDER BY p.nome ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Salva um novo produto no banco de dados.
     *
     * @param array $data Dados do produto (nome, sku, preco, etc.).
     * @return bool True se salvou com sucesso, False caso contrário.
     */
    public function save(array $data): bool
    {
        $sql = "INSERT INTO produtos (nome, sku, preco, quantidade, categoria_id)
                VALUES (:nome, :sku, :preco, :quantidade, :categoria_id)";
        
        $stmt = $this->pdo->prepare($sql);

        // O 'bindValue' trata os dados de forma segura, prevenindo SQL Injection.
        $stmt->bindValue(':nome', $data['nome']);
        $stmt->bindValue(':sku', $data['sku'] ?: null); // Permite SKU vazio
        $stmt->bindValue(':preco', $data['preco']);
        $stmt->bindValue(':quantidade', $data['quantidade']);
        $stmt->bindValue(':categoria_id', $data['categoria_id'] ?: null); // Permite categoria vazia

        return $stmt->execute();
    }
}