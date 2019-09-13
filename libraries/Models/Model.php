<?php
namespace Models;

require_once('../Database.php');

abstract class Model
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = \Database::getPdo();
    }
}