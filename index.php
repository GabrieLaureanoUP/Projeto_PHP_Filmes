<?php     

    $pagina = $_GET['p'] ?? '';

    $url = explode('/', $pagina);
    if (empty($url[0])) {
        $url[0] = '';
    }

    require "Controller/AuthController.php";  
    require "Controller/FilmeController.php";
    require "Controller/AvaliacaoController.php";
    require "Controller/ComentarioController.php";
  
    match($url[0]){
        "login" => AuthController::login(),
        "logout" => AuthController::logout(),
        "recuperar-senha" => AuthController::recuperarSenha(),
        "cadastro" => AuthController::cadastro(),

        "home" => FilmeController::home(),
        "listar" => FilmeController::listar(),
        "criar" => FilmeController::criar(),
        "salvar" => FilmeController::salvar(),
        "editar" => FilmeController::editar(),
        "atualizar" => FilmeController::atualizar(),
        "excluir" => FilmeController::excluir(),
        "buscarNomeGenero" => FilmeController::buscarNomeGenero(),
        "detalhes" => FilmeController::detalhes(),        
        
        "comentar" => ComentarioController::comentar(),
        "avaliar" => AvaliacaoController::avaliar(),
        
        default => FilmeController::home()
    }
    
?>