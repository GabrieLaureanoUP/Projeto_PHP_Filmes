<?php

require_once __DIR__ . '/../Model/Filme.php';

class FilmeController{
 public function index()
    {
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $filmes = Filme::listarFilmes();
        include __DIR__ . '/../View/filmes/listar.php';
    }

    public function criar()
    {
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }
        include __DIR__ . '/../View/filmes/criar.php';
    }

    public function salvar()
    {
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? null;
            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                echo "Erro de segurança!";
                include __DIR__ . '/../View/filmes/criar.php';
                return;
            }
            $titulo = $_POST['titulo'];
            $descricao = $_POST['descricao'];
            $ano = $_POST['ano'];
            $genero = $_POST['genero'];
            Filme::criarFilme($titulo, $descricao, $ano, $genero);
            header('Location: /filmes');
            exit;
        }
        include __DIR__ . '/../View/filmes/criar.php';
    }

    public function editar($id)
    {
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }
        $filme = Filme::buscarFilmes($id);
        include __DIR__ . '/../View/filmes/editar.php';
    }

    public function atualizar($id)
    {
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? null;
            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                echo "Erro de segurança!";
                include __DIR__ . '/../View/filmes/editar.php';
                return;
            }
            $titulo = $_POST['titulo'];
            $descricao = $_POST['descricao'];
            $ano = $_POST['ano'];
            $genero = $_POST['genero'];
            Filme::atualizarFilme($id, $titulo, $descricao, $ano, $genero);
            header('Location: /filmes');
            exit;
        }
        $filme = Filme::buscarFilmes($id);
        include __DIR__ . '/../View/filmes/editar.php';
    }

    public function excluir($id)
    {
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? null;
            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                echo "Erro de segurança!";
                return;
            }
            Filme::deletarFilme($id);
            header('Location: /filmes');
            exit;
        }
        header('Location: /filmes');
    }

    public function buscar()
    {
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $termo = isset($_GET['termo']) ? $_GET['termo'] : '';
        $filmes = Filme::buscarPorNomeOuGenero($termo);
        include __DIR__ . '/../View/filmes/listar.php';
    }
}