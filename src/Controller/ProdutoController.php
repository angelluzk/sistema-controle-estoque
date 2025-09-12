<?php

// src/Controller/ProdutoController.php

namespace App\Controller;

use App\Model\ProdutoModel;
use App\Model\CategoriaModel;

class ProdutoController
{
    public function index()
    {
        $produtoModel = new ProdutoModel();
        $produtos = $produtoModel->findAll();
        require_once '../views/produtos/index.php';
    }

    public function create()
    {
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->findAll();
        require_once '../views/produtos/novo.php';
    }

    public function store()
    {
        $data = [
            'nome' => $_POST['nome'],
            'sku' => $_POST['sku'],
            'preco' => $_POST['preco'],
            'quantidade' => $_POST['quantidade'],
            'categoria_id' => $_POST['categoria_id']
        ];
        $produtoModel = new ProdutoModel();
        $produtoModel->save($data);
        header('Location: /produtos');
    }

    public function edit()
    {
        $id = (int)$_GET['id'];
        $produtoModel = new ProdutoModel();
        $produto = $produtoModel->findById($id);
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->findAll();
        require_once '../views/produtos/editar.php';
    }

    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'nome' => $_POST['nome'],
            'sku' => $_POST['sku'],
            'preco' => $_POST['preco'],
            'quantidade' => $_POST['quantidade'],
            'categoria_id' => $_POST['categoria_id']
        ];
        $produtoModel = new ProdutoModel();
        $produtoModel->update($data);
        header('Location: /produtos');
    }
}