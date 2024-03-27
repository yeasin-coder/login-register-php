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

    <h3>User Profile</h3>

    <?php 
        //user update mechanism
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])){
            $user_id = Session::get('id');
            $old_username = Session::get('Username');
            $old_email = Session::get('Email');
            $update_user = $user->update_user_by_id($user_id, $old_username, $old_email, $_POST);

            echo $update_user;
        }


    ?>
    <form action="" method="POST">

    <?php 
        //check and validate the query variable 'id'
        if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $id = (int)$id;
        }

        //get single user data
        $value = $user->get_single_user_data($id);
        if($value){
            
        
    ?>

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" required="" value="<?php echo $value['name']?>">
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" required="" value="<?php echo $value['username']?>">
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="text" id="email" name="email" class="form-control" required="" value="<?php echo $value['email']?>">
        </div>

       
        <?php 
            if($id == Session::get('id')){
        ?>
        <div class="form-group">
           
            <button class="btn btn-success" type="submit" name="update">Update</button>
            <a href="change_password.php?id=<?php echo $id;?>" class="btn btn-info" >Update Password</a>

        </div>
        <?php }else {?>
            <a href="index.php" class="btn btn-primary">Back to home</a>
        <?php } ?>

        <?php } ?>


    </form>
</div>


</div>

<!-- include the footer -->
<?php include "inc/footer.php"?>