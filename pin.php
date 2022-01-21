<?php
    include './database/db.php';
    include './helper/boardHelper.php';
    include './helper/pinHelper.php';

    if(!isset($_SESSION['userId'])){
        header("Location: ./login.php");
    }

    if(!isset($_GET['id'])){
        header("Location: ./index.php");
    }

    $pin = get_pin_detail($_GET['id'])->fetch_assoc();
    $related = get_related_data($_GET['id']);
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
    <link rel="stylesheet" href="./style/css/pin.css">
    <link rel="shortcut icon" href="./asset/icon/favicon.png" type="image/x-icon"/>
    <script src="./script/jquery-3.6.0.js"></script>
</head>
<body>
    <?php 
        include './component/header.php';
    ?>
    <div class="app-content">
        <div class="pin-container">
            <div class="image-container">
                <?php
                    show_pin_card($pin);
                ?>
            </div>
            <div class="information-container">
                <form action="/controller/pinController.php" method="post">
                    <div class="board-container">
                        <input type="hidden" name="pin_id" value=<?= $_GET['id'] ?>>
                        <input type="hidden" name="source" value="pin">
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
                <div class="title">
                    <?= $pin['title'] ?>
                </div>
                <div class="description">
                    <?= $pin['description'] ?>
                </div>
                <a href="/profile.php?id=<?= $pin['user_id'] ?>" class="uploader-container">
                    <div class="picture-wrapper">
                        <img src="./asset/image/profile-picture/<?= $pin['profile_picture'] ?>" alt="">
                    </div>
                    <div class="uploader-name">
                        <?= $pin['username'] ?>
                    </div>
                </a>
            </div>
        </div>
        <div class="related-pin-container">
            <div class="title">
                More like this
            </div>
            <div class="images-container">
                <?php 
                    while($row = $related->fetch_assoc()){
                ?>
                    <div class="card-container">
                        <div class="card-image">
                            <div class="card-overlay">
                                <form action="/controller/pinController.php" method="POST">
                                    <input type="hidden" name="pin_id" value=<?= $row['id'] ?>>
                                    <input type="hidden" name="source" value="pin">
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
    </div>
    <?php 
        include './component/create-fab.php';
    ?>
</body>
</html>