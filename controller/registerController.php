<?php
    include '../database/db.php';
    include '../helper/encryptionHelper.php';

    function is_alpha_num($string){
        $flag1 = false;
        $flag2 = false;
        for($i = 0; $i < strlen($string); $i++){
            if(is_numeric($string[$i])){
                $flag1 = true;
            }
            if(ctype_alpha($string[$i])){
                $flag2 = true;
            }
        }

        return $flag1 && $flag2;
    }

    function is_email_unique($email){
        global $conn;
        $sql = "SELECT * FROM users WHERE email = ?";

        $statement = $conn->prepare($sql);
        $statement->bind_param('s', $email);
    
        $statement->execute();
        $result = $statement->get_result();

        return $result->num_rows == 0;
    }

    function handle_error_message($message, $email, $password, $age){
        $_SESSION['error'] = $message;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['age'] = $age;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'register'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $age = $_POST['age'];

        if($email == '' || $password == '' || $age == ''){
            handle_error_message("All fields need to be filled!", $email, $password, $age);
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            handle_error_message("Email is not valid!", $email, $password, $age);
        }
        else if(!is_email_unique($email)){
            handle_error_message("Email is already taken!", $email, $password, $age);
        }
        else if(strlen($password) < 8){
            handle_error_message("Password must be atleast 8 characters!", $email, $password, $age);
        }
        else if(!is_alpha_num($password)){
            handle_error_message("Password must contain alphabet and number!", $email, $password, $age);
        }
        else if(!is_numeric($age)){
            handle_error_message("Age must be a number!", $email, $password, $age);
        }
        else if($age < 1){
            handle_error_message("Age must be atleast 1!", $email, $password, $age);
        }
        else{
            $hashed = encrypt($password);
            $username = explode("@", $email)[0];
            $default = "default.png";
            
            $sql = "INSERT INTO users VALUES(UUID(), ?, ?, ?, ?, ?)";

            $statement = $conn->prepare($sql);
            $statement->bind_param('sssis', $email, $username, $hashed, $age, $default);
            
            $statement->execute();
            header("location: ../login.php");
            return;
        }

        header('location: ../register.php');
    }

?>