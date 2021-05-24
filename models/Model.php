<?php

class Model
{

  private $db;

  public function __construct($database)
  {
    $this->db = $database;
  }

  /**
   * Hämtar alla produkter
   */
  public function fetchAllProducts()
  {
    $products = $this->db->select("SELECT * FROM products");
    return $products;
  }

  /**
   * Hämtar alla produkter i kundkorg
   */
  public function fetchCustomersProducts($idStr)
  {
    $products = $this->db->select("SELECT * from products WHERE id in ($idStr)");
    return $products;
  }

  /**
   * Lägger till ny användare
   */
  public function registerUser($register)
  {
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

  /**
   * Hämtar användarnamn och lösenord
   */
  public function getUser($username, $password)
  {
    $user = $this->db->select("SELECT * from customers WHERE name = ? and password = ?", array($username, $password));
    return $user;
  }

  /**
   * Skapar order
   */
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

  /**
   * Skapar uppslagstabell för ordernr och produktnr
   */
  public function productsToOrder($queryString)
  {
    $this->db->insert("INSERT INTO orders_products (products_id, order_id,quantity) VALUES $queryString");
  }

  /**
   * Hämtar användarnamn
   */
  public function getUserName($userid)
  {
    return $this->db->select("SELECT name from customers WHERE id = $userid");
  }
}
