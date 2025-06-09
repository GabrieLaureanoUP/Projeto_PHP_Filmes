<?php

require_once __DIR__ . '/../Model/Filme.php';

class FilmeController
{
    public function index(){
        $filmes = Filme::listarFilmes();
        include __DIR__ . '/../View/filmes/listar.php';
    }

    public function criar(){
        include __DIR__ . '/../View/filmes/criar.php';
    }

    public function salvar(){
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $ano = $_POST['ano'];
        $genero = $_POST['genero'];
        Filme::criarFilme($titulo, $descricao, $ano, $genero);
        header('Location: /filmes');
    }

    public function editar($id)
    {
        $filme = Filme::buscarFilmes($id);
        include __DIR__ . '/../View/editar.php';
    }

    public function atualizar($id)
    {
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $ano = $_POST['ano'];
        $genero = $_POST['genero'];
        Filme::atualizarFilme($id, $titulo, $descricao, $ano, $genero);
        header('Location: /filmes');
    }

    public function excluir($id)
    {
        Filme::deletarFilme($id);
        header('Location: /filmes');
    }
}