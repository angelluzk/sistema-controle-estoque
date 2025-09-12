<?php

// src/Controller/ProdutoController.php

namespace App\Controller;

use App\Model\ProdutoModel;
use App\Model\CategoriaModel; // Precisamos importar o CategoriaModel

class ProdutoController
{
    public function index()
    {
        // ... (código existente)
        $produtoModel = new ProdutoModel();
        $produtos = $produtoModel->findAll();
        require_once '../views/produtos/index.php';
    }

    /**
     * Mostra o formulário de criação de produto.
     */
    public function create()
    {
        // Precisamos buscar as categorias para popular o <select> no formulário.
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->findAll();

        require_once '../views/produtos/novo.php';
    }

    /**
     * Processa os dados do formulário e salva o novo produto.
     */
    public function store()
    {
        // 1. Pega os dados do formulário (enviados via POST)
        $data = [
            'nome' => $_POST['nome'],
            'sku' => $_POST['sku'],
            'preco' => $_POST['preco'],
            'quantidade' => $_POST['quantidade'],
            'categoria_id' => $_POST['categoria_id']
        ];

        // 2. Cria uma instância do modelo e salva os dados
        $produtoModel = new ProdutoModel();
        $produtoModel->save($data);

        // 3. Redireciona o usuário de volta para a lista de produtos
        header('Location: /produtos');
    }
}