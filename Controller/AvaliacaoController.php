<?php
require_once __DIR__ . '/../Model/Avaliacao.php';

class AvaliacaoController {
    public static function avaliar() {
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
            $nota = $_POST['nota'] ?? null;
            $csrf_token = $_POST['csrf_token'] ?? null;

            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error_message'] = "Erro de segurança!";
                header("Location: index.php?p=avaliar&filme_id={$filme_id}");
                exit();
            }

            if (!$nota || !is_numeric($nota) || $nota < 1 || $nota > 10) {
                $_SESSION['error_message'] = "Por favor, envie uma nota válida entre 1 e 10.";
                header("Location: index.php?p=avaliar&filme_id={$filme_id}");
                exit();
            }

            $sucesso = Avaliacao::salvarOuAtualizar($filme_id, $usuario_id, (int)$nota);

            if ($sucesso) {
                $_SESSION['success_message'] = "Avaliação salva com sucesso!";
            } else {
                $_SESSION['error_message'] = "Erro ao salvar avaliação.";
            }

            header("Location: index.php?p=detalhes&id={$filme_id}");
            exit();
        } else {

            $nota_atual = Avaliacao::NotaUsuario($filme_id, $usuario_id);

            include __DIR__ . '/../View/filmes/avaliar.php';
        }
    }
}