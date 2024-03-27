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

    //registration form validation
    //if any user click on 'register' button
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])){
        //sends all form filed to the method of User class
        $user_registration = $user->user_registration($_POST);

        echo $user_registration;
       
    }

    
    ?>

    <h3>User Registration</h3>
    <form action="" method="POST">

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" >
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="text" id="email" name="email" class="form-control" >
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" >
        </div>

        <div class="form-group">
           
            <input class="btn btn-success" type="submit" name="register" value="Register"/>
        </div>


    </form>
</div>


</div>

<!-- include the footer -->
<?php include "inc/footer.php"?>