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

<<<<<<< HEAD
    public static function listarComentarios($filme_id) {
        if (!$filme_id) {
            echo "<p class='sem-comentarios'>Filme não especificado.</p>";
            return;
        }

        return Comentario::listarComentariosPorFilme($filme_id);
    }
=======
    public static function exibirComentarios() {
    $filme_id = $_SESSION['filme_id'] ?? null;

    if (!$filme_id) {
        echo "<div class='nenhum-comentario'><strong>Filme não especificado!</strong></div>";
        return;
    }

    $comentarios = Comentario::obterComentariosPorFilme($filme_id);
    echo '<link rel="stylesheet" href="styleComentarios.css">';
    
    if ($comentarios) {
        echo '<div class="comentarios-wrapper">';
        
        foreach ($comentarios as $comentario) {
            echo '<div class="comentario-container">';
            $usuario = Comentario::obterNomeUsuario($comentario['usuario_id']);
            echo '<div class="usuario-nome">' . htmlspecialchars($usuario ? $usuario['nome'] : 'Usuário não encontrado') . '</div>';
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

    // static function salvarComentario() {
    //     session_start();
        
    //     if (!isset($_SESSION['usuario'])) {
    //         $_SESSION['error_message'] = "Você precisa estar logado para comentar.";
    //         header('Location: index.php?p=login');
    //         exit();
    //     }
        
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $csrf_token = $_POST['csrf_token'] ?? null;
    //         if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    //             $_SESSION['error_message'] = "Erro de segurança!";
    //             header('Location: index.php?p=listar');
    //             exit();
    //         }
    //           $filme_id = $_POST['filme_id'] ?? null;
    //         $texto = trim($_POST['texto']) ?? null;
    //         $usuario_id = $_SESSION['usuario']['id'] ?? null;
            
    //         if (!$filme_id || !$texto || !$usuario_id) {
    //             $_SESSION['error_message'] = "Todos os campos são obrigatórios!";
    //             header('Location: index.php?p=detalhes&id=' . $filme_id);
    //             exit();
    //         }
            
    //         if (Comentario::criarComentario($filme_id, $usuario_id, $texto)) {
    //             $_SESSION['success_message'] = "Comentário adicionado com sucesso!";
    //         } else {
    //             $_SESSION['error_message'] = "Erro ao adicionar comentário!";
    //         }
            
    //         header('Location: index.php?p=detalhes&id=' . $filme_id);
    //         exit();
    //     }
        
    //     header('Location: index.php?p=listar');
    //     exit();
    // }  
>>>>>>> b84a8710e877aac9d0a929206f91b0680f794de0
}