<?php

// src/Controller/CategoriaController.php

namespace App\Controller;

use App\Model\CategoriaModel;

class CategoriaController
{
    /**
     * Exibe a página de listagem de categorias.
     */
    public function index()
    {
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->findAll();
        // Vamos reutilizar a view 'home.php' por enquanto
        require_once '../views/home.php';
    }

    /**
     * Exibe o formulário de criação de categoria.
     */
    public function create()
    {
        require_once '../views/categorias/novo.php';
    }

    /**
     * Processa os dados do formulário e salva a nova categoria.
     */
    public function store()
    {
        $data = [
            'nome' => $_POST['nome'],
            'descricao' => $_POST['descricao']
        ];

        $categoriaModel = new CategoriaModel();
        $categoriaModel->save($data);

        // Redireciona para a página inicial (lista de categorias)
        header('Location: /');
    }
}