<?php

//Include require files
include_once("Session.php");
include("Database.php");

class User{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }


    //User registration mechanism
    public function user_registration($data){

        //get all form fields values
        $name = $data['name'];
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];

        //check username availability
        $check_username = $this->check_username($username);
        if($check_username){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username already exists.</div>";
            
            return $msg;
        }

        //check email address availability
        $check_email = $this->check_email($email);

        //check field empty
        if($name == "" OR $username == "" OR $email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Any field must not be empty.</div>";

            //return the message if any field is empty
            return $msg;
        }

        //check username length [min length is: 3]
        if(strlen($username) < 3){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username is too short. Minimum username length is: 3</div>";

            //return the error message is username is less than 3 characters
            return $msg;
        }elseif(preg_match('/[^a-z0-9_-]+/i', $username)){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username: Only allow lowercase letters, numners, underscore and dashes</div>";
        }

        //check password length [min length is: 6]
        if(strlen($password) < 6){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Password is too short. Minimum password length is: 6</div>";

            //return the error message is password is less than 6 characters
            return $msg;
        }


        //check valid email address
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Email address is not valid</div>";

            return $msg;
        }

        //check email availability
        if($check_email){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> The email address is already exists.</div>";

            return $msg;
        }


        //create user account and insert user information in database
        $password = md5($password);
        $sql = "INSERT INTO tbl_user(name, username, email, password) VALUES(:name, :username, :email, :password)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":name", $name);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);

        $result = $query->execute();

        if($result){
            $msg = "<div class='alert alert-success'>Welcome ".$name."! You have been registered successfully.</div>";
            
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger'>Something went wrong. Please try again</div>";
            return $msg;
        }

    }


    //check email availability with check_email() method
    public function check_email($email){
        //sql query to select the email address from database
        $sql = "SELECT email FROM tbl_user WHERE email = :email";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":email", $email);
        $query->execute();

        //check row count
        if($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    //check username availability
    public function check_username($username){
        $sql = "SELECT username FROM tbl_user WHERE username = :username";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":username", $username);
        $query->execute();

        //check row count
        if($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }

    }


    //User Login Mechanism
    public function user_login($data){
        $email = $data["email"];
        $password = $data["password"];

        //check empty fields
        if($email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Any field must not be empty.</div>";
            return $msg;
        }

        

        // Remove all illegal characters from email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Validate e-mail
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Please enter a valid email address!</div>";
            return $msg;
        }

        //sql query for fetch user data from database
        $password = md5($password);
        $sql = "SELECT * FROM tbl_user WHERE email = :email AND password = :password";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_OBJ);

        if($result){
            //if data found then start the session
            Session::init();
            Session::set("Login", true);
            Session::set("id", $result->id);
            Session::set("Name", $result->name);
            Session::set("Username", $result->username);
            Session::set("Email", $result->email);
            Session::set("Login_message", "<div class='alert alert-success'>Welcome ".$result->name."! You are Logged-in.</div>");

            //redirect after successfully logged in
            header("Location: index.php");
        }

        if($query->rowCount() > 0){
            $msg = "<div class='alert alert-success'>Welcome! You successfully logged-in</div>";

            return $msg;
        }else{
            $msg = "<div class='alert alert-danger'>Error! Incorrect Email address or password</div>";

            return $msg;
        }
    }

    //fetch all user data from database
    public function all_user_data(){
        $sql = "SELECT * FROM tbl_user ORDER BY id DESC";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();

        if($query->rowCount() > 0){
            $result = $query->fetchAll();
            return $result;
        }
    }

    //get single user data
    public function get_single_user_data( $id ){
        $sql = "SELECT * FROM tbl_user WHERE id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        if($query->rowCount() > 0){
            $result = $query->fetch();
            return $result;
        }
    }


    //update user mechanism method
    public function update_user_by_id($id, $old_username, $old_email, $data){

        $name = $data["name"];
        $username = $data["username"];
        $email = $data["email"];
        

        if($email != $old_email){
            // Remove all illegal characters from email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Validate e-mail
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $msg = "<div class='alert alert-danger'><strong>Error!</strong> Please enter a valid email address!</div>";
                return $msg;
            }

            //check email availability
            $check_email = $this->check_email($email);
            if ($check_email) {
                $msg = "<div class='alert alert-danger'><strong>Error!</strong> Email address already exists</div>";
                return $msg;
            }
        }

        //check username availability
        if($old_username != $username){
            $check_username = $this->check_username($username);
            if ($check_username) {
                $msg = "<div class='alert alert-danger'><strong>Error!</strong> Username already exists!</div>";
                return $msg;
            }
        }

        $sql = "UPDATE tbl_user SET name = :name, username = :username, email = :email WHERE id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":name", $name);
        $query->bindValue(":email", $email);
        $query->bindValue(":username", $username);
        $query->bindValue(":id", $id);

        $result = $query->execute();

        if($result){
            $msg = "<div class='alert alert-success'><strong>Success!</strong> ".$name."! Your profile information successfully updated</div>";
            return $msg;
        }
    }


    //user update passowr mechanism
    public function update_password_by_id($id, $data){
        $old_password = $data['old_password'];
        $new_password = $data['new_password'];
        $confirm_password = $data['confirm_password'];


        //check field empty
        if($old_password === "" OR $new_password === "" OR $confirm_password === ""){
            $msg = "<div class='alert alert-danger'>Error! Password Field Must Not Be Empty</div>";

            return $msg;
        }

        //get old password from database of the user by provided id
        $db_password = $this->get_password_by_id($id);

        //compare the given passowrd and database password
        if($db_password == md5($old_password)){

            //check the new password and confirm password
            if($new_password == $confirm_password){

                $new_password = md5($new_password);
                $sql = "UPDATE tbl_user SET password = :password WHERE id = :id";
                $query = $this->db->pdo->prepare($sql);
                $query->bindValue(":password", $new_password);
                $query->bindValue(":id", $id);
                $result = $query->execute();

                if($result){
                    $msg = "<div class='alert alert-success'>Success! Password updated successfully.</div>";

                    return $msg;


                }
            }else{
                $msg = "<div class='alert alert-danger'>Error! New passowrd and confirm did not match!</div>";

                return $msg;
            }

        }else{
            $msg = "<div class='alert alert-danger'>Error! Old password is not correct!</div>";

            return $msg;
        }

    }


    //Get password by id method
    public function get_password_by_id($id){
        $sql = "SELECT password FROM tbl_user WHERE id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        if($query->rowCount() > 0){
            $row = $query->fetch();
            return $row["password"];
        }
    }
}

?>