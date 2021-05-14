<?php

class AdminModel
{

    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function fetchAllProducts()
    {
        $products = $this->db->select("SELECT * FROM products");
        return $products;
    }

    public function fetchProduct($id)
    {
        $product = $this->db->select("SELECT * FROM products WHERE id = ?", array($id));
        return $product[0];
    }

    public function editProduct($parameters)
    {
        $this->db->update("UPDATE products SET title = ?, description = ?, category = ?, price = ?, image = ? WHERE id = ?", array($parameters['title'], $parameters['description'], $parameters['category'], $parameters['price'], $parameters['image'], $parameters['id']));
    }

    public function deleteProduct($id)
    {
        $this->db->delete("DELETE from products WHERE id = ?", array($id));
    }
}
