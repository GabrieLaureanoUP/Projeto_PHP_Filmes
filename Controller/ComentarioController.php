<?php
require_once __DIR__ . '/../Model/Comentario.php';

class ComentarioController {
    public static function comentar() {
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
}