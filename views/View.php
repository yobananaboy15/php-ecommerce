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
    echo "<pre>";
    //print_r($products);

    $card = "";
    foreach ($products as $product) {
      $card .= "
    
    <div class='col-lg-4 col-md-6 mb-4'>
      <div class='card h-100'>
        <a href='#!'><img class='card-img-top' src='https://via.placeholder.com/700x400' alt='...' /></a>
        <div class='card-body'>
            <h4 class='card-title'><a href='#!'>$product[title]</a></h4>
            <h5>$24.99</h5>
            <p class='card-text'>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
        </div>
        <div class='card-footer'><small class='text-muted'>★ ★ ★ ★ ☆</small></div>
        </div>
    </div>
    </div> ";
    }
    echo $card;
    echo "
          </div>
          </div>
          </div>";
  }
  public function viewLoginPage()
  {
    include_once("views/include/login.php");
  }
}
