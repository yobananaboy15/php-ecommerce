<?php

require_once ("models/Database.php");
require_once ("models/Model.php");
require_once ("views/View.php");
require_once ("controllers/Controller.php");

/********************
 * OBS!! Ändra databas
 ********************/
$database   = new Database("moviedb", "root" , "root"); 
$model      = new Model($database);
$view       = new View();
$controller = new Controller($model, $view);

$controller->main();