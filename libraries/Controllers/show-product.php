<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../autoload.php');

if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    $_SESSION['flash']['danger'] = "Cet identifiant n'existe pas.";
    \Http::redirect('index.php');
}

$id = $_GET['id'];

$productModel = new \Models\Product();

$product = $productModel->find($id);

if (empty($product)) {
    $_SESSION['flash']['danger'] = "Cet identifiant n'existe pas";
}

$marque = $product['marque'];
$modele = $product['modele'];

$dirname = "img/products/" . $marque . "/" . $modele . "/";
$images = glob("../../" . $dirname . "*.{jpg,gif,png}", GLOB_BRACE);

$directory = "img/products/" . $product['marque'] . "/" . $product['modele'] . "/";

if ($file = glob("../../" . $directory . "/*")){
    $files = scandir("../../" . $directory);
    $firstFile = $directory . $files[2];
} else {
    $firstFile = "img/products/image-not-found.jpg";
}

/**
 * affichage
 */
\Renderer::render('products/show', compact(
    'product',
    'images',
    'firstFile'
));
