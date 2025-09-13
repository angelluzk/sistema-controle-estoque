<?php

namespace App\Controller;

use App\Model\MovimentoModel;
use App\Model\ProdutoModel;
use Exception;

class MovimentoController
{
    /**
     * Exibe a página de histórico e o formulário de nova movimentação.
     */
    public function index()
    {
        $movimentoModel = new MovimentoModel();
        $movimentos = $movimentoModel->findAll();

        $produtoModel = new ProdutoModel();
        $produtos = $produtoModel->findAll(); // Para o <select> do formulário

        // Para exibir uma mensagem de erro, se houver
        $erro = $_SESSION['erro'] ?? null;
        unset($_SESSION['erro']);

        require_once '../views/movimentos/index.php';
    }

    /**
     * Processa o formulário e salva a nova movimentação.
     */
    public function store()
    {
        // Inicia a sessão para podermos guardar a mensagem de erro
        session_start();

        $data = [
            'produto_id' => $_POST['produto_id'],
            'tipo' => $_POST['tipo'],
            'quantidade' => (int)$_POST['quantidade']
        ];

        // Validação simples
        if (empty($data['produto_id']) || empty($data['tipo']) || $data['quantidade'] <= 0) {
            $_SESSION['erro'] = "Todos os campos são obrigatórios e a quantidade deve ser maior que zero.";
            header('Location: /movimentos');
            return;
        }

        try {
            $movimentoModel = new MovimentoModel();
            $movimentoModel->save($data);
        } catch (Exception $e) {
            // Se o Model lançar uma exceção (ex: estoque insuficiente), guardamos a mensagem
            $_SESSION['erro'] = $e->getMessage();
        }

        header('Location: /movimentos');
    }
}