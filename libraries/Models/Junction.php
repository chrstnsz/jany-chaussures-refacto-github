<?php

namespace Models;

class Junction extends Model {

    public function insert($product_id, $value)
    {
        $query = $this->pdo->prepare("INSERT INTO product_category (product_id, category_id) VALUES (:product_id, :category_id)");
        $query->bindParam(':product_id', $product_id);
        $query->bindParam(':category_id', $value);
        $query->execute();
    }

    public function update($product_id, $cat_hiver, $cat_automne, $cat_printemps, $cat_ete, $cat_top)
    {
        if ($cat_hiver == '0') {
            $query = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = ? AND category_id = ?");
            $query->bindParam(1, $product_id);
            $query->bindParam(2, $cat_hiver);
            $query->execute();
            $result = $query->fetch();
            if (empty($result)) {
                $query = $this->pdo->prepare("DELETE FROM product_category WHERE product_id = {$product_id} AND category_id = '2'");
                $query->execute();
            }
        }
        if ($cat_hiver == '2') {
            $query = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = ? AND category_id = ?");
            $query->bindParam(1, $product_id);
            $query->bindParam(2, $cat_hiver);
            $query->execute();
            $result = $query->fetch();
            if (empty($result)) {
                $query = $this->pdo->prepare("INSERT INTO product_category (product_id, category_id) VALUES (:product_id, :category_id)");
                $query->bindParam(':product_id', $product_id);
                $query->bindParam(':category_id', $cat_hiver);
                $query->execute();
            }
        }
        if ($cat_automne == '0') {
            $query = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = ? AND category_id = ?");
            $query->bindParam(1, $product_id);
            $query->bindParam(2, $cat_automne);
            $query->execute();
            $result = $query->fetch();
            if (empty($result)) {
                $query = $this->pdo->prepare("DELETE FROM product_category WHERE product_id = {$product_id} AND category_id = '1'");
                $query->execute();
            }
        }
        if ($cat_automne == '1') {
            $query = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = ? AND category_id = ?");
            $query->bindParam(1, $product_id);
            $query->bindParam(2, $cat_automne);
            $query->execute();
            $result = $query->fetch();
            if (empty($result)) {
                $query = $this->pdo->prepare("INSERT INTO product_category (product_id, category_id) VALUES (:product_id, :category_id)");
                $query->bindParam(':product_id', $product_id);
                $query->bindParam(':category_id', $cat_automne);
                $query->execute();
            }
        }

        if ($cat_printemps == '0') {
            $query = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = ? AND category_id = ?");
            $query->bindParam(1, $product_id);
            $query->bindParam(2, $cat_printemps);
            $query->execute();
            $result = $query->fetch();
            if (empty($result)) {
                $query = $this->pdo->prepare("DELETE FROM product_category WHERE product_id = {$product_id} AND category_id ='3'");
                $query->execute();
            }
        }
        if ($cat_printemps == '3') {
            $query = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = ? AND category_id = ?");
            $query->bindParam(1, $product_id);
            $query->bindParam(2, $cat_printemps);
            $query->execute();
            $result = $query->fetch();
            if (empty($result)) {
                $query = $this->pdo->prepare("INSERT INTO product_category (product_id, category_id) VALUES (:product_id, :category_id)");
                $query->bindParam(':product_id', $product_id);
                $query->bindParam(':category_id', $cat_printemps);
                $query->execute();
            }
        }

        if ($cat_ete == '0') {
            $query = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = ? AND category_id = ?");
            $query->bindParam(1, $product_id);
            $query->bindParam(2, $cat_ete);
            $query->execute();
            $result = $query->fetch();
            if (empty($result)) {
                $query = $this->pdo->prepare("DELETE FROM product_category WHERE product_id = {$product_id} AND category_id = '4'");
                $query->execute();
            }
        }
        if ($cat_ete == '4') {
            $query = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = ? AND category_id = ?");
            $query->bindParam(1, $product_id);
            $query->bindParam(2, $cat_ete);
            $query->execute();
            $result = $query->fetch();
            if (empty($result)) {
                $query = $this->pdo->prepare("INSERT INTO product_category (product_id, category_id) VALUES (:product_id, :category_id)");
                $query->bindParam(':product_id', $product_id);
                $query->bindParam(':category_id', $cat_ete);
                $query->execute();
            }
        }

        if ($cat_top == '0') {
            $query = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = ? AND category_id = ?");
            $query->bindParam(1, $product_id);
            $query->bindParam(2, $cat_top);
            $query->execute();
            $result = $query->fetch();
            if (empty($result)) {
                $query = $this->pdo->prepare("DELETE FROM product_category WHERE product_id = {$product_id} AND category_id = '7'");
                $query->execute();
            }
        }
        if ($cat_top == '7') {
            $query = $this->pdo->prepare("SELECT * FROM product_category WHERE product_id = ? AND category_id = ?");
            $query->bindParam(1, $product_id);
            $query->bindParam(2, $cat_top);
            $query->execute();
            $result = $query->fetch();
            if (empty($result)) {
                $query = $this->pdo->prepare("INSERT INTO product_category (product_id, category_id) VALUES (:product_id, :category_id)");
                $query->bindParam(':product_id', $product_id);
                $query->bindParam(':category_id', $cat_top);
                $query->execute();
            }
        }
    }
}