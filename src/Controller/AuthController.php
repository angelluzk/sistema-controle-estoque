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
        if ($usuarioModel->findByEmail($email)) { die("Erro: Este e-mail já está cadastrado."); }
        if ($usuarioModel->save($nome, $email, $senha)) {
            header('Location: /login');
        } else {
            die("Erro: Não foi possível registrar o usuário.");
        }
    }
/**
     * Exibe o formulário de login.
     */
    public function showLoginForm()
    {
        require_once '../views/auth/login.php';
    }

    /**
     * Processa a tentativa de login.
     */
    public function login()
    {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->findByEmail($email);

        // Verifica se o usuário existe e se a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido: guarda os dados do usuário na sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            
            // Redireciona para a página principal do sistema
            header('Location: /');
        } else {
            // Login falhou: define uma mensagem de erro e redireciona de volta
            $_SESSION['erro_login'] = "E-mail ou senha inválidos.";
            header('Location: /login');
        }
    }

    /**
     * Realiza o logout do usuário.
     */
    public function logout()
    {
        // Limpa todas as variáveis de sessão
        session_unset();
        // Destrói a sessão
        session_destroy();

        // Redireciona para a página de login
        header('Location: /login');
    }
}