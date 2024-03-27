<!-- include the header -->
<?php

    include "lib/User.php";

    include "inc/header.php";

    $user = new User();

     //check_session; if not looged in redirect to login page
     Session::check_session();
    
     
?>

<div class="bg-light p-4" style="min-height: 500px;">

<div style="max-width: 500px; margin: 0 auto;">

    <h3>Update Password</h3>

    <?php 
        //user update mechanism
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])){
            $user_id = Session::get('id');
            $update_password = $user->update_password_by_id($user_id, $_POST);

            echo $update_password;
        }


    ?>
    <form action="" method="POST">

    <?php 
        //check and validate the query variable 'id'
        if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $id = (int)$id;
        }
    ?>

        <div class="form-group">
            <label for="old_password">Old Password</label>
            <input type="password" id="old_password" name="old_password" class="form-control">
        </div>

        <div class="form-group">
            <label for="username">New Password</label>
            <input type="password" id="new_password" name="new_password" class="form-control">
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Passowrd</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control">
        </div>

       
       
        <div class="form-group">
           
            <button class="btn btn-success" type="submit" name="update">Update Password</button>
            

        </div>
       

    


    </form>
</div>


</div>

<!-- include the footer -->
<?php include "inc/footer.php"?>