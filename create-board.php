<?php
    include_once './database/db.php'; 
    include './helper/userHelper.php';

    if(!isset($_SESSION['userId'])){
        header("Location: ./login.php");
    }

    $user = get_logged_in_user();
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
    <link rel="stylesheet" href="./style/css/settings.css">
    <link rel="shortcut icon" href="./asset/icon/favicon.png" type="image/x-icon"/>
    <script src="./script/jquery-3.6.0.js"></script></head>
<body>
    <?php 
        include './component/header.php';
    ?>
    <div class="app-content">
        <div class="content-container">
            <div class="heading">
                Create Board
            </div>
            <div class="subheading">
                Make a new board inside your profile
            </div>
            <form action="./controller/boardController.php" method="POST">
                <div class="form-group">
                    <div class="form-title">
                        Name
                    </div>
                    <div class="form-input">
                        <input type="text" name="name" placeholder='Like "Places to Go" or "Recipes to Make"'>
                    </div>
                </div>
                <div class="form-error">
                    <?php
                        if(isset($_SESSION['error'])){
                    ?>
                            <?= $_SESSION['error'] ?>
                    <?php
                            unset($_SESSION['error']);
                        }
                    ?>
                </div>
                <div class="form-group">
                    <button name="action" value="insert" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>