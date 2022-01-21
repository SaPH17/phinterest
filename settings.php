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
                Edit Profile
            </div>
            <div class="subheading">
                Change your profile settings inside PHinterest
            </div>
            <form action="./controller/userController.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-title">
                        Photo
                    </div>
                    <div class="preview-wrapper">
                        <div class="preview">
                            <img src="./asset/image/profile-picture/<?= $user['profile_picture'] ?>" id="preview" alt="">
                        </div>
                        <div class="form-input">
                            <label for="profile-picture">Change</label>
                            <input type="file" name="profile-picture" id="profile-picture">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-title">
                        Username
                    </div>
                    <div class="form-input">
                        <input type="text" name="username" value=<?= $user['username'] ?> placeholder="The name that other people will see">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-title">
                        Email
                    </div>
                    <div class="form-input">
                        <input type="text" name="email" value=<?= $user['email'] ?> placeholder="Your email">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-title">
                        Password
                    </div>
                    <div class="form-input">
                        <input type="password" name="password" placeholder="New password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-title">
                        Current Passsword
                    </div>
                    <div class="form-input">
                        <input type="password" name="curr-password" placeholder="Your current password">
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
                    <button name="action" value="update" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
  function loadPreview(e){
    var preview = $("#preview")[0]
    preview.src = URL.createObjectURL(e.target.files[0])
    preview.onload = function() {
      URL.revokeObjectURL(preview.src) 
    }
  }

  $("#profile-picture").on("change", loadPreview)
</script>
</html>