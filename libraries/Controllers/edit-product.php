<?php

require_once('../autoload.php');
require('../functions.php');

//utilisation de ces headers pour que les images s'auto refresh et eviter d'avoir des images provenant du cache de l'utilisateur
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// redirection si l'admin n'est pas connecté
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder a cette page.";
    \Http::redirect('index.php');
}

$productModel = New \Models\Product();
$categoryModel = New \Models\Category();
$marqueModel = New \Models\Marque();
$junctionModel = New \Models\Junction();

// Si $_GET['id'] est un entier on continu
if (empty($_GET['id']) || !ctype_digit($_GET['id']) || !isInteger($_GET['id'])) {
    $_SESSION['flash']['danger'] = "Cet identifiant n'existe pas.";
    \Http::redirect('index.php');
}

$product_id = $_GET['id'];

$product = $productModel->findWithCategories($product_id);

// On redirige si l'entrée est vide
if (empty($product) || $product['id'] === NULL) {
    $_SESSION['flash']['danger'] = "Cet identifiant n'existe pas.";
    \Http::redirect('index.php');
}

// On récupère toute les catégories associées à ce produit
$categories_in_product = $categoryModel->findWithProduct($product_id);

// On recupere toute les marques
$marques = $marqueModel->findAllDistinct();

// On recupère toute les catégories
$categories = $categoryModel->findAll();

$marque = $product['marque'];
$modele = $product['modele'];

// On recupère toute les images dans le dossier du modèle du produit
$dirname = "img/products/" . $marque . "/" . $modele . "/";
$images = glob("../../" . $dirname . "*.{jpg,gif,png}", GLOB_BRACE);


// On cherche a savoir quelles catégorie ne sont pas cochés
$array1 = array_column($categories, 'title');
$array2 = array_column($categories_in_product, 'title');
// On recupere les catégories non cochées
$array3 = array_diff($array1, $array2);

if (!empty($_POST)) {

    $errors = array();

    // protections
    if (empty($_POST['description'])) {
        $errors['champs'] = "Renseignez une description.";
    }

    if (strlen($_POST['description']) > 255) {
        $errors['description_length'] = "La description est trop longue.";
    }

    $product_id = $_POST['product_id'];
    $description = $_POST['description'];

    $path = "img/products/" . $marque . "/" . $modele;
    $target_dir = $path . "/";

    if (strlen($path) > 255) {
        $errors['path_length'] = "Chemin du fichier trop long.";
    } else {
        // On créer le chemin si le dossier n'existe pas
        if (!file_exists("../../" . $path)) {
            mkdir("../../" . $path, 0777, true);
        }                
        // On boucle sur tout les fichiers à uploader
        foreach ($_FILES["file"]["name"] as $k => $ar) {
            if (!empty($_FILES["file"]["tmp_name"][$k])){

                $target_file = $target_dir . basename($_FILES["file"]["name"][$k]);

                if (strlen($target_file) > 250) {
                    $errors['length'] = "Nom du fichier trop long.";
                } else {
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // On check le type du fichier
                    $check = getimagesize($_FILES["file"]["tmp_name"][$k]);
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        $errors['type'] = "Ce type de fichier n'est pas autorisé";
                        $uploadOk = 0;
                    }
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $errors['exist'] = "Le fichier existe déjà";
                        $uploadOk = 0;
                    }
                    // Check file size
                    if ($_FILES["file"]["size"][$k] > 500000) {
                        $errors['too_big'] = "Le fichier trop volumineux.";
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "jpeg") {
                        $errors['image_type'] = "Seulement les fichiers de type JPG, JPEG sont autorisés.";
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 1 && empty($errors)) {
                        if (move_uploaded_file($_FILES["file"]["tmp_name"][$k], "../../" . $target_file)) {
                            $_SESSION['flash']['success'] = "Le fichier " . basename($_FILES["file"]["name"][$k]) . " a été uploadé";
                        } else {
                            $errors['big_error'] = "Une erreur est survenue.";
                        }
                    }
                }
            }
        }
        if (!empty($errors)) {
            // On supprime les fichiers créés pour éviter les dossiers morts
            rrmdir("../../" . $path);
        }
    }

    // Si il n'y a pas d'erreurs
    if (empty($errors)) {

        // On edit les données dans la bdd
        $productModel->update($marque, $modele, $description, $product_id);

        $cat_hiver = $_POST['hiver'];
        $cat_automne = $_POST['automne'];
        $cat_printemps = $_POST['printemps'];
        $cat_ete = $_POST['été'];
        $cat_top = $_POST['top'];

        $junctionModel->update($product_id, $cat_hiver, $cat_automne, $cat_printemps, $cat_ete, $cat_top);

        $_SESSION['flash']['success'] = "Entrée bien mise à jour.";
        \Http::redirect('admin.php');
    }
}

\Renderer::render('products/edit', compact(
    'product_id',
    'product',
    'marques',
    'categories',
    'categories_in_product',
    'images',
    'array3',
    'errors'
));


