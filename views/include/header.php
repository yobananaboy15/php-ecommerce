<?php
$logBtn = isset($_SESSION['userid']) ? 
  "<form action='?' method='POST'>
    <input class='nav-link bg-transparent' type='submit' value='Logout'></input>
  </form>" 
  : 
  "<a class='nav-link' href='?page=login'>Login</a>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Shop Homepage - Start Bootstrap Template</title>
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="styles/styles.css" rel="stylesheet" />
  <link href="styles/styles2.css" rel="stylesheet" />
</head>

<body>

  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="?">The best Fakestore!</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="?">
              Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item"><a class="nav-link" href="?page=checkout">Checkout</a></li>
          <li class="nav-item">
            <?php echo $logBtn ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>