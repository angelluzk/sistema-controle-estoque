<?php

namespace App\Controller;

use App\Model\UsuarioModel;

class AuthController
{
    /**
     * Exibe o formulário de registro.
     */
    public function showRegistrationForm()
    {
        require_once '../views/auth/registrar.php';
    }

    /**
     * Processa os dados do formulário de registro.
     */
    public function register()
    {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confirmarSenha = $_POST['confirmar_senha'];

        // Validações simples
        if (empty($nome) || empty($email) || empty($senha)) {
            die("Erro: Todos os campos são obrigatórios.");
        }
        if ($senha !== $confirmarSenha) {
            die("Erro: As senhas não coincidem.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Erro: Formato de e-mail inválido.");
        }

        $usuarioModel = new UsuarioModel();

        // Verifica se o e-mail já está em uso
        if ($usuarioModel->findByEmail($email)) {
            die("Erro: Este e-mail já está cadastrado.");
        }

        // Salva o novo usuário
        if ($usuarioModel->save($nome, $email, $senha)) {
            // Redireciona para uma página de sucesso ou de login (que criaremos depois)
            echo "Usuário registrado com sucesso! Você já pode fazer o login.";
            // header('Location: /login');
        } else {
            die("Erro: Não foi possível registrar o usuário.");
        }
    }
}