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
      case "checkout":
        $this->checkout();
        break;
      case 'removeitem':
        $this->removeItem();
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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $this->getHeader("Logga in");
      $this->view->ViewLoginPage();
      $this->getFooter();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $user = $this->model->getUser($_POST['username'], $_POST['password'])[0];
      // echo "<pre>";
      // var_dump($user);
      // echo "</pre>";

      if (count($user)) {
        $_SESSION['isAdmin'] = $user['isadmin'];
        $_SESSION['userid'] = $user['id'];
        header('Location: ?page');
      } else {
        $error = "Wrong username or password";
        header("Location: ?page=login&error=$error");
      }
    }
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
      header('Location: ?page=login');
    }
    $this->getFooter();
  }

  private function checkout()
  {

    //För varje produkt så multiplicerar vi värde av elementet med priset för motsvarande index.

    //GET-request -> Vi vill hämta priset 


    $this->view->viewHeader();

    //Om det finns något i kundvagnen, gör en sak, annars gör en annan.
    if (!empty($_SESSION['cart'])) {

      $totalCost = 0;

      $idStr = implode(",", array_keys($_SESSION['cart']));
      $products = $this->model->fetchCustomersProducts($idStr);
      //Det här sker oavsett
      $newArray = array();
      foreach ($products as $value) {
        $totalCost += $value['price'] * $_SESSION['cart'][$value['id']];
        $singleProductArray = array("id" => $value['id'], "title" => $value['title'], "quantity" => $_SESSION['cart'][$value['id']], "price" => $value['price'] * $_SESSION['cart'][$value['id']]);
        array_push($newArray, $singleProductArray);
      }

      if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $this->view->viewCheckoutPage($newArray, $totalCost);
      }

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_SESSION['userid'])) {
          $insertedOrderId = $this->model->createOrder($totalCost, $_SESSION['userid']);
          $queryString = '';
          foreach ($_SESSION['cart'] as  $key=>$value) {
            $queryString.="($key,$insertedOrderId,$value),";
          }
          $queryString = substr($queryString, 0, -1);
          $this->model->productsToOrder($queryString);

          echo '<h2>Your order has been placed successfully!!</h2>';
        } else {
          echo '<h2>Please log in to buy stuff!</h2>';
        }
      }
    } else {
      echo "<h2>Your cart is empty</h2><br>";
      echo "<i class='fas fa-cart-plus'></i>";
    }

    $this->view->viewFooter();

    //Skicka en array med det som ska skrivas ut
  }

  private function removeItem()
  {
    unset($_SESSION['cart'][$_GET['id']]);
    header('Location: ?page=checkout');
  }

  private function getHeader()
  {
    $this->view->viewHeader();
  }

  private function getFooter()
  {
    $this->view->viewFooter();
  }

  private function frontPage()
  {
    $user = isset($_SESSION['userid']) ? $this->model->getUserName($_SESSION['userid'])[0]['name'] : "";
    $newArray = array();

    if ($_SESSION['cart']) {
      $totalCost = 0;
      $idStr = implode(",", array_keys($_SESSION['cart']));
      $products = $this->model->fetchCustomersProducts($idStr);
      //Det här sker oavsett
      foreach ($products as $value) {
        $totalCost += $value['price'] * $_SESSION['cart'][$value['id']];
        $singleProductArray = array("title" => $value['title'], "quantity" => $_SESSION['cart'][$value['id']], "price" => $value['price'] * $_SESSION['cart'][$value['id']]);
        array_push($newArray, $singleProductArray);
      }
    }

    //Om det finns en GET-variabel som heter id -> Lägg till i ssession.
    if (isset($_GET['id'])) {
      $_SESSION['cart'][$_GET['id']] = array_key_exists($_GET['id'], $_SESSION['cart']) ? $_SESSION['cart'][$_GET['id']] + 1 : 1;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      session_destroy();
      header('Location: ?');
    }

    $this->getHeader("Välkommen");

    $products = $this->model->fetchAllProducts();

    $this->view->viewFrontPage($user, $newArray, $products);
    $this->getFooter();
  }
}
