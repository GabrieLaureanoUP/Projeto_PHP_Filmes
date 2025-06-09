<?php

require_once __DIR__ . "/../Config/BancoPdo.php";

class Usuario {

    public static function fazerLogin($usuario, $senha) {
        $sql = "SELECT * FROM usuarios WHERE nome = :usuario LIMIT 1";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['usuario' => $usuario]);

        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];

            return true;
        }

        return false;
    }
}
