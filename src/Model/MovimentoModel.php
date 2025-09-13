<?php

namespace App\Model;

use App\Core\Database;
use PDO;
use Exception;

class MovimentoModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    /**
     * Busca todos os movimentos de estoque, com o nome do produto correspondente.
     */
    public function findAll(): array
    {
        $sql = "SELECT 
                    m.id,
                    m.tipo,
                    m.quantidade,
                    m.data_movimento,
                    p.nome AS nome_produto
                FROM 
                    movimentos_estoque m
                JOIN 
                    produtos p ON m.produto_id = p.id
                ORDER BY 
                    m.data_movimento DESC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Salva uma nova movimentação e atualiza o estoque do produto DENTRO de uma transação.
     *
     * @param array $data Dados da movimentação (produto_id, tipo, quantidade).
     * @return bool True se tudo ocorreu bem.
     * @throws Exception Se o produto não for encontrado ou se o estoque ficar negativo.
     */
    public function save(array $data): bool
    {
        // 1. Inicia a transação
        $this->pdo->beginTransaction();

        try {
            // 2. Busca o produto para verificar o estoque atual
            $produtoModel = new ProdutoModel();
            $produto = $produtoModel->findById($data['produto_id']);

            if (!$produto) {
                throw new Exception("Produto não encontrado.");
            }

            // 3. Verifica se o estoque é suficiente para uma saída
            if ($data['tipo'] === 'saida' && $produto['quantidade'] < $data['quantidade']) {
                throw new Exception("Estoque insuficiente para a saída. Estoque atual: {$produto['quantidade']}.");
            }

            // 4. Insere o registro na tabela de movimentos
            $sqlMovimento = "INSERT INTO movimentos_estoque (produto_id, tipo, quantidade) VALUES (:produto_id, :tipo, :quantidade)";
            $stmtMovimento = $this->pdo->prepare($sqlMovimento);
            $stmtMovimento->execute([
                ':produto_id' => $data['produto_id'],
                ':tipo' => $data['tipo'],
                ':quantidade' => $data['quantidade']
            ]);

            // 5. Calcula o novo estoque
            $novaQuantidade = ($data['tipo'] === 'entrada')
                ? $produto['quantidade'] + $data['quantidade']
                : $produto['quantidade'] - $data['quantidade'];

            // 6. Atualiza a quantidade na tabela de produtos
            $sqlProduto = "UPDATE produtos SET quantidade = :quantidade WHERE id = :id";
            $stmtProduto = $this->pdo->prepare($sqlProduto);
            $stmtProduto->execute([
                ':quantidade' => $novaQuantidade,
                ':id' => $data['produto_id']
            ]);

            // 7. Se tudo deu certo, confirma a transação
            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            // 8. Se algo deu errado, desfaz a transação
            $this->pdo->rollBack();
            // Re-lança a exceção para que o controller possa tratá-la (ex: mostrar erro ao usuário)
            throw $e;
        }
    }
}