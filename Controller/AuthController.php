<?php

    require_once __DIR__ . "/../Model/Usuario.php";

    class AuthController {
        
        static function login() {

            session_start();

            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }

            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $usuario_formulario = $_POST['usuario'] ?? null;
                $senha_formulario = $_POST['senha'] ?? null;
                $csrf_token = $_POST['csrf_token'] ?? null;

                if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                    echo "Erro de segunrança!";
                    include __DIR__ . "/../View/login.php";
                    return;
                }
            
                if (!is_null($usuario_formulario) || !is_null($senha_formulario)) {
                    
                    $resp = Usuario::fazerLogin($usuario_formulario, $senha_formulario);

                    if ($resp) {
                        echo "Sucesso!";
                        header("Location: dashboard");
                    } else {
                        echo "Erros X.x";
                    }
                } 
                echo "Fazer Login";
            }

            include __DIR__ . "/../View/usuarios/login.php";
        }

        static function logout() {
            session_start();
            $csrf_token = $_POST['csrf_token'] ?? null;
            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                header("Location: login");
                exit();
            }

            session_unset();
            session_destroy();

            header("Location: login");
            exit()  ;
        }
    }

?>