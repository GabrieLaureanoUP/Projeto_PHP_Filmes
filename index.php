<?php     

    $pagina = $_GET['p'] ?? '';

    $url = explode('/', $pagina);
    if (empty($url[0])) {
        $url[0] = '';
    }

    require "Controller/AuthController.php";  
    require "Controller/FilmeController.php";
  
    match($url[0]){
        "login" => AuthController::login(),
        "logout" => AuthController::logout(),
        "recuperar-senha" => AuthController::recuperarSenha(),
        "cadastro" => AuthController::cadastro(),

        "listar" => FilmeController::listar(),
        "criar" => FilmeController::criar(),
        "salvar" => FilmeController::salvar(),
        "editar" => FilmeController::editar(),
        "atualizar" => FilmeController::atualizar(),
        "excluir" => FilmeController::excluir(),
        "buscar" => FilmeController::buscarNomeGenero(),
        "detalhes" => FilmeController::detalhes(),
        
        default => FilmeController::listar()
    }
    
?>