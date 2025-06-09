<?php     

    $pagina = $_GET['p'] ?? '';

    $url = explode('/', $pagina);
    if (empty($url[0])) {
        $url[0] = '';
    }

    require "Controller/AuthController.php";    
    match($url[0]){
        "login" => AuthController::login(),
        "logout" => AuthController::logout(),
        "recuperar-senha" => AuthController::recuperarSenha(),
        "cadastro" => AuthController::cadastro(),
        default => AuthController::login()
    }
    
?>