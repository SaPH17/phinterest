<?php
    include '../database/db.php';
    include '../helper/encryptionHelper.php';

    function handle_error_message($message, $email, $password, $username){
        $_SESSION['error'] = $message;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['username'] = $username;
    }

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

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update'){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $curr_password = $_POST['curr-password'];
        $profile_picture = $_FILES['profile-picture'];

        $has_image = $profile_picture['name'] != "";
        $image_name = time() . "_" . basename($profile_picture["name"]);

        $root_folder = $_SERVER['DOCUMENT_ROOT'];
        $save_folder = 'asset/image/profile-picture';
        $target_file_path = "$root_folder/$save_folder/$image_name";

        $extension = strtolower(pathinfo($target_file_path, PATHINFO_EXTENSION));
        $allowed_extension = ['jpg', 'png'];

        $sql = "SELECT * FROM users WHERE id = '" . $_SESSION['userId'] . "'";
        $user = $conn->query($sql)->fetch_assoc();

        if($email == '' || $curr_password == '' || $username == ''){
            handle_error_message("All fields except new password need to be filled!", $email, $password, $username);
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            handle_error_message("Email is not valid!", $email, $password, $username);
        }
        else if($email != $user['email'] && !is_email_unique($email)){
            handle_error_message("Email is already taken!", $email, $password, $username);
        }
        else if($password != '' && strlen($password) < 8){
            handle_error_message("Password must be atleast 8 characters!", $email, $password, $username);
        }
        else if($password != '' && !is_alpha_num($password)){
            handle_error_message("Password must contain alphabet and number!", $email, $password, $username);
        }
        else if($has_image && !in_array($extension, $allowed_extension)){
            handle_error_message("File extension must only be jpg or png!", $email, $password, $username);
        }
        else if(!verify_password($curr_password, $user['password'])){
            handle_error_message("Current password is incorrect!", $email, $password, $username);
        }
        else{
            $new_password = $password == '' ? $curr_password : $password;
            $new_password = encrypt($new_password);

            if($has_image){
                $sql = "UPDATE users SET email = ?, password = ?, username = ?, profile_picture = ? WHERE id = ?";
                $statement = $conn->prepare($sql);
                $statement->bind_param("sssss", $email, $new_password, $username, $image_name, $_SESSION['userId']);
                $statement->execute();

                $old_image = $user['profile_picture'];
                $old_image_path = "$root_folder/$save_folder/$old_image";

                if($old_image != "default.png" && file_exists($old_image_path)){
                    unlink($old_image_path);
                }
                move_uploaded_file($profile_picture['tmp_name'], $target_file_path);
            }
            else{
                $sql = "UPDATE users SET email = ?, password = ?, username = ? WHERE id = ?";
                $statement = $conn->prepare($sql);
                $statement->bind_param("ssss", $email, $new_password, $username, $_SESSION['userId']);
                $statement->execute();
            }
        }

        header("Location: ../settings.php");
    }

?>