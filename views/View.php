<?php

class View
{

  public function viewHeader($title)
  {
    include_once("views/include/header.php");
  }

  public function viewFooter()
  {
    include_once("views/include/footer.php");
  }

  public function viewAboutPage()
  {
    include_once("views/include/about.php");
  }

  public function viewFrontPage($products)
  {
    include_once("views/include/frontPage.php");


    $card = " <div class='row'>";
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
        <div class='card-footer'><button class='btn btn-primary'>BUY!!</button></div>
      </div>
    </div>";
    }
    $card .= "
      </div>
      </div>
      </div>
      </div>";
    echo $card;
  }


  public function viewLoginPage()
  {
    include_once("views/include/login.php");
  }

  public function viewRegisterPage()
  {
    include_once("views/include/register.php");    
        // Hämta data från post-arrayen
        
  }
}
