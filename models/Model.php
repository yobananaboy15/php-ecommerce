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

  public function registerUser($register){

        // Förbered en SQL-sats and binda parametrar
        $this->db->insert("INSERT INTO customers (name, phone, adress, email, password) VALUES (:name, :phone, :adress, :email, :password)", 
        array(
          ':name' => $register['name'], 
          ':phone' => $register['phone'],
          ':adress' => $register['adress'],
          ':email' => $register['email'],
          ':password' => $register['password'],
        ));
        
  }
}
