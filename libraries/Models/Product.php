<?php
namespace Models;

class Product extends Model
{
    private $productParPage = 9;

    public function getProductparPage()
    {
        return $this->productParPage;
    }

    public function findTop()
    {
        $sql = "SELECT * FROM products inner join product_category on products.id = product_category.product_id inner join categories
        on product_category.category_id = categories.category_id WHERE categories.title = 'top'";

        $result = $this->pdo->query($sql);
        $top_products = $result->fetchAll();

        return $top_products;
    }

    public function findAll($startPage)
    {   
        $sql = "SELECT products.id, products.marque, products.modele FROM products";
        $sql .= " LIMIT $startPage,$this->productParPage";

        $result = $this->pdo->query($sql);
        $products = $result->fetchAll();

        return $products;
    }

    public function find($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");

        // On exécute la requête en précisant le paramètre :id
        $query->execute(['id' => $id]);

        // On fouille le résultat pour en extraire les données réelles
        $product = $query->fetch();

        return $product;
    }

    public function findByMarque($marque, $startPage)
    {  
        $sql = "SELECT products.id, products.marque, products.modele FROM products";
        $sql .= " WHERE marque = ? LIMIT $startPage,$this->productParPage";

        $result = $this->pdo->prepare($sql);
        $result->execute([$marque]);
        $products = $result->fetchAll();

        return $products;
    }

    public function findByCategory($sort, $startPage)
    {
        $sql = "SELECT products.id, products.marque, products.modele FROM products inner join product_category on products.id = product_category.product_id inner join categories
    on product_category.category_id = categories.category_id WHERE categories.title = ?";

        $sql .= " LIMIT $startPage,$this->productParPage";

        $result = $this->pdo->prepare($sql);
        $result->execute([$sort]);
        $products = $result->fetchAll();

        return $products;
    }

    public function paginationAll()
    {
        $sql = "SELECT products.id, products.marque, products.modele FROM products";
        $totalProducts = $this->pdo->query($sql);
        $productsTotals = $totalProducts->rowCount();
        $pagesTotales = ceil($productsTotals / $this->productParPage) + 1;

        return $pagesTotales;
    }

    public function paginationByMarque($marque)
    {
        $totalProducts = $this->pdo->prepare('SELECT id from products WHERE marque = ?');
        $totalProducts->execute([$marque]);
        $productsTotals = $totalProducts->rowCount();
        $pagesTotales = ceil($productsTotals / $this->productParPage) + 1;

        return $pagesTotales;
    }

    public function paginationByCategory($sort)
    {
        $totalProducts = $this->pdo->prepare("SELECT * FROM products inner join product_category on products.id = product_category.product_id inner join categories
        on product_category.category_id = categories.category_id  WHERE categories.title = ?");
        $totalProducts->execute([$sort]);

        $productsTotals = $totalProducts->rowCount();
        $pagesTotales = ceil($productsTotals / $this->productParPage) + 1;

        return $pagesTotales;
    }

    public function findAllForAdmin()
    {
        $sql = "SELECT products.id, marque, modele, description,  categories.category_id, GROUP_CONCAT(categories.title separator ',') as category_name FROM products LEFT OUTER JOIN product_category on products.id = product_category.product_id LEFT OUTER JOIN categories
        on product_category.category_id = categories.category_id GROUP BY products.id";

        $result = $this->pdo->query($sql);
        $products = $result->fetchAll();

        return $products;
    }

    public function findWithCategories($product_id)
    {
        // On récupère le produit ainsi que ses catégories
        $query = $this->pdo->prepare("SELECT products.id, marque, modele, description,  GROUP_CONCAT(categories.category_id separator ',') as category_id, GROUP_CONCAT(categories.title separator ',') as category_name FROM products LEFT OUTER JOIN product_category on products.id = product_category.product_id LEFT OUTER JOIN categories
        on product_category.category_id = categories.category_id WHERE id = :id");

        $query->execute(['id' => $product_id]);
        $product = $query->fetch();

        return $product;
    }

    public function delete($id)
    {
        $query1 = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $query1->execute(['id' => $id]);

        $query2 = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = {$id}");
        $query2->execute();
        $junction = $query2->fetchAll();

        if (!empty($junction)) {
            $query3 = $this->pdo->prepare("DELETE FROM product_category WHERE product_id = {$id}");
            $query3->execute();
        }
    }

    public function update($marque, $modele, $description, $product_id)
    {
        // On edit les données dans la bdd
        $query = $this->pdo->prepare("UPDATE products SET marque = ?, modele = ?, description = ? WHERE id = ?");
        $query->bindParam(1, $marque);
        $query->bindParam(2, $modele);
        $query->bindParam(3, $description);
        $query->bindParam(4, $product_id);
        $query->execute();
    }

    public function insert($marque, $modele, $description)
    {
        $query = $this->pdo->prepare("INSERT INTO products SET marque = ?, modele = ?, description = ?");
        $query->bindParam(1, $marque);
        $query->bindParam(2, $modele);
        $query->bindParam(3, $description);
        $query->execute();

        $product_id = $this->pdo->lastInsertId();

        return $product_id;
    }

}