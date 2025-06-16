<?php

require_once __DIR__ . "/../Config/BancoPdo.php";

class Comentario{    
    public static function criarComentario($filme_id, $usuario_id, $texto) {
        $sql = "INSERT INTO comentarios (filme_id, usuario_id, comentario) 
                VALUES (:filme_id, :usuario_id, :comentario)";
                
        $stmt = Database::conectar()->prepare($sql);
        $resultado = $stmt->execute([
            'filme_id' => $filme_id,
            'usuario_id' => $usuario_id,
            'comentario' => $texto
        ]);
        
        return $resultado;
    }
    
    public static function listarComentariosPorFilme($filme_id) {
        $sql = "SELECT c.*, c.comentario as texto, IFNULL(c.data_comentario, NOW()) as data_comentario, u.nome as nome_usuario 
                FROM comentarios c 
                JOIN usuarios u ON c.usuario_id = u.id 
                WHERE c.filme_id = :filme_id";
                
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['filme_id' => $filme_id]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function salvarComentario($filme_id, $usuario_id, $comentario){
        return self::criarComentario($filme_id, $usuario_id, $comentario);
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

    public static function buscarComentario($comentario_id) {
        $sql = "SELECT * FROM comentarios WHERE id = :comentario_id";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['comentario_id' => $comentario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function atualizarComentario($comentario_id, $novo_comentario) {
        $sql = "UPDATE comentarios SET comentario = :comentario WHERE id = :comentario_id";
        $stmt = Database::conectar()->prepare($sql);
        return $stmt->execute([
            'comentario' => $novo_comentario,
            'comentario_id' => $comentario_id
        ]);
    }

    public static function excluirComentario($comentario_id) {
        $sql = "DELETE FROM comentarios WHERE id = :comentario_id";
        $stmt = Database::conectar()->prepare($sql);
        return $stmt->execute(['comentario_id' => $comentario_id]);
    }
}