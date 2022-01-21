<?php

    function get_all_pin(){
        global $conn;

        $sql = "SELECT * FROM pins ORDER BY RAND()";

        return $conn->query($sql);
    }

    function get_all_pin_by_title($title){
        global $conn;

        $sql = "SELECT * FROM pins WHERE title LIKE '%$title%' ORDER BY RAND()";

        return $conn->query($sql);
    }

    function get_pin_detail($pin_id){
        global $conn;

        $sql = "SELECT * FROM pins JOIN users ON pins.user_id = users.id WHERE pins.id = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $pin_id);
        $statement->execute();

        return $statement->get_result();
    }

    function get_related_data($pin_id){ 
        global $conn;

        $sql = "SELECT * FROM pins WHERE id != ? ORDER BY RAND()";
        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $pin_id);
        $statement->execute();

        return $statement->get_result();
    }

    function show_pin_card($row){
        $media = $row['media'];
        echo $row['type'] == "video" ? "<video autoplay loop muted src=./asset/video/$media></video>" 
                : "<img src=./asset/image/pin/$media >";
    }

?>