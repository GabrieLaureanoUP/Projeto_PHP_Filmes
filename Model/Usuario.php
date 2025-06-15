<?php

require_once __DIR__ . "/../Config/BancoPdo.php";

    class Usuario {    
        
    public static function fazerLogin($email, $senha) {
        
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {
            // if (session_status() === PHP_SESSION_NONE) {
            //     session_start();
            // }
            // $_SESSION['usuario_id'] = $user['id'];
            // $_SESSION['usuario_nome'] = $user['nome'];

            // return true;
            return $user;
        }

        return false;
    }    
    public static function verificarDadosRecuperacao($email, $cpf, $data_nascimento) {
        $pdo = Database::conectar();
        $sql = "SELECT id FROM usuarios WHERE email = ? AND cpf = ? AND data_nasc = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $cpf, $data_nascimento]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function atualizarSenha($usuario_id, $senha_hash) {
        $pdo = Database::conectar();
        $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$senha_hash, $usuario_id]);
    }

    public static function cadastrar($nome, $email, $cpf, $data_nascimento, $senha) {
        $pdo = Database::conectar();
        
        $sql_verificar = "SELECT COUNT(*) FROM usuarios WHERE email = ? OR cpf = ?";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->execute([$email, $cpf]);
        
        if ($stmt_verificar->fetchColumn() > 0) {
            return false; 
        }
        
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nome, email, senha, cpf, data_nasc) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([$nome, $email, $senha_hash, $cpf, $data_nascimento]);
    }
}