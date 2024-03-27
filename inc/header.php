<?php 
    //include Session file here
    $filepath = realpath(dirname(__FILE__));
    include_once $filepath . "/../lib/Session.php";
    Session::init();

    //User logout mechanism
    if(isset($_GET['action']) && $_GET['action'] == 'logout'){
        Session::destroy();
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Register System with PHP</title>
    <link rel="stylesheet" type="text/css" href="inc/bootstrap.min.css" />

    <script src="inc/jquery.min.js"></script>
    <script src="inc/bootstrap.min.js"></script>
</head>

<body>

<!-- main container -->
    <div class="container">
    <!-- header -->
        <nav class="navbar navbar-default bg-dark navbar-expand-xl mt-4">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="index.php" class="navbar-brand">Login Register System</a>
                </div>
                <ul class="nav navbar-nav pull-right">

                <!-- show profile and logout to logged in user -->
                    <?php 
                        $id = Session::get('id');
                        $login = Session::get("Login");

                        if($login){

                    ?>
                    <li class="nav-item"><a class="nav-link" href="profile.php?id=<?php echo $id;?>">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="?action=logout">Logout</a></li>
                    <?php }else {?>

                    <!-- show these the menu item if user not logged in -->
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>

                    <?php }?>
                </ul>
            </div>
        </nav>