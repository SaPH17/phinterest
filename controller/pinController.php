<?php

    include '../database/db.php';

    function handle_error_message($message, $title, $description){
        $_SESSION['error'] = $message;
        $_SESSION['title'] = $title;
        $_SESSION['description'] = $description;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert'){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $board = $_POST['board'];

        $pin =  $_FILES['pin'];
        $pin_name = time() . "_" . $pin['name'];
        $extension = strtolower(pathinfo($pin_name, PATHINFO_EXTENSION));
        $size = $pin["size"];

        $allowed_extension = ['jpg', 'png', 'mp4'];

        $root_folder = $_SERVER['DOCUMENT_ROOT'];
        $save_folder = $extension == "mp4" ? "asset/video" : "asset/image/pin";
        $type = $extension == "mp4" ? "video" : "image";
        $target_file_path = "$root_folder/$save_folder/$pin_name";

        if($title == "" || $pin_name == "" || $board == ""){
            handle_error_message("Title, image and board must be filled!", $title, $description);
        }
        else if($size >= 1024 * 20){
            handle_error_message("Size must not exceed 20MB", $title, $description);
        }
        else if(!in_array($extension, $allowed_extension)){
            handle_error_message("File extension must only be jpg, png and mp4", $title, $description);
        }
        else{
            $sql = "SELECT UUID() AS UUID";
            $uuid = $conn->query($sql)->fetch_assoc()['UUID'];

            $sql = "INSERT INTO pins VALUES(?, ?, ?, ?, ?, ?, now())";
            $statement = $conn->prepare($sql);
            $statement->bind_param("ssssss", $uuid, $_SESSION['userId'], $title, $description, $type, $pin_name);
            $statement->execute();

            $sql = "INSERT INTO board_details VALUES(?, ?, now())";
            $statement = $conn->prepare($sql);
            $statement->bind_param("ss", $board, $uuid);
            $statement->execute();

            move_uploaded_file($pin['tmp_name'] ,$target_file_path);
        }

        header("Location: /create-pin.php");
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert-board'){
        $id = $_POST['pin_id'];
        $board_id = $_POST['board'];

        $sql = "SELECT * FROM board_details WHERE pin_id = ? AND board_id = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("ss", $id, $board_id);
        $statement->execute();
        $result = $statement->get_result();

        if($result->num_rows == 0){
            $sql = "INSERT INTO board_details VALUES(?, ?, now())";
            $statement = $conn->prepare($sql);
            $statement->bind_param("ss", $board_id, $id);
            $statement->execute();
        }

        if($_POST['source'] == "pin"){
            header("Location: /pin.php?id=$id");
        }
        else if($_POST['source'] == 'board'){
            header("Location: /profile.php");
        }
        else{
            header("Location: /");
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete-board'){
        $id = $_POST['pin_id'];
        $board_id = $_POST['board_id'];

        $sql = "DELETE FROM board_details WHERE pin_id = ? AND board_id = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("ss", $id, $board_id);
        $statement->execute();

        $sql = "SELECT * FROM board_details WHERE pin_id = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $id);
        $statement->execute();
        $result = $statement->get_result();

        if($result->num_rows == 0){
            $sql = "SELECT * FROM pins WHERE id = ?";
            $statement = $conn->prepare($sql);
            $statement->bind_param("s", $id);
            $statement->execute();
            $result = $statement->get_result();
            $data = $result->fetch_assoc();

            $sql = "DELETE FROM pins WHERE id = ?";
            $statement = $conn->prepare($sql);
            $statement->bind_param("s", $id);
            $statement->execute();            

            $save_folder = $data['type'] == "video" ? "asset/video" : "asset/image/pin";
            $file_path = $_SERVER['DOCUMENT_ROOT'] ."/" . $save_folder . "/" . $data['media'];

            unlink($file_path);
        }

        header("Location: /board.php?id=$board_id");
    }
?>