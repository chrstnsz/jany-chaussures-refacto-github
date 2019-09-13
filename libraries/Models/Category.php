<?php
namespace Models;

class Category extends Model
{
    public function findAll()
    {
        // On recupère toute les catégories
        $query = $this->pdo->query("SELECT * from categories");
        $categories = $query->fetchAll();

        return $categories;
    }
    
    public function findSelected()
    {
        $query = $this->pdo->query("SELECT * FROM categories WHERE selected_category = 1");
        $selected_category = $query->fetch();

        return $selected_category;
    }

    public function findIsNews()
    {
        $query = $this->pdo->query("SELECT category_id, title FROM categories WHERE is_news = '1'");
        $categories = $query->fetchAll();

        return $categories;
    }

    public function find($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM categories WHERE category_id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        $selected_category = $query->fetch();

        return $selected_category;
    }

    public function updateSelectedNews($id)
    {
        $query = $this->pdo->query('UPDATE categories SET selected_category = 0');
        $query->execute();

        $query = $this->pdo->prepare("UPDATE categories SET selected_category = 1 WHERE category_id = ?");
        $query->bindParam(1, $id);
        $query->execute();
    }

    public function findWithProduct($product_id)
    {
        // On récupère toute les catégories associées à ce produit
        $query = $this->pdo->prepare("SELECT * FROM categories INNER JOIN product_category on categories.category_id = product_category.category_id INNER JOIN products on products.id = product_category.product_id WHERE products.id = :id");
        $query->execute(['id' => $product_id]);
        $categories_in_product = $query->fetchAll();

        return $categories_in_product;
    }
}