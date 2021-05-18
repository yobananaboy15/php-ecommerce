<?php

class Model
{

  private $db;

  public function __construct($database)
  {
    $this->db = $database;
  }

  /* public function fetchAllMovies(){
        $movies = $this->db->select("SELECT * FROM films");
        return $movies;
    } */

  public function fetchAllProducts()
  {
    $products = $this->db->select("SELECT * FROM products");
    return $products;
  }

  public function fetchCustomersProducts($idStr)
  {

    $products = $this->db->select("SELECT * from products WHERE id in ($idStr)");
    return $products;
  }

  public function registerUser($register)
  {

    // Förbered en SQL-sats and binda parametrar
    $this->db->insert(
      "INSERT INTO customers (name, phone, adress, email, password) VALUES (:name, :phone, :adress, :email, :password)",
      array(
        ':name' => $register['name'],
        ':phone' => $register['phone'],
        ':adress' => $register['adress'],
        ':email' => $register['email'],
        ':password' => $register['password'],
      )
    );
  }

  public function getUser($username, $password)
  {
    $user = $this->db->select("SELECT * from customers WHERE name = ? and password = ?", array($username, $password));
    return $user;
  }

  public function createOrder($totalCost, $userId)
  {
    return $this->db->insert(
      "INSERT INTO orders (total, customers_id) VALUES (:total, :customersid)",
      array(
        ':total' => $totalCost,
        ':customersid' => $userId
      )
    );
  }

  public function productsToOrder($queryString)
  {
    $this->db->insert("INSERT INTO orders_products (products_id, order_id) VALUES $queryString");
  }
}
