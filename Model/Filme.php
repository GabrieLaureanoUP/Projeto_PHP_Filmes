<?php

require_once __DIR__ . "/../Config/BancoPdo.php";

class Filme {

    public static function buscarFilmes() {
        $sql = "SELECT * FROM filmes ORDER BY titulo ASC";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function criarFilme($titulo, $descricao, $ano, $genero) {
        $sql = "INSERT INTO filmes (titulo, descricao, ano, genero) VALUES (:titulo, :descricao, :ano, :genero)";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute([
            'titulo' => $titulo,
            'descricao' => $descricao,
            'ano' => $ano,
            'genero' => $genero
        ]);

        return $stmt->rowCount() > 0;
    }

    public static function atualizarFilme($id, $titulo, $descricao, $ano, $genero) {
        $sql = "UPDATE filmes SET titulo = :titulo, descricao = :descricao, ano = :ano, genero = :genero WHERE id = :id";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'ano' => $ano,
            'genero' => $genero
        ]);

        return $stmt->rowCount() > 0;
    }

    public static function deletarFilme($id) {
        $sql = "DELETE FROM filmes WHERE id = :id";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }


}