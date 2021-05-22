<?php

/**
 * Klass för att hantera adminsidan, vi hanterar produkter och ordrar. 
 */

class AdminController
{

  private $model;
  private $view;

  public function __construct($model, $view)
  {
    $this->model = $model;
    $this->view = $view;
    $this->router();
  }
  /**
   * Här hanterar vi våra routes för adminsidan.
   */
  private function router()
  {
    $page = $_GET['page'] ?? "";

    switch ($page) {
      case "products":
        $this->products();
        break;
      case 'addproduct':
        $this->addProduct();
        break;
      case 'editproduct':
        $this->editProduct();
        break;
      case 'deleteproduct':
        $this->deleteProduct();
        break;
      case "orders":
        $this->orders();
        break;
      case "orderdetails":
        $this->orderDetails();
        break;
      default:
        $this->admin();
    }
  }
  /**
   * Funktion för att rendera frontPage.
   */
  private function admin()
  {
    $this->view->viewAdminHeader();
    $this->view->viewFrontPage();

    //Funktion för att logga ut.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      session_destroy();
      header('Location: ?');
    }
  }
  /**
   * Den här sidan listar alla produkter
   */
  private function products()
  {
    $this->view->viewAdminHeader();
    $products = $this->model->fetchAllProducts();
    $this->view->showProducts($products);
  }
  /**
   * Funktion för att lägga till en ny produkt. 
   */
  private function addProduct()
  {
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
      $this->view->viewAdminHeader();
      $this->view->addProduct();
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->model->addProduct($_POST);
      header("Location: ?page=products");
    }
  }
  /**
   * Funktion för att uppdatera en produkt. 
   */
  private function editProduct()
  {
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
      $this->view->viewAdminHeader();
      $product = $this->model->fetchProduct($_GET['id']);
      $this->view->showEditProduct($product);
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->model->editProduct($_POST);
      header("Location: ?page=products");
    }
  }
  /**
   * Funktion för att ta bort en produkt. 
   */
  private function deleteProduct()
  {
    $this->model->deleteProduct($_GET['id']);
    header("Location: ?page=products");
  }

  /**
   * Funktion för att rendera ordersidan, och lista ordrar.
   */
  private function orders()
  {
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
      $this->view->viewAdminHeader();
      $activeOrders = $this->model->fetchActiveOrders();
      $this->view->showActiveOrders($activeOrders);
      $sentOrders = $this->model->fetchSentOrders();
      $this->view->showSentOrders($sentOrders);
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->model->changeOrderStatus($_POST['id']);
      header("Location: ?page=orders");
    }
  }
  /**
   * Funktion för att visa detaljer om en order. 
   */
  private function orderDetails()
  {
    $this->view->viewAdminHeader();
    $orderDetails = $this->model->fetchOrderDetails($_GET['id']);
    $this->view->viewOrderDetails($orderDetails);
  }
}
