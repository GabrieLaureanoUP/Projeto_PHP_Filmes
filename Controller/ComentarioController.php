<?php
require_once __DIR__ . '/../Model/Comentario.php';
require_once __DIR__ . "/../Config/BancoPdo.php";



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

    public static function listarComentarios($filme_id) {
        if (!$filme_id) {
            echo "<p class='sem-comentarios'>Filme não especificado.</p>";
            return;
        }

        return Comentario::listarComentariosPorFilme($filme_id);
    }

    public static function editar() {
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?p=login');
            exit();
        }
        $comentario_id = $_GET['id'] ?? null;
        if (!$comentario_id) {
            $_SESSION['error_message'] = "Comentário não encontrado!";
            header('Location: index.php?p=listar');
            exit();
        }

        $sql = "SELECT * FROM comentarios WHERE id = :comentario_id AND usuario_id = :usuario_id";
        $stmt = Database::conectar()->prepare($sql);
        $stmt->execute([
            'comentario_id' => $comentario_id,
            'usuario_id' => $_SESSION['usuario']['id']
        ]);
        $comentario = $stmt->fetch();
        if (!$comentario) {
            $_SESSION['error_message'] = "Comentário não encontrado ou você não tem permissão para editá-lo.";
            header('Location: index.php?p=listar');
            exit();
        }
        $filme_id = $comentario['filme_id'];
        include __DIR__ . '/../View/filmes/editarComentario.php';
    }

    static function atualizar() {
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        if (!isset($_SESSION['usuario'])) {
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
            $id = $_POST['id'] ?? null;
            $filme_id = $_POST['filme_id'] ?? null;
            if (!$id || !$filme_id) {
                $_SESSION['error_message'] = "Comentário não encontrado!";
                header('Location: index.php?p=listar');
                exit();
            }
            $novoComentario = $_POST['novoComentario'] ?? '';
            $comentario = Comentario::buscarComentario($id);
            if (!$comentario || $comentario['usuario_id'] != $_SESSION['usuario']['id']) {
                $_SESSION['error_message'] = "Comentário não encontrado ou você não tem permissão para editá-lo.";
                header('Location: index.php?p=listar');
                exit();
            }
            if (Comentario::atualizarComentario($id, $novoComentario)) {
                $_SESSION['success_message'] = "Comentário atualizado com sucesso!";
            } else {
                $_SESSION['error_message'] = "Erro ao atualizar comentário!";
            }
            header('Location: index.php?p=detalhes&id=' . $filme_id);
            exit();
        }
    }
}