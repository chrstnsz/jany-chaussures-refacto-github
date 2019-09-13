<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../autoload.php');

if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])){
    \Http::redirect('admin.php');
}

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $authModel = New \Models\Auth();

    $user = $authModel->getUser($username);
    
    if(!$user){
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrect.';
    }

    if ($user) {
        if (password_verify($password , $user['password'])) {
            $_SESSION['admin'] = $user;
            $_SESSION['flash']['success'] = "Vous êtes maintenant connecté.";

            $_SESSION['LAST_ACTIVITY'] = time();

            \Http::redirect('admin.php');

        } else {
            $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrect.';
        }
    } else {
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrect.';
    }
}

/**
 * affichage
 */
\Renderer::render('login');
