<?php

class Database
{
    static public function getPdo()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=jany-chaussures;charset=utf8', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        return $pdo;
    }
}
