<!-- include the header -->
<?php 
    include "inc/header.php";
    include "lib/User.php";

    //check_session; if not looged in redirect to login page
    Session::check_session();
    
    //make object of User class to connect with database
    $user = new User();

    //get the login message from Session
    $login_message = Session::get("Login_message");


?>


        <!-- main content -->
        <div class="bg-light p-4" style="min-height: 500px;">
            <div class="panel-heading" style="display: grid; grid-template-columns: 70% 30%;">
                <h3>User List </h3>
                <p>Welcome: <b><?php echo Session::get("Name"); ?></b></p>
                
            </div>

            <div class="panel-body">

            <!-- print the login message -->
            <?php 
                if(isset($login_message)) {
                    echo $login_message;
                }

                Session::set("Login_message", NULL);
            ?>

                <table class="table table-striped">
                    <tr>
                        <th>Serial</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email Address</th>
                        <th>
                            Action
                        </th>
                    </tr>

                    <!-- fetch all user data from database -->
                    <?php 
                        $user_data = $user->all_user_data(); 

                        if(isset($user_data)) {
                            $i = 0;
                            foreach($user_data as $data){

                            $i++;
                        
                    ?>

                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $data['name']; ?></td>
                        <td><?php echo $data['username']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td>
                        <a class="btn btn-primary" href="profile.php?id=<?php echo $data['id']?>">View</a>
                        </td>
                    </tr>

                    <?php } }?>

                   
                    
                </table>
            </div>
        </div>


<!-- include the footer -->
<?php include "inc/footer.php"?>