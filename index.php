<?php 

    $pagina = $_GET['p'] ?? null;
    var_dump($pagina);
    echo "<br>";

    $url = explode('/', $pagina);
    print_r($url);

    echo "<br>";
    echo "<br>";
    echo "<br>";

    require "Controller/AuthController.php";

    match($url[0]){
        "login" => AuthController::login(),
        "logout" => AuthController::logout()
    }



?>