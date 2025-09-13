<?php

namespace App\Controller;

use App\Model\CategoriaModel;

class HomeController
{
    public function index()
    {
        // 1. Cria uma instância do nosso CategoriaModel.
        $categoriaModel = new CategoriaModel();

        // 2. Chama o método findAll() para buscar todas as categorias.
        $categorias = $categoriaModel->findAll();

        // 3. Carrega a view. A variável $categorias estará disponível
        // dentro do arquivo home.php porque ele é "incluído" neste escopo.
        require_once '../views/home.php';
    }
}