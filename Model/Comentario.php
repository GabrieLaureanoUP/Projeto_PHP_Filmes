<?php

require_once __DIR__ . "/../Config/BancoPdo.php";

class Comentario{
    public static function salvarComentario($filme_id, $usuario_id, $comentario){
        $sql = "SELECT id FROM comentarios WHERE filme_id = :filme_id AND usuario_id = usuario_id";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute([
          'filmes_id' => $filme_id,
          'usuario_id' => $usuario_id,
        ]);

        if($stmt->fetch()){
            $sql = 'UPDATE comentarios SET comentario = :comentario WHERE filme_id = :filme_id AND usuario_id = :usuario_id';
        }else{
            $sql = 'INSERT INTO comentarios (filme_id, usuario_id, comentario) VALUES (:filme_id, :usuario_id, :comentario)';
        }

    }
}

?>