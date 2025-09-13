<?php

namespace App\Controller;

use App\Model\ProdutoModel;
use App\Model\MovimentoModel;

class DashboardController
{
    public function index()
    {
        $produtoModel = new ProdutoModel();
        $movimentoModel = new MovimentoModel();

        // Coleta todas as estatísticas para o dashboard
        $stats = [
            'total_produtos' => $produtoModel->getTotalCount(),
            'total_itens_estoque' => $produtoModel->getTotalStockQuantity(),
            'ultimos_movimentos' => $movimentoModel->findLatest(5)
        ];

        require_once '../views/dashboard/index.php';
    }
}