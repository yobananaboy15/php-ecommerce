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

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $this->getHeader("Logga in");
      $this->view->ViewLoginPage();
      $this->getFooter();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $user = $this->model->getUser($_POST['username'], $_POST['password']);
      // echo "<pre>";
      // var_dump($user);
      // echo "</pre>";

      if (count($user)) {
        $_SESSION['userid'] = $user[0]['id'];
        header('Location: ?page');
      } else {
        $error = "Wrong username or password";
        header("Location: ?page=login&error=$error");
      }

      //Inled med att sätta $_SESSION["cart"] = [1 => 1,2,3 => 4] när man kommer in på sidan.

      //Kolla om det finns ett sådant användarnamn -> Om vi får tillbaka en rad innebär det att det finns en användare med det namnet.
      //Då Kollar vi om lösenorder i raden är samma som $_POST['password'];

      //Om vi inte får tillbaka en rad finns inte användaren.

      //Kolla om lösenordet som är kopplat till användaren överensstämmer med det som skickats in.
      //Skicka felmeddelande om inloggningsuppfiter inte stämmer.

      //Om det gör det -> Kolla om användaren är admin.
      //Om användaren är admin -> sätt $_SESSION["isAdmin"] = true -> Redirect till förstasidan.

      //Om användaren är user -> $_SESSION['userid'] = userid
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
