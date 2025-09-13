<?php

namespace App\Model;

use App\Core\Database;
use PDO;

class UsuarioModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    /**
     * Busca um usuário pelo seu e-mail.
     *
     * @param string $email O e-mail do usuário.
     * @return array|false Os dados do usuário ou false se não for encontrado.
     */
    public function findByEmail(string $email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Salva um novo usuário no banco de dados, com a senha criptografada.
     *
     * @param string $nome O nome do usuário.
     * @param string $email O e-mail do usuário.
     * @param string $senha A senha em texto puro.
     * @return bool True se salvou com sucesso, False caso contrário.
     */
    public function save(string $nome, string $email, string $senha): bool
    {
        // **PRÁTICA DE SEGURANÇA FUNDAMENTAL**
        // Criptografa a senha usando o algoritmo BCRYPT, o padrão do PHP.
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senhaHash); // Salva o hash, não a senha original

        return $stmt->execute();
    }
}