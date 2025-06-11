<?php

require_once __DIR__ . '/../Model/Filme.php';

class FilmeController {
    
    static function listar() {
        session_start();
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $filmes = Filme::listarFilmes();
        include __DIR__ . '/../View/filmes/listar.php';
    }

    static function criar() {
        session_start();
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: login');
            exit();
        }

        include __DIR__ . '/../View/filmes/criar.php';
    }

    static function salvar() {
        session_start();
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? null;
            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error_message'] = "Erro de segurança!";
                header('Location: listar');
                exit();
            }

                $titulo = $_POST['titulo'];
                $descricao = $_POST['descricao'];
                $ano = $_POST['ano'];
                $genero = $_POST['genero'];
                $imagem = $_POST['imagem'];
                $diretor = $_POST['diretor'];
                $duracao = $_POST['duracao'];

            if (!$titulo || !$descricao || !$ano || !$genero) {
                $_SESSION['error_message'] = "Por favor, preencha todos os campos!";
                header('Location: criar');
                exit();
            }

            if (Filme::criarFilme($titulo, $descricao, 
            $ano, $genero, $imagem, $diretor, $duracao)) {
                $_SESSION['success_message'] = "Filme criado com sucesso!";
                header('Location: listar');
                exit();
            } else {
                $_SESSION['error_message'] = "Erro ao criar filme!";
                header('Location: criar');
                exit();
            }
        }

        header('Location: criar');
        exit();
    }

    static function editar() {
        session_start();
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: login');
            exit();
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['error_message'] = "Filme não encontrado!";
            header('Location: listar');
            exit();
        }

        $filme = Filme::buscarFilmes($id);
        if (!$filme) {
            $_SESSION['error_message'] = "Filme não encontrado!";
            header('Location: listar');
            exit();
        }

        include __DIR__ . '/../View/filmes/editar.php';
    }

    static function atualizar() {
        session_start();
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? null;
            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error_message'] = "Erro de segurança!";
                header('Location: listar');
                exit();
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error_message'] = "Filme não encontrado!";
                header('Location: listar');
                exit();
            }

            $filme = Filme::buscarFilmes($id);
            if (!$filme) {
                $_SESSION['error_message'] = "Filme não encontrado!";
                header('Location: listar');
                exit();
            }

            $titulo = $_POST['titulo'];
            $descricao = $_POST['descricao'];
            $ano = $_POST['ano'];
            $genero = $_POST['genero'];
            $imagem = $_POST['imagem'];
            $diretor = $_POST['diretor'];
            $duracao = $_POST['duracao'];

            if (!$titulo || !$descricao || !$ano || !$genero) {
                $_SESSION['error_message'] = "Por favor, preencha todos os campos!";
                header('Location: listar');
                exit();
            }

            if (Filme::atualizarFilme($id, $titulo, $descricao,
            $ano, $genero, $imagem, $diretor, $duracao)) {
                $_SESSION['success_message'] = "Filme atualizado com sucesso!";
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar filme!";
            }
            header('Location: listar');
            exit();
        }
    }

    static function excluir() {
        session_start();
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if (!isset($_SESSION['usuario'])) {
            header('Location: login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? null;
            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error_message'] = "Erro de segurança!";
                header('Location: listar');
                exit();
            }

            $id = $_POST['id'] ?? null;
            if (!$id) {
                $_SESSION['error_message'] = "Filme não encontrado!";
                header('Location: listar');
                exit();
            }

            $filme = Filme::buscarFilmes($id);
            if (!$filme) {
                $_SESSION['error_message'] = "Filme não encontrado!";
                header('Location: listar');
                exit();
            }

            if (Filme::deletarFilme($id)) {
                $_SESSION['success_message'] = "Filme excluído com sucesso!";
            } else {
                $_SESSION['error_message'] = "Erro ao excluir filme!";
            }
        }

        header('Location: listar');
        exit();
    }

    static function buscarNomeGenero() {
        session_start();
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $termo = $_GET['termo'] ?? '';
        $filmes = Filme::buscarPorNomeOuGenero($termo);
        include __DIR__ . '/../View/filmes/listar.php';
    }

    static function detalhes() {
        session_start();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error_message'] = "Filme não encontrado!";
            header('Location: index.php?p=listar');
            exit();
        }

        $filme = Filme::buscarFilmes($id);
        if (!$filme) {
            $_SESSION['error_message'] = "Filme não encontrado!";
            header('Location: index.php?p=listar');
            exit();
        }

        include __DIR__ . '/../View/filmes/detalhes.php';
    }
}