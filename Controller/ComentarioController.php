<?php
require_once __DIR__ . '/../Model/Comentario.php';
require_once __DIR__ . "/../Config/BancoPdo.php";



class ComentarioController {
    static function comentar() {
        session_start();

        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?p=login');
            exit();
        }

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $usuario_id = $_SESSION['usuario']['id'];
        $filme_id = $_GET['filme_id'] ?? null;

        if (!$filme_id) {
            $_SESSION['error_message'] = "Filme não especificado.";
            header('Location: index.php?p=listar');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comentario = $_POST['comentario'] ?? null;
            $csrf_token = $_POST['csrf_token'] ?? null;

            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error_message'] = "Erro de segurança!";
                header("Location: index.php?p=detalhes&id={$filme_id}");
                exit();
            }

            if (!$comentario) {
                $_SESSION['error_message'] = "Por favor, comente algo.";
                header("Location: index.php?p=detalhes&id={$filme_id}");
                exit();
            }

            $sucesso = Comentario::salvarComentario($filme_id, $usuario_id, $comentario);

            if ($sucesso) {
                $_SESSION['success_message'] = "Comentario feito com sucesso";
            } else {
                $_SESSION['error_message'] = "Erro ao comentar.";
            }

            header("Location: index.php?p=detalhes&id={$filme_id}");
            exit();
        }
    }

    static function salvarComentario() {
        session_start();
        
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error_message'] = "Você precisa estar logado para comentar.";
            header('Location: index.php?p=login');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? null;
            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error_message'] = "Erro de segurança!";
                header('Location: index.php?p=listar');
                exit();
            }
              $filme_id = $_POST['filme_id'] ?? null;
            $texto = trim($_POST['texto']) ?? null;
            $usuario_id = $_SESSION['usuario']['id'] ?? null;
            
            if (!$filme_id || !$texto || !$usuario_id) {
                $_SESSION['error_message'] = "Todos os campos são obrigatórios!";
                header('Location: index.php?p=detalhes&id=' . $filme_id);
                exit();
            }
            
            if (Comentario::criarComentario($filme_id, $usuario_id, $texto)) {
                $_SESSION['success_message'] = "Comentário adicionado com sucesso!";
            } else {
                $_SESSION['error_message'] = "Erro ao adicionar comentário!";
            }
            
            header('Location: index.php?p=detalhes&id=' . $filme_id);
            exit();
        }
        
        header('Location: index.php?p=listar');
        exit();
    }  
}