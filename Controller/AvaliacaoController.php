<?php
require_once __DIR__ . '/../Model/Avaliacao.php';

class AvaliacaoController {
    public static function avaliar() {
        session_start();

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error_message'] = "Você precisa estar logado para avaliar.";
            header("Location: index.php?p=login");
            exit();
        }

        $usuario_id = $_SESSION['usuario']['id'];
        $filme_id = $_GET['filme_id'] ?? null;
        $nota = $_POST['nota'] ?? null;
        $csrf_token = $_POST['csrf_token'] ?? null;

        if (!$filme_id || !$nota || !is_numeric($nota) || $nota < 1 || $nota > 10) {
            $_SESSION['error_message'] = "Nota inválida.";
            header("Location: index.php?p=detalhes&id={$filme_id}");
            exit();
        }

        if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
            $_SESSION['error_message'] = "Erro de segurança.";
            header("Location: index.php?p=detalhes&id={$filme_id}");
            exit();
        }

        $ok = Avaliacao::salvarOuAtualizar($filme_id, $usuario_id, (int)$nota);

        $_SESSION['success_message'] = $ok ? "Avaliação registrada." : "Erro ao registrar avaliação.";
        header("Location: index.php?p=detalhes&id={$filme_id}");
        exit();
    }
}