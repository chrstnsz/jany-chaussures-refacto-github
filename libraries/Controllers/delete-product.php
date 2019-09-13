<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../functions.php');
require_once('../autoload.php');

// redirection si l'admin n'est pas connecté
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder a cette page.";
    \Http::redirect('index.php');
}

if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    \Http::redirect('index.php');
}

$id = $_GET['id'];

$productModel = New \Models\Product();

$product = $productModel->find($id);

if(empty($product)){
    \Http::redirect('index.php');
}

$marque = $product['marque'];
$modele = $product['modele'];

$path = "img/products/" . $marque . "/" . $modele;

if (file_exists("../../" . $path)) {
    rrmdir("../../" . $path);
}

$productModel->delete($id);

$_SESSION['flash']['success'] = "Entrée bien supprimé.";

\Http::redirect('admin.php');
