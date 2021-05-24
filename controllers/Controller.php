<?php

/**
 * Klass för att hantera all logik för hemsidan. 
 */

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

  /**
   * Här hanterar vi våra routes för hemsidan.
   */

  private function router()
  {
    $page = $_GET['page'] ?? "";

    switch ($page) {
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

  /** 
   *  Funktion för att rendera login-sidan och kontrollera om användaren finns i databasen, samt om användaren är admin eller inte.
   */
  private function login()
  {

    //Visar login-sidan
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $this->getHeader("Logga in");
      $this->view->ViewLoginPage();
      $this->getFooter();
    }

    //Hanterar login
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $user = $this->model->getUser($_POST['username'], $_POST['password'])[0];

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

  /** 
   * Funktion för att rendera registreringssidan och skapa användare i databasen.
   */
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

  /** 
   * Funktion för att hantera ordrar och skicka ordrar till databasen.
   */
  private function checkout()
  {
    $this->view->viewHeader();

    if (!empty($_SESSION['cart'])) {

      $totalCost = 0;

      //Hämtar produkterna i kundvagnen från databasen 
      $idStr = implode(",", array_keys($_SESSION['cart'])); 
      $products = $this->model->fetchCustomersProducts($idStr);
      
      //Lagrar produkternas titel, antal och totalpris i $cart
      $cart = array();
      foreach ($products as $value) {
        $totalCost += $value['price'] * $_SESSION['cart'][$value['id']];
        $singleProductArray = array("id" => $value['id'], "title" => $value['title'], "quantity" => $_SESSION['cart'][$value['id']], "price" => $value['price'] * $_SESSION['cart'][$value['id']]);
        array_push($cart, $singleProductArray);
      }

      //Visar kundvagnen för kunden
      if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $this->view->viewCheckoutPage($cart, $totalCost);
      }

      //Hanterar ordern
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Om användaren är inloggad lagras ordern i databasen
        if (isset($_SESSION['userid'])) {
          $insertedOrderId = $this->model->createOrder($totalCost, $_SESSION['userid']);
          $queryString = '';
          foreach ($_SESSION['cart'] as  $key => $value) {
            $queryString .= "($key,$insertedOrderId,$value),";
          }
          $queryString = substr($queryString, 0, -1);
          $this->model->productsToOrder($queryString);

          echo '<h2>Your order has been placed successfully!!</h2>';
          $_SESSION['cart'] = array();
        } else {
          echo '<h2>Please log in to buy stuff!</h2>';
        }
      }
    } else {
      echo "<h2>Your cart is empty</h2><br>";
      echo "<i class='fas fa-cart-plus'></i>";
    }

    $this->view->viewFooter();
  }

  /**
   * Funktion för att ta bort produkt ur kundvagn.
   */
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

  /** 
   * Funktion för att rendera frontpage
   */
  private function frontPage()
  {
    //Hämtar användarnamn
    $user = isset($_SESSION['userid']) ? $this->model->getUserName($_SESSION['userid'])[0]['name'] : "";
    
    //Lagrar produkt-id i sessionvariabel
    if (isset($_GET['id'])) {
      $_SESSION['cart'][$_GET['id']] = array_key_exists($_GET['id'], $_SESSION['cart']) ? $_SESSION['cart'][$_GET['id']] + 1 : 1;
    }

    // Här hämtar vi alla produkter i kundkorgen från databasen
    $cart = array();
    if ($_SESSION['cart']) {
      $totalCost = 0;
      $idStr = implode(",", array_keys($_SESSION['cart']));
      $products = $this->model->fetchCustomersProducts($idStr);

      foreach ($products as $value) {
        $totalCost += $value['price'] * $_SESSION['cart'][$value['id']];
        $singleProductArray = array("title" => $value['title'], "price" => $value['price'] * $_SESSION['cart'][$value['id']]);
        array_push($cart, $singleProductArray);
      }
    }
    // Här loggar man ut
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      session_destroy();
      header('Location: ?');
    }

    $this->getHeader("Välkommen");

    $products = $this->model->fetchAllProducts();

    $this->view->viewFrontPage($user, $cart, $products);
    $this->getFooter();
  }
}
