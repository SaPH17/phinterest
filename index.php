<?php
    include './database/db.php'; 
    include './helper/pinHelper.php';
    include './helper/boardHelper.php';

    if(!isset($_SESSION['userId'])){
        header("Location: ./login.php");
    }

    $pins = get_all_pin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHinterest</title>
    <link rel="stylesheet" href="./style/css/base.css">
    <link rel="stylesheet" href="./style/css/fab.css">
    <link rel="stylesheet" href="./style/css/header.css">
    <link rel="stylesheet" href="./style/css/index.css">
    <link rel="shortcut icon" href="./asset/icon/favicon.png" type="image/x-icon"/>
    <script src="./script/jquery-3.6.0.js"></script>
</head>
<body>
    <?php 
        include './component/header.php';
    ?>
    <div class="app-content">
        <div class="images-container">
            <?php 
                while($row = $pins->fetch_assoc()){
            ?>
                <div class="card-container">
                    <div class="card-image">
                        <div class="card-overlay">
                            <form action="/controller/pinController.php" method="post">
                                <input type="hidden" name="pin_id" value=<?= $row['id'] ?>>
                                <div class="overlay-wrapper">
                                    <div class="select-board-container">
                                        <select name="board">
                                            <option value="">Select board</option>
                                            <?php
                                                show_user_board_option($_SESSION['userId']);
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="action" value="insert-board" class="save-pin-btn">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                        <a href="/pin.php?id=<?= $row['id'] ?>">                        
                            <?php
                                show_pin_card($row);
                             ?>
                        </a>
                    </div>
                    <div class="card-title">
                        <?= $row['title'] ?>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
    </div>
    <?php 
        include './component/create-fab.php';
    ?>
</body>
</html>