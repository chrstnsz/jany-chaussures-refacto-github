<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../autoload.php');

// redirection si l'admin n'est pas connecté
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder a cette page.";
    \Http::redirect('index.php');
}

if (!empty($_GET['photo']) && !empty($_GET['id']) && ctype_digit($_GET['id'])) {

    $photo_name = $_GET['photo'];
    $id = $_GET['id'];
    $myFile = $photo_name;

    if(!$myFile){
        \Http::redirect('index.php');
    } else {
         unlink($myFile);
        $_SESSION['flash']['success'] = "Photo supprimé.";
    }

    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0");
    header("Refresh: edit-product.php?id=". $id);

    \Http::redirect('edit-product.php?id='. $id);

}else {

    $_SESSION['flash']['danger'] = "Vous n'avez rien à faire ici.";
    \Http::redirect('index.php');
}