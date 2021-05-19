<?php

class AdminView
{
    public function viewAdminHeader()
    {
        include_once("views/include/admin/adminHeader.php");
    }

    public function viewFrontPage()
    {
        echo "<h1> This is the admin page. View and edit orders and products by clicking on the links in the navbar. </h1>";
    }


    public function showOneProduct($product)
    {
        $html = <<<EOT
        <tr>
            <td>$product[title]</td>
            <td>$product[description]</td>
            <td>$product[category]</td>
            <td>$product[price]</td>
            <td>$product[image]</td>
            <td>
                <a href="?page=editproduct&id=$product[id]" class='btn btn-primary'>Edit</a>
                <a href="?page=deleteproduct&id=$product[id]" class='btn btn-danger'>Delete</a>
            <td>
        </tr>
        EOT;
        return $html;
    }

    public function showProducts($products)
    {
        $html = <<<EOT
        <table class='table'>
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Image</th>
                    <th scope="col"><a href="?page=addproduct" class="btn btn-success">Add</a></th>                    
                </tr>
            </thead>
            <tbody> 
        EOT;
        foreach ($products as $product) {
            $html .= $this->showOneProduct($product);
        }

        $html .= "</tbody></table>";

        echo $html;
    }

    public function showEditProduct($product)
    {
        $html = <<<EOT
        <form action="?page=editproduct" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                <input type="text" class="form-control" name="title" value="$product[title]">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <input type="text" class="form-control" name="description" value="$product[description]">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Category</label>
                <input type="text" class="form-control" name="category" value="$product[category]">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Price</label>
                <input type="text" class="form-control" name="price" value="$product[price]">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Image</label>
                <input type="text" class="form-control" name="image" value="$product[image]">
            </div>
            <input type="hidden" name="id" value="$product[id]">
            <button type="submit" class="btn btn-primary">Submit changes</button>
        </form>
        EOT;
        echo $html;
    }

    public function addProduct()
    {
        $html = <<<EOT
        <form action="?page=addproduct" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <input type="text" class="form-control" name="description">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Category</label>
                <input type="text" class="form-control" name="category">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Price</label>
                <input type="text" class="form-control" name="price">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Image</label>
                <input type="text" class="form-control" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Add product</button>
        </form>
        EOT;
        echo $html;
    }

    public function showActiveOrders($orders)
    {
        $html = <<<EOT
        <h1>Active Orders</h1>
        <table class='table'>
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Total cost</th>
                    <th scope="col">Action</th>                    
                </tr>
            </thead>
            <tbody> 
        EOT;
        foreach ($orders as $order) {
            $html .= <<<EOT
            <tr>
                <td><a href="?page=orderdetails&id=$order[id]">$order[id]</a></td>
                <td>$order[created_at]</td>
                <td>$order[name]</td>
                <td>$order[total]</td>
                <td>
                    <form action='?page=orders' method='POST'>
                        <input type='hidden' name="id" value="$order[id]" />
                        <button type="submit" class="btn btn-primary">Send order</button>
                    </form>
                </td>
            </tr>
            EOT;
        }

        $html .= "</tbody></table>";
        echo $html;
    }

    public function showSentOrders($orders)
    {
        $html = <<<EOT
        <h1>Sent orders</h1>
        <table class='table'>
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Total cost</th>
                    <th scope="col">Status</th>                    
                </tr>
            </thead>
            <tbody> 
        EOT;
        foreach ($orders as $order) {
            $html .= <<<EOT
            <tr>
                <td><a href="?page=orderdetails&id=$order[id]">$order[id]</a></td>
                <td>$order[created_at]</td>
                <td>$order[name]</td>
                <td>$order[total]</td>
                <td>Sent</td>
            </tr>
            EOT;
        }

        $html .= "</tbody></table>";
        echo $html;
    }

    public function viewOrderDetails($orderDetails)
    {
        $orderId = $orderDetails[0]['id'];
        $total = $orderDetails[0]['total'];

        $html = <<<EOT
        <h3>OrderID: $orderId</h3>
        <table class='table'>
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Quantity</th>                    
                </tr>
            </thead>
            <tbody> 
        EOT;
        foreach ($orderDetails as $order) {
            $html .= <<<EOT
            <tr>
                <td>$order[title]</td>
                <td>$order[quantity]</td>
            </tr>
            EOT;
        }
        $html .= "<th>Total</th><th>$total</th>";
        $html .= "</tbody></table>";
        $html .= $orderDetails[0]['sent'] ? "" : "<form action='?page=orders' method='POST'>
                        <input type='hidden' name='id' value=$orderId />
                        <button type='submit' class='btn btn-primary'>Send order</button>
                    </form>";
        echo $html;
    }
}
