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
        $this->getHeader("Logga in");
        $this->view->ViewLoginPage();
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
        $this->view->viewFrontPage();
        $this->getFooter();
    }
}
