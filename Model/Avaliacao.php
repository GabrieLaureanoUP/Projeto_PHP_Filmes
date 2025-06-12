<?php

require_once __DIR__ . "/../Config/BancoPdo.php";

class Avaliacao {

    public static function salvarOuAtualizar($filme_id, $usuario_id, $nota) {
        $sql = "SELECT id FROM avaliacoes WHERE filme_id = :filme_id AND usuario_id = :usuario_id";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute([
            'filme_id' => $filme_id,
            'usuario_id' => $usuario_id,
        ]);

        if ($stmt->fetch()) {
            $sql = "UPDATE avaliacoes SET nota = :nota WHERE filme_id = :filme_id AND usuario_id = :usuario_id";
        } else {
            $sql = "INSERT INTO avaliacoes (filme_id, usuario_id, nota) VALUES (:filme_id, :usuario_id, :nota)";
        }

        $stmt = Database::conectar()->prepare($sql);
        return $stmt->execute([
            'filme_id' => $filme_id,
            'usuario_id' => $usuario_id,
            'nota' => $nota
        ]);
    }

    public static function calcularMediaPorFilme($filmeId) {
        $sql = "SELECT AVG(nota) AS media FROM avaliacoes WHERE filme_id = :filme_id";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['filme_id' => $filmeId]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado && $resultado['media'] !== null ? round($resultado['media'], 1) : null;
    }
    
    public static function NotaUsuario($filme_id, $usuario_id) {
        $sql = "SELECT nota FROM avaliacoes WHERE filme_id = :filme_id AND usuario_id = :usuario_id";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute([
            'filme_id' => $filme_id,
            'usuario_id' => $usuario_id
        ]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['nota'] : null;
    }
}