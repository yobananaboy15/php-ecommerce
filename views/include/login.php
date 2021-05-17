<div class="container">
    <div class="row">
        <h2 class="col-md-12">Sign in</h2>

        <form action="?page=login" method="POST" class="d-flex flex-column">
            <input type="text" placeholder="Username" name="username">
            <!-- Throw error here for invalid username -->

            <input type="password" placeholder="Password" name="password">
            <!-- Throw error here for invalid password -->

            <button id="submit" type="submit" value="submit">Submit</button>

            <?php
            if (isset($_GET['error'])) {
                echo $_GET['error'];
            }
            ?>

            <p class="options">Not registered yet? <a href="#">Create an account!</a></p>
        </form>
    </div>
</div>