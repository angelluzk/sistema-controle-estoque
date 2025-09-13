<?php

namespace App\Controller;

use App\Model\CategoriaModel;

class CategoriaController
{
    public function index()
    {
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->findAll();
        require_once '../views/home.php';
    }

    public function create()
    {
        require_once '../views/categorias/novo.php';
    }

    public function store()
    {
        $data = [
            'nome' => $_POST['nome'],
            'descricao' => $_POST['descricao']
        ];
        $categoriaModel = new CategoriaModel();
        $categoriaModel->save($data);
        header('Location: /');
    }

    public function edit()
    {
        $id = (int)$_GET['id'];
        $categoriaModel = new CategoriaModel();
        $categoria = $categoriaModel->findById($id);
        require_once '../views/categorias/editar.php';
    }

    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'nome' => $_POST['nome'],
            'descricao' => $_POST['descricao']
        ];
        $categoriaModel = new CategoriaModel();
        $categoriaModel->update($data);
        header('Location: /');
    }

    public function delete()
    {
        $id = (int)$_POST['id'];
        $categoriaModel = new CategoriaModel();
        $categoriaModel->delete($id);
        header('Location: /');
    }
}