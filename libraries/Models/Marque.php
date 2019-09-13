<?php
namespace Models;

class Marque extends Model
{
    // On recupere toute les marques
    public function findAllDistinct()
    {
        $query = $this->pdo->query("SELECT DISTINCT marque FROM products ORDER BY marque");
        $marques = $query->fetchAll();

        return $marques;
    }
}