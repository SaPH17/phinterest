<?php

    function get_user_boards($user_id){
        global $conn;

        $sql = "SELECT *, (SELECT COUNT(*) FROM board_details WHERE board_details.board_id = boards.id) AS total FROM boards WHERE user_id = '$user_id'"; 

        $boards = $conn->query($sql);
        return $boards;
    }

    function get_board_data($board_id){
        global $conn;

        $sql = "SELECT b.id, b.user_id, b.name, bd.pin_id, bd.timestamp, p.title, p.description, p.type, p.media, IFNULL((SELECT COUNT(*) FROM board_details AS bd2 WHERE bd2.board_id = bd.board_id), 0) AS total FROM boards AS b
        LEFT JOIN board_details AS bd ON b.id = bd.board_id 
        LEFT JOIN pins AS p ON p.id = bd.pin_id
        WHERE b.id = '$board_id' ORDER BY bd.timestamp DESC"; 

        $boards = $conn->query($sql);
        return $boards;
    }

    function get_full_board_data($user_id, $sort_type){
        global $conn;        

        $sql = "SELECT b.id AS board_id, b.user_id, b.name, x.pin_id, IFNULL(y.total, 0) AS total, c.title, c.description, c.type, c.media, x.timestamp FROM 
        (SELECT board_id, pin_id, timestamp, rn FROM 
            (SELECT bd.board_id, bd.pin_id, bd.timestamp, ROW_NUMBER() OVER (PARTITION BY bd.board_id ORDER BY bd.timestamp DESC) AS rn 
            FROM board_details bd) AS tmp 
        WHERE tmp.rn <= 3) AS x 
            RIGHT JOIN 
        (SELECT b.id AS board_id, bd.timestamp, IFNULL(count(bd.pin_id), 0) AS 'total' 
        FROM board_details bd 
        RIGHT JOIN boards b on bd.board_id = b.id
        GROUP BY bd.board_id) y ON x.board_id = y.board_id 
        LEFT JOIN pins c ON c.id = x.pin_id 
        RIGHT JOIN boards b ON b.id = x.board_id 
        WHERE b.user_id = '$user_id'";

        $boards = [];

        $res = $conn->query($sql);
        $row_num = 0;

        while($row = $res->fetch_assoc()){
            $row_num++;
            $curr = $row['board_id'];

            $row_data = [];
            $row_data['board_id'] = $row['board_id'];
            $row_data['name'] = $row['name'];
            $row_data['total'] = $row['total'];
            $row_data['timestamp'] = $row['timestamp'];
            $row_data['pin'] = [];
            
            while(true){
                if($row['media'] == null){
                    array_push($boards, $row_data);
                    break;
                }

                $pin_data = [];
                $pin_data['media'] = $row['media'];
                $pin_data['type'] = $row['type'];
                if($row_data['timestamp'] < $row['timestamp']){
                    $row_data['timestamp'] = $row['timestamp'];
                }

                $row = $res->fetch_assoc();
                $row_num++;
                if($row == null || $row['board_id'] != $curr){
                    array_push($row_data['pin'], $pin_data);
                    array_push($boards, $row_data);
                    $res->data_seek($row_num-1);
                    $row_num -= 1;
                    break;
                }
                else{
                    array_push($row_data['pin'], $pin_data);
                }
            }
            
        }

        if($sort_type == 1){
            usort($boards, "sort_name_asc");
        }
        else if($sort_type == 2){
            usort($boards, "sort_name_desc");
        }
        else{
            usort($boards, "sort_timestamp");
        }

        return $boards;
    }

    function sort_name_asc($a, $b){
        if($a['name'] == $b['name']){
            return 0;
        }

        return strcasecmp($a['name'], $b['name']);
    }

    function sort_name_desc($a, $b){
        if($a['name'] == $b['name']){
            return 0;
        }

        return strcasecmp($b['name'], $a['name']);
    }

    function sort_timestamp($a, $b){
        if($a['timestamp'] == $b['timestamp']){
            return 0;
        }

        return $a['timestamp'] < $b['timestamp'];
    }

    function show_user_board_option($user_id){
        $boards = get_user_boards($user_id);

        while($row = $boards->fetch_assoc()){
            $id = $row['id'];
            $name = $row['name'];
            echo "<option value=$id > $name </option>";
        }
    }

?>