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

    function handle_error_message($message, $email, $password){
        $_SESSION['error'] = $message;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'login'){
        $email = $_POST['email'];
        $password = $_POST['password'];

        if($email == '' || $password == ''){
            handle_error_message("All fields need to be filled!", $email, $password);
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            handle_error_message("Email is not valid!", $email, $password);
        }
        else if(strlen($password) < 8){
            handle_error_message("Password must be atleast 8 characters!", $email, $password);
        }
        else if(!is_alpha_num($password)){
            handle_error_message("Password must contain alphabet and number!", $email, $password);
        }
        else{
            $output = false;

            $sql = "SELECT * FROM users WHERE email = ?";

            $statement = $conn->prepare($sql);
            $statement->bind_param("s", $email);
            $statement->execute();

            $res = $statement->get_result();

            if($res->num_rows == 1){
                $data = $res->fetch_assoc();
                if(verify_password($password, $data['password'])){
                    $_SESSION['userId'] = $data['id'];

                    if(isset($_POST["remember-me"])){
                        setcookie("email", $email, time() + 60 * 60 * 24 * 14, "/", null);
                        setcookie("password", $data['password'], time() + 60 * 60 * 24 * 14, "/", null);
                    }

                    header('location: /');
                    return;
                }
                else{
                    handle_error_message("Wrong username or password!", $email, $password);
                }
            }
        }

        header('location: ../login.php');
    } 
    else if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){
        $email = $_COOKIE['email'];
        $password = $_COOKIE['password'];


        $output = false;

        $sql = "SELECT * FROM users WHERE email = ?";

        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $email);
        $statement->execute();

        $res = $statement->get_result();

        if($res->num_rows == 1){
            $data = $res->fetch_assoc();
            if($password == $data['password']){
                $_SESSION['userId'] = $data['id'];


                if(isset($_POST["remember-me"])){
                    setcookie("email", $email, time() + 60 * 60 * 24 * 14, "/", null);
                    setcookie("password", $data['password'], time() + 60 * 60 * 24 * 14, "/", null);
                }

                header('Location: /');
                return;
            }
            else{
                handle_error_message("Cookie is invalid", $email, $password);
            }
        }

        header('location: ../login.php');
    }

?>