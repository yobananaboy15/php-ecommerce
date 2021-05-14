<?php

class Controller
{

  private $model;
  private $view;

  public function __construct($model, $view)
  {
    $this->model = $model;
    $this->view = $view;
  }

  public function main()
  {
    $this->router();
  }

  private function router()
  {
    $page = $_GET['page'] ?? "";

    switch ($page) {
      case "about":
        $this->about();
        break;
      case "login":
        $this->login();
        break;
      case "register":
        $this->register();
        break;
      default:
        $this->frontPage();
    }
  }

  private function about()
  {
    $this->getHeader("Om Oss");
    $this->view->viewAboutPage();
    $this->getFooter();
  }
  private function login()
  {
    $this->getHeader("Logga in");
    $this->view->ViewLoginPage();
    $this->getFooter();
  }

  private function register()
  {
    $this->getHeader("Register");
    $this->view->ViewRegisterPage();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $register = array(
        "name" => htmlspecialchars($_POST['name']),
        "adress" => htmlspecialchars($_POST['adress']),
        "phone" => htmlspecialchars($_POST['phone']),
        "email" => htmlspecialchars($_POST['email']),
        "password" => htmlspecialchars($_POST['password'])
      );
      $this->model->registerUser($register);
    }
    $this->getFooter();
  }

  private function getHeader($title)
  {
    $this->view->viewHeader($title);
  }

  private function getFooter()
  {
    $this->view->viewFooter();
  }

  private function frontPage()
  {
    $this->getHeader("Välkommen");

    $products = $this->model->fetchAllProducts();

    $this->view->viewFrontPage($products);
    $this->getFooter();
  }
}
