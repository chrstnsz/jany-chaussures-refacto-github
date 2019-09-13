<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../functions.php');
require_once('../autoload.php');

// redirection si l'admin n'est pas connecté
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder a cette page.";
    \Http::redirect('index.php');
}

$categoryModel = New \Models\Category();

$categories = $categoryModel->findIsNews();

if(!empty($_POST)){

    if (empty($_POST['category_choice']) || !ctype_digit($_POST['category_choice']) || !isInteger($_POST['category_choice'])) {
        $_SESSION['flash']['danger'] = "Cet identifiant n'existe pas.";
        \Http::redirect('index.php');
    }

    $id = $_POST['category_choice'];

    $selected_category =  $categoryModel->find($id);

    if(empty($selected_category)){
        \Http::redirect('index.php');
    }

    $categoryModel->updateSelectedNews($id);

    $_SESSION['flash']['success'] = "Section News modifiée.";

    \Http::redirect('index.php');
}

\Renderer::render('change-news', compact(
    'categories'
));