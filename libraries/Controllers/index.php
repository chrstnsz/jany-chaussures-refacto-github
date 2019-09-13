<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../autoload.php');

$marqueModel = new \Models\Marque();
$productModel = new \Models\Product();
$categoryModel = new \Models\Category();

$marques = $marqueModel->findAllDistinct();

$top_products = $productModel->findTop();

$selected_category = $categoryModel->findSelected();

/**
 * affichage
 */
\Renderer::render('index', compact(
    'top_products',
    'marques',
    'selected_category'
));
