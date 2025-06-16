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
        $termo = trim($termo); 
        
        $sql = "SELECT * FROM filmes WHERE 
                UPPER(titulo) = UPPER(:termo) OR 
                UPPER(genero) = UPPER(:termo)
                ORDER BY titulo ASC";
                
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['termo' => $termo]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function verificarFilmeExistente($titulo) {
        $titulo = trim(strtoupper($titulo));
        
        $sql = "SELECT COUNT(*) FROM filmes WHERE UPPER(TRIM(titulo)) = :titulo";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute(['titulo' => $titulo]);
        
        return $stmt->fetchColumn() > 0;
    }

    public static function buscarFilmesPopulares($limite = 6) {
        $sql = "SELECT f.*, 
                COUNT(DISTINCT c.id) as total_comentarios,
                COUNT(DISTINCT a.id) as total_avaliacoes,
                COALESCE(AVG(a.nota), 0) as media_avaliacoes
                FROM filmes f
                LEFT JOIN comentarios c ON f.id = c.filme_id
                LEFT JOIN avaliacoes a ON f.id = a.filme_id
                GROUP BY f.id, f.titulo, f.descricao, f.ano, f.genero, f.imagem, f.diretor, f.duracao
                ORDER BY (COUNT(DISTINCT c.id) + COUNT(DISTINCT a.id)) DESC, media_avaliacoes DESC
                LIMIT ?";

        $stmt = Database::conectar()->prepare($sql);
        $stmt->bindValue(1, $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEstatisticas() {
        $conn = Database::conectar();
        
        $sqlFilmes = "SELECT COUNT(*) FROM filmes";
        $totalFilmes = $conn->query($sqlFilmes)->fetchColumn();
        
        $sqlGeneros = "SELECT genero, COUNT(*) as total 
                    FROM filmes 
                    GROUP BY genero 
                    ORDER BY total DESC 
                    LIMIT 5";
        $generosPopulares = $conn->query($sqlGeneros)->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'total_filmes' => $totalFilmes,
            'generos_populares' => $generosPopulares
        ];
    }

}