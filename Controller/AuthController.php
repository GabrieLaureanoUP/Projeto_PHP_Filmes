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
            exit();
        }

        static function recuperarSenha() {
            
            session_start();
            
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $csrf_token = $_POST['csrf_token'] ?? null;
                if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                    echo "Erro de segurança!";
                } else {
                    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                    $cpf = $_POST['cpf'] ?? '';
                    $cpf = str_replace(['.', '-', ' '], '', $cpf); 
                    $data_nascimento = $_POST['data_nascimento'] ?? '';
                    $nova_senha = $_POST['nova_senha'] ?? '';
                    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
                    
                    if (!$email || strlen($cpf) !== 11 || empty($data_nascimento)) {
                        echo "Preencha todos os campos de identificação corretamente.";
                    } else if (strlen($nova_senha) < 6) {
                        echo "A senha deve ter pelo menos 6 caracteres.";
                    } else if ($nova_senha !== $confirmar_senha) {
                        echo "As senhas não coincidem.";
                    } else {
                        $usuario = Usuario::verificarDadosRecuperacao($email, $cpf, $data_nascimento);
                        
                        if ($usuario) {
                            $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                            
                            if (Usuario::atualizarSenha($usuario['id'], $senha_hash)) {
                                echo "Senha Recuperada, retorne para fazer login!";
                                header("Location: login");
                            } else {
                                echo "Erro ao atualizar senha. Tente novamente.";
                            }
                        } else {
                            echo "Os dados informados não correspondem a nenhum usuário cadastrado.";
                        }
                    }
                }
            }
            
            include __DIR__ . "/../View/usuarios/recuperarSenha.php";
        }
    }

?>