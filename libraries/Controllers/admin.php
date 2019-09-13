<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../autoload.php');

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder a cette page.";
    \Http::redirect('index.php');
}

$productModel = New \Models\Product();

$products = $productModel->findAllForAdmin();

/**
 * affichage
 */
\Renderer::render('admin', compact(
    'products'
));
