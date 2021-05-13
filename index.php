<?php

require_once("models/Database.php");
require_once("models/Model.php");
require_once("views/View.php");
require_once("controllers/Controller.php");
require_once("views/AdminView.php");
require_once('controllers/AdminController.php');
require_once('models/AdminModel.php');

/********************
 * OBS!! Ändra databas
 ********************/

session_start();

//Om användaren är inloggad som admin kör nedanstående.

$_SESSION["isAdmin"] = true;

if (isset($_SESSION['isAdmin'])) {
    $database   = new Database("fakestore", "root", "root");
    $adminModel = new AdminModel($database);
    $view = new adminView();
    $contoller = new AdminController($adminModel, $view);
} else {
    $database   = new Database("fakestore", "root", "root");

    $model      = new Model($database);
    $view       = new View();
    $controller = new Controller($model, $view);

    $controller->main(); //Kör den här i konstruktorn
}
