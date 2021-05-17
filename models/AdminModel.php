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

    public function addProduct($parameters)
    {
        $this->db->update("INSERT INTO products (title, description, category, price, image) VALUES (?, ?, ?, ?, ?)", array($parameters['title'], $parameters['description'], $parameters['category'], $parameters['price'], $parameters['image']));
    }

    public function editProduct($parameters)
    {
        $this->db->update("UPDATE products SET title = ?, description = ?, category = ?, price = ?, image = ? WHERE id = ?", array($parameters['title'], $parameters['description'], $parameters['category'], $parameters['price'], $parameters['image'], $parameters['id']));
    }

    public function deleteProduct($id)
    {
        $this->db->delete("DELETE from products WHERE id = ?", array($id));
    }

    public function fetchActiveOrders()
    {
        $orders = $this->db->select("SELECT o.id, o.total, o.created_at, c.name FROM orders AS o JOIN customers as c ON o.customers_id = c.id WHERE o.sent = false");
        return $orders;
    }

    public function fetchSentOrders()
    {
        $orders = $this->db->select("SELECT o.id, o.total, o.created_at, c.name FROM orders AS o JOIN customers as c ON o.customers_id = c.id WHERE o.sent = true");
        return $orders;
    }

    public function changeOrderStatus($id)
    {
        $this->db->update("UPDATE orders SET sent = true WHERE id = ?", array($id));
    }
}
