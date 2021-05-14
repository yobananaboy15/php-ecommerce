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
    //Fler klasser för att se orders.

}
