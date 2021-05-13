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
}
