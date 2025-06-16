<?php

require_once __DIR__ . "/../Config/BancoPdo.php";

class Comentario{
    public static function salvarComentario($filme_id, $usuario_id, $comentario){
        try {
            echo '<div style="color:blue;">DEBUG: filme_id=' . htmlspecialchars($filme_id) . ' usuario_id=' . htmlspecialchars($usuario_id) . ' comentario=' . htmlspecialchars($comentario) . '</div>';
            $sql = "SELECT id FROM comentarios WHERE filme_id = :filme_id AND usuario_id = :usuario_id";

            $stmt = Database::conectar()->prepare($sql);
            $stmt->execute([
              'filme_id' => $filme_id,
              'usuario_id' => $usuario_id,
            ]);

        
            $sql = 'INSERT INTO comentarios (filme_id, usuario_id, comentario) VALUES (:filme_id, :usuario_id, :comentario)';

            $stmt = Database::conectar()->prepare($sql);
            $result = $stmt->execute([
                'filme_id' => $filme_id,
                'usuario_id' => $usuario_id,
                'comentario' => $comentario
            ]);
            echo '<div style="color:green;">DEBUG: execute result = ' . var_export($result, true) . '</div>';
            return $result;
        } catch (PDOException $e) {
            echo '<div style="color:red;">Erro PDO: ' . htmlspecialchars($e->getMessage()) . '</div>';
            return false;
        }
    }

    public static function obterComentariosPorFilme($filme_id) {
        $sql = "SELECT usuario_id, comentario FROM comentarios WHERE filme_id = :filme_id";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['filme_id' => $filme_id]);
        return $stmt->fetchAll();
    }

    public static function obterNomeUsuario($usuario_id) {
        $sql = "SELECT nome FROM usuarios WHERE id = :usuario_id";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['usuario_id' => $usuario_id]);
        return $stmt->fetch();
    }
}