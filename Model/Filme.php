<?php

require_once __DIR__ . "/../Config/BancoPdo.php";

class Filme {

    public static function listarFilmes() {
        $sql = "SELECT * FROM filmes ORDER BY titulo ASC";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function criarFilme($titulo, $descricao, $ano, $genero, $imagem, $diretor, $duracao) {
        $sql = "INSERT INTO filmes (titulo, descricao, ano, genero, imagem, diretor, duracao)
                VALUES (:titulo, :descricao, :ano, :genero, :imagem, :diretor, :duracao)";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute([
            'titulo' => $titulo,
            'descricao' => $descricao,
            'ano' => $ano,
            'genero' => $genero,
            'imagem' => $imagem,
            'diretor' => $diretor,
            'duracao' => $duracao
        ]);
        return $stmt->rowCount() > 0;
    }

    public static function atualizarFilme($id, $titulo, $descricao, $ano, $genero, $imagem, $diretor, $duracao) {
        $sql = "UPDATE filmes SET titulo = :titulo, descricao = :descricao, ano = :ano, genero = :genero,
                imagem = :imagem, diretor = :diretor, duracao = :duracao WHERE id = :id";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'ano' => $ano,
            'genero' => $genero,
            'imagem' => $imagem,
            'diretor' => $diretor,
            'duracao' => $duracao
        ]);
        return $stmt->rowCount() > 0;
    }

    public static function deletarFilme($id) {
        $sql = "DELETE FROM filmes WHERE id = :id";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
    public static function buscarFilmes($id) {
        $sql = "SELECT * FROM filmes WHERE id = :id";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function buscarPorNomeOuGenero($termo) {
    $sql = "SELECT * FROM filmes WHERE titulo LIKE :termo OR genero LIKE :termo ORDER BY titulo ASC";

    $stmt = Database::conectar()->prepare($sql);
    $stmt->execute([
        'termo' => '%' . $termo . '%'
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}