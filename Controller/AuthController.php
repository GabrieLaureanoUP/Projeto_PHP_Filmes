<?php

    require_once __DIR__ . "/../Model/Usuario.php";

    class AuthController {
        
    static function login() {
        session_start();

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if (isset($_SESSION['usuario'])) {
            header("Location: listar");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $email_formulario = $_POST['email'] ?? null;
            $senha_formulario = $_POST['senha'] ?? null;
            $csrf_token = $_POST['csrf_token'] ?? null;

            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                $_SESSION['error_message'] = "Erro de segurança!";
                include __DIR__ . "/../View/usuarios/login.php";
                return;
            }
        
            if (!is_null($email_formulario) && !is_null($senha_formulario)) {
                $usuario = Usuario::fazerLogin($email_formulario, $senha_formulario);

                if ($usuario) {
                    $_SESSION['usuario'] = [
                        'id' => $usuario['id'],
                        'nome' => $usuario['nome'],
                        'email' => $usuario['email']
                    ];
                    $_SESSION['success_message'] = "Login realizado com sucesso!";
                    header("Location: listar");
                    exit();
                } else {
                    $_SESSION['error_message'] = "Email ou senha inválidos";
                    include __DIR__ . "/../View/usuarios/login.php";
                    return;
                }
            }
        }

        include __DIR__ . "/../View/usuarios/login.php";
    }

        static function logout() {
            session_start();
            $csrf_token = $_POST['csrf_token'] ?? null;
            if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                header("Location: dashboard");
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
                    $email = $_POST['email'] ?? '';
                    $email = trim($email);
                    $cpf = $_POST['cpf'] ?? '';
                    $cpf = str_replace(['.', '-', ' '], '', $cpf); 
                    $data_nascimento = $_POST['data_nascimento'] ?? '';
                    $nova_senha = $_POST['nova_senha'] ?? '';
                    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
                    
                    if (empty($email) || strlen($cpf) !== 11 || empty($data_nascimento)) {
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

        static function cadastro() {
            session_start();
            
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $csrf_token = $_POST['csrf_token'] ?? null;
                
                if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
                    echo "Erro de segurança!";                
                } else {
                    $nome = trim($_POST['nome'] ?? '');
                    $email = $_POST['email'] ?? '';
                    $email = trim($email);
                    $cpf = $_POST['cpf'] ?? '';
                    $cpf = str_replace(['.', '-', ' '], '', $cpf);
                    $data_nascimento = $_POST['data_nascimento'] ?? '';
                    $senha = $_POST['senha'] ?? '';
                    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
                    
                    if (empty($nome) || empty($email) || strlen($cpf) !== 11 || empty($data_nascimento)) {
                        echo "Preencha todos os campos corretamente.";
                    } else if (strlen($senha) < 6) {
                        echo "A senha deve ter pelo menos 6 caracteres.";
                    } else if ($senha !== $confirmar_senha) {
                        echo "As senhas não coincidem.";
                    } else {
                        $cadastrado = Usuario::cadastrar($nome, $email, $cpf, $data_nascimento, $senha);
                        
                        if ($cadastrado) {
                            echo "Cadastro realizado com sucesso! Você já pode fazer login.";
                            header("Location: login");
                        } else {
                            echo "Erro ao cadastrar. Email ou CPF já podem estar em uso.";
                        }
                    }
                }
            }
            
            include __DIR__ . "/../View/usuarios/cadastro.php";
        }
    }

?>