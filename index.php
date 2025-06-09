<?php 
    // site.com/noticias/economia/19 --- noticias.php?categoria=economia&id=19

    $pagina = $_GET['p'] ?? null;
    var_dump($pagina);
    echo "<br>";

    $url = explode('/', $pagina);
    print_r($url);

    echo "<br>";
    echo "<br>";
    echo "<br>";

    match($url[0]){
        "login" => teste,
    }



?>