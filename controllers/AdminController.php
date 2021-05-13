<?php

class AdminController
{

    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
        $this->router();
    }

    private function router()
    {
        $page = $_GET['page'] ?? "";

        switch ($page) {
            case "products":
                $this->products();
                break;
            case "orders":
                $this->orders();
                break;
            default:
                $this->admin();
        }
    }

    private function admin()
    {
        $this->view->viewAdminPage();
    }

    private function products()
    {
    }

    private function orders()
    {
    }
}
