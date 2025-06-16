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

    public static function exibirComentarios($filme_id) {
        $comentarios = Comentario::obterComentariosPorFilme($filme_id);
        echo '<link rel="stylesheet" href="styleComentarios.css">';
        if ($comentarios) {
           echo '<div class="comentarios-wrapper">';

            foreach ($comentarios as $comentario) {
                echo '<div class="comentario-container">';

                $usuario = Comentario::obterNomeUsuario($comentario['usuario_id']);
                if ($usuario) {
                    echo '<div class="usuario-nome">' . htmlspecialchars($usuario['nome']) . '</div>';
                } else {
                    echo '<div class="usuario-nome">Usuário não encontrado</div>';
                }

                echo '<div class="comentario-texto">' . htmlspecialchars($comentario['comentario']) . '</div>';

                echo '<div class="botoes">';
                echo '<button class="botao botao-editar">Editar</button>';
                echo '<button class="botao botao-excluir">Excluir</button>';
                echo '</div>';

                echo '</div>';
            }

            echo '</div>';
        } else {
            echo '<div class="nenhum-comentario"><strong>Nenhum comentário feito!</strong></div>';
        }
    }
}