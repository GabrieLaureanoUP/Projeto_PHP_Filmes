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

    static function home() {
        session_start();
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $filmesPopulares = Filme::buscarFilmesPopulares();
        $estatisticas = Filme::getEstatisticas();
        
        include __DIR__ . '/../View/home.php';
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

            $titulo = trim($_POST['titulo']);
            $descricao = trim($_POST['descricao']);
            $ano = trim($_POST['ano']);
            $genero = trim($_POST['genero']);
            $imagem = trim($_POST['imagem'] ?? '');
            $diretor = trim($_POST['diretor'] ?? '');
            $duracao = trim($_POST['duracao'] ?? '');

            if (Filme::verificarFilmeExistente($titulo)) {
                $_SESSION['error_message'] = "Já existe um filme cadastrado com este título.";
                header('Location: criar');
                exit();
            }

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

            $titulo = trim($_POST['titulo']);
            $descricao = trim($_POST['descricao']);
            $ano = trim($_POST['ano']);
            $genero = trim($_POST['genero']);
            $imagem = trim($_POST['imagem'] ?? '');
            $diretor = trim($_POST['diretor'] ?? '');
            $duracao = trim($_POST['duracao'] ?? '');

            $filmeAtual = Filme::buscarFilmes($id);
            if (strtoupper($filmeAtual['titulo']) !== strtoupper($titulo) && 
                Filme::verificarFilmeExistente($titulo)) {
                $_SESSION['error_message'] = "Já existe um filme cadastrado com este título.";
                header('Location: editar');
                exit();
            }

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

        if (!isset($_GET['termo']) || empty(trim($_GET['termo']))) {
            $filmes = Filme::listarFilmes();
        } else {
            $termo = trim($_GET['termo']);
            $filmes = Filme::buscarPorNomeOuGenero($termo);
        }

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

        require_once __DIR__ . '/../Model/Avaliacao.php';

        $media = Avaliacao::calcularMediaPorFilme($id);
        $nota_atual = null;

        if (isset($_SESSION['usuario']['id'])) {
            $usuario_id = $_SESSION['usuario']['id'];
            $nota_atual = Avaliacao::NotaUsuario($id, $usuario_id);
        }

        include __DIR__ . '/../View/filmes/detalhes.php';
    }
}