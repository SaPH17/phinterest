<?php

    include '../database/db.php';

    function handle_error_message($message, $name){
        $_SESSION['error'] = $message;
        $_SESSION['name'] = $name;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert'){
        $name = $_POST['name'];
        $userId = $_SESSION['userId'];

        if($name == ""){
            handle_error_message("Name must be filled!", $name);
        }
        else{
            $sql = "INSERT INTO boards VALUES(UUID(), ?, ?)";
            $statement = $conn->prepare($sql);
            $statement->bind_param("ss", $_SESSION['userId'], $name);
            $statement->execute();
        }

        header("Location: /profile.php");
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update'){
        $id = $_POST['id'];
        $name = $_POST['name'];

        if($name == ""){
            handle_error_message("Name must be filled!", $name);
        }
        else{
            $sql = "UPDATE boards SET name = ? WHERE id = ?";
            $statement = $conn->prepare($sql);
            $statement->bind_param("ss",  $name, $id);
            $statement->execute();
        }

        header("Location: /board.php?id=$id");
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete'){
        $id = $_POST['id'];

        $sql = "DELETE FROM boards WHERE id = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $id);
        $statement->execute();

        header("Location: /profile.php");
    }


?>