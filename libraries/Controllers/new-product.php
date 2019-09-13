<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../functions.php');

require_once('../autoload.php');

$productModel = new \Models\Product();
$categoryModel = new \Models\Category();
$marqueModel = new \Models\Marque();
$junctiontModel = new \Models\Junction();

// redirection si l'admin n'est pas connecté
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder a cette page.";
    \Http::redirect('index.php');
}

// On recupere toute les marques
$marques = $marqueModel->findAllDistinct();

// On recupère toute les catégories
$categories = $categoryModel->findAll();

// si le formulaire est envoyé
if(!empty($_POST)){

    $errors = array();
    
    // protections
    if(empty($_POST['modele']) || empty($_POST['description']) || (empty($_POST['marque']) && empty($_POST['add_marque']))){
        $errors['champs'] = "Renseignez les champs correctement.";
    }   

    if(strlen($_POST['modele']) > 100){
        $errors['modele_length'] = "Le nom du modele est trop long.";
    }

    if (strlen($_POST['description']) > 255) {
        $errors['description_length'] = "La description est trop longue.";
    }

    // On vérifie quel champ marque a été utilisé
    if(empty($_POST['marque']) && !empty($_POST['add_marque'])){
        $marque = $_POST['add_marque'];
    } else if (!empty($_POST['marque']) && !empty($_POST['add_marque'])) {
        $marque = $_POST['add_marque'];
    }else if(!empty($_POST['marque']) && empty($_POST['add_marque'])){
        $marque = $_POST['marque'];
    }else {
        $_SESSION['flash']['danger'] = "Erreur.";
        \Http::redirect('index.php');
    }

    if (strlen($marque) > 100) {
        $errors['marque_length'] = "Le nom de la marque est trop long.";
    }

    $modele = $_POST['modele'];
    $description = $_POST['description'];

    // On créer un dossier pour stocker les photos du modele
    $path = "img/products/" . $marque . "/" . $modele;

    if(strlen($path) > 255){
        $errors['path_length'] = "Chemin du fichier trop long.";
    }else {
        // On créer le chemin si le dossier n'existe pas
        if(!file_exists("../../" . $path)){
            mkdir("../../" . $path, 0777, true);
        }
        $target_dir = $path . "/";
    
        // On boucle sur tout les fichiers à uploader
        foreach($_FILES["file"]["name"] as $k => $ar){

            $target_file = $target_dir . basename($_FILES["file"]["name"][$k]);

            // On redirige si rien n'est uploadé
            if ($_FILES['file']['error'][$k] == UPLOAD_ERR_NO_FILE) {
                $errors['empty_upload'] = "Vous devez uploader des photos.";        
            } else if (strlen($target_file) > 250) {
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

                // if everything is ok, try to upload file
                if ($uploadOk == 1 && empty($errors)) {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"][$k], "../../" . $target_file)) {
                        $_SESSION['flash']['success'] = "Le fichier " . basename($_FILES["file"]["name"][$k]) . " a été uploadé";
                    } else {
                        $errors['big_error'] = "Une erreur est survenue.";
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
    if(empty($errors)){

        // On rentre les données dans la bdd
        $product_id = $productModel->insert($marque, $modele, $description);

        // Si des checkbox categories sont cochés alors on les rentre en bdd
        // On vérifie si il y a une ou plusieurs checkbox cochées
        $checkboxes = isset($_POST['categorie']) ? $_POST['categorie'] : array();
        // On rentre la valeur des checkbox en bdd pour chaques checkbox cochées
        foreach ($checkboxes as $value)
        {
            // On rentre les données dans la bdd seulement si la value de la catégorie est un integer entier
            if(isInteger($value)){
                $junctiontModel->insert($product_id, $value);
            }
        }

        $_SESSION['flash']['success'] = "Nouvelle entrée bien enregistrée !";

        \Http::redirect('admin.php');
    }
}

\Renderer::render('products/new', compact(
    'marques',
    'categories',
    'errors'
));