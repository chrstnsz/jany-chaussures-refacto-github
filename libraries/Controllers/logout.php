<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

unset($_SESSION['admin']);

$_SESSION['flash']['success'] = "Vous êtes maintenant déconnecté(e).";

header('Location: index.php');
