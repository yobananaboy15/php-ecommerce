<?php

class View
{

  public function viewHeader()
  {
    include_once("views/include/header.php");
  }

  public function viewFooter()
  {
    include_once("views/include/footer.php");
  }

  /**
   * Front page
   */
  public function viewFrontPage($user, $newArray, $products)
  {
    
    ////Visar sidebar med inloggad användare och kundkorg
    
    include_once("views/include/sidebar.php");
    $userMsg = $user !== "" ? "Logged in as $user" : "Not logged in";
    $html = <<<EOT
            <h3 class="my-4">$userMsg</h3>
            <div class="list-group">
            <h4>Cart:</h4>
        EOT;

    foreach ($newArray as $product) {
      $html .= <<<EOT
      <p class="list-group-item">$product[title]<span class="float-right">$product[price]</span></p>
      EOT;
    }
    $html .= "</div></div>";
    echo $html;


    include_once("views/include/frontPage.php");

    
    ////Visar alla produkter
    
    $card = "<div class='row'>";
    foreach ($products as $product) {
      $card .= "
      <div class='col-lg-4 col-md-6 mb-4'>
      <div class='card h-100'>
        <a href='#!'><img class='p-3 img-fluid' src='$product[image]' alt='...' / style='height : 300px'></a>
        <div class='card-body'>
          <h4 class='card-title'><a href='#!'>$product[title]</a></h4>
          <h5>$product[price]</h5>
          <p class='card-text'>$product[description]</p>
        </div>
        <div class='card-footer'>
          <a class='btn btn-primary' href='?page&id=$product[id]'>BUY!!</a>
        </div>
      </div>
    </div>";
    }
    $card .= "
      </div>
      </div>
      </div>
      </div>";
    echo $card;
    //var_dump($_SESSION);
  }

  /**
   * Checkout
   */
  public function viewCheckoutPage($products, $totalCost)
  {
    $html = <<<EOT
    <h1>Cart</h1>
    <table class='table'>
        <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody> 
    EOT;

    foreach ($products as $product) {
      $html .= <<<EOT
      <tr>
          <td>$product[title] <a class='btn btn-danger' href='?page=removeitem&id=$product[id]'>X</a></td>
          <td>$product[quantity]</td>
          <td>$product[price]</td>
      </tr>
      EOT;
    }
    $html .= "<tr><th>Total</th><th></th><th>$totalCost</th></tr>";
    $html .= "</tbody></table>";
    $html .= "<a class='btn btn-primary' href='?page'>Go back</a>";
    $html .= "<form action='?page=checkout' method='POST'><button type='submit'>Send order</button></form>";

    echo $html;
  }

  /**
   * Login
   */
  public function viewLoginPage()
  {
    include_once("views/include/login.php");
  }

  /**
   * Register
   */
  public function viewRegisterPage()
  {
    include_once("views/include/register.php");
  }
}
