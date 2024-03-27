<!-- include the header -->
<?php 
    include "inc/header.php";
    include "lib/User.php";

    $user = new User();

    //check_login; if logged in redirect to homde page
    Session::check_login();

    
?>


<div class="bg-light p-4" style="min-height: 500px;">

<div style="max-width: 500px; margin: 0 auto;">

<?php

//login form validation
//if any user click on 'login' button
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])){
    //sends all form filed to the method of User class
    $user_login = $user->user_login($_POST);

    echo $user_login;
   
}


?>

    <h3>User Login</h3>
    <form action="" method="POST">

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="text" id="email" name="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" >
        </div>

        <div class="form-group">
           
            <input class="btn btn-success" type="submit" value="Login" name="login"/>
        </div>


    </form>
</div>

</div>

<!-- include the footer -->
<?php
    include "inc/footer.php";
?>