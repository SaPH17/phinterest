<?php

    function get_logged_in_user(){
        global $conn;
        $id = $_SESSION['userId'];

        $sql = "SELECT * FROM users WHERE id = ?";

        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $id);
        $statement->execute();

        $res = $statement->get_result();

        if($res->num_rows == 1){
            $data = $res->fetch_assoc();
            return $data;
        }
        else{
            return null;
        }

    }

?>