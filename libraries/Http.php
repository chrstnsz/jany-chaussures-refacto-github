<?php

class Http{

    // utilisation de tout protocole Http (redirection, session, param get/post)
    static public function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
    
}
