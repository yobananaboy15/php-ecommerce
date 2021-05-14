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
            case 'addproduct':
                $this->addProduct();
                break;
            case 'editproduct':
                $this->editProduct();
                break;
            case 'deleteproduct':
                $this->deleteProduct();
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
        $this->view->viewAdminHeader();
        $this->view->viewFrontPage();
    }

    private function products()
    {
        $this->view->viewAdminHeader();
        $products = $this->model->fetchAllProducts();
        $this->view->showProducts($products);
    }

    private function addProduct()
    {
    }

    private function editProduct()
    {
        if (isset($_GET['id'])) {
            $this->view->viewAdminHeader();
            $product = $this->model->fetchProduct($_GET['id']);
            $this->view->showEditProduct($product);
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->model->editProduct($_POST);
            header("Location: ?page=products");
        }
    }

    private function deleteProduct()
    {
        $this->model->deleteProduct($_GET['id']);
        header("Location: ?page=products");
    }


    private function orders()
    {
    }
}
