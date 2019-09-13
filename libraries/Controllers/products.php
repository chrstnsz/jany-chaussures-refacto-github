<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once('../autoload.php');

$marqueModel = new \Models\Marque();
$productModel = new \Models\Product();
$categoryModel = new \Models\Category();

$marques = $marqueModel->findAllDistinct();

if(isset($_GET['marque']) && !empty($_GET['marque'])){

    $marque = htmlspecialchars($_GET['marque']);

    if($marque === "all"){
        \Http::redirect('products.php');
    }
    
    $pagesTotales = $productModel->paginationByMarque($marque);

    if (isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] < $pagesTotales) {
        $page = intval($_GET['page']);
    } else {
        $page = 1;
    }
    $startPage = ($page - 1) * $productModel->getProductparPage();

    $products = $productModel->findByMarque($marque, $startPage);

    if (empty($products)) {
        $_SESSION['flash']['danger'] = "Cette page n'existe pas !";
        \Http::redirect('products.php');
    }

}else if(isset($_GET['sort']) && !empty($_GET['sort'])){

    $sort = htmlspecialchars($_GET['sort']);

    $pagesTotales = $productModel->paginationByCategory($sort);

    if (isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] < $pagesTotales) {
        $page = intval($_GET['page']);
    } else {
        $page = 1;
    }

    $startPage = ($page - 1) * $productModel->getProductparPage();

    $products = $productModel->findByCategory($sort, $startPage);

    if (empty($products)) {
        $_SESSION['flash']['danger'] = "Cette page n'existe pas !";
        \Http::redirect('products.php');
    }

}else{

    $pagesTotales = $productModel->paginationAll();

    if (isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] < $pagesTotales) {
        $page = intval($_GET['page']);
    } else {
        $page = 1;
    }
    $startPage = ($page - 1) * $productModel->getProductparPage();

    $products = $productModel->findAll($startPage);
}

if ($products === null) {
    $_SESSION['flash']['danger'] = "Cette page n'existe pas !";
    \Http::redirect('products.php');
}

/**
 * affichage
 */
\Renderer::render('products/products', compact(
    'page',
    'pagesTotales',
    'products',
    'marques',
    'marque',
    'firstFile'
    ));

