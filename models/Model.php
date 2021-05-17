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
}
