<?php
    include './database/db.php';
    include './helper/boardHelper.php';

    if(!isset($_SESSION['userId'])){
        header("Location: ./login.php");
    }
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
    <link rel="stylesheet" href="./style/css/create-pin.css">
    <link rel="shortcut icon" href="./asset/icon/favicon.png" type="image/x-icon"/>
    <script src="./script/jquery-3.6.0.js"></script>
</head>
<body>
    <?php 
        include './component/header.php';
    ?>
    <div class="app-content">
        <form action="./controller/pinController.php" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <div class="save-container">
                    <div class="select-board-container">
                        <select name="board">
                            <option value="">Select board</option>
                            <?php
                                show_user_board_option($_SESSION['userId']);
                            ?>
                        </select>
                    </div>
                    <button name="action" value="insert" class="save-pin-btn">
                        Save
                    </button>
                </div>
                <div class="upload-container">
                    <div id="preview-wrapper" class="preview-wrapper">
                        <img id="image-preview" src="" alt="">
                        <video id="video-preview" autoplay muted loop src=""></video>
                    </div>
                    <label id="upload-wrapper" class="upload-wrapper" for="pin">
                        <div class="upload-notice">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-circle-up" class="svg-inline--fa fa-arrow-circle-up fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm143.6 28.9l72.4-75.5V392c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V209.4l72.4 75.5c9.3 9.7 24.8 9.9 34.3.4l10.9-11c9.4-9.4 9.4-24.6 0-33.9L273 107.7c-9.4-9.4-24.6-9.4-33.9 0L106.3 240.4c-9.4 9.4-9.4 24.6 0 33.9l10.9 11c9.6 9.5 25.1 9.3 34.4-.4z"></path></svg>
                            <div class="upload-notice-text">
                                    Click to upload
                            </div>
                        </div>
                        <div class="upload-recommendation">
                            Recommendation: Use high quality file less than 20MB
                        </div>
                    </label>
                    <input type="file" name="pin" id="pin">
                </div>
                <div class="input-container">
                    <input type="text" class="input input-title" name="title" placeholder="Add your title">
                    <input type="text" class="input description-title" name="description" placeholder="Tell everyone what your Pin is about">
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
                </div>
            </div>
        </form>
    </div>
    <?php 
        include './component/create-fab.php';
    ?>
</body>
<script>
  function loadPreview(e){
    var images = ["image/jpeg", "image/png"]
    var videos = ['video/mp4']
    var previewWrapper = $("#preview-wrapper")[0]
    var imagePreview =  $("#image-preview")[0]
    var videoPreview =  $("#video-preview")[0]
    
    previewWrapper.style.display = "flex";
    var type = e.target.files[0].type;
    if(images.includes(type)){
        imagePreview.style.display = "flex";
        imagePreview.src = URL.createObjectURL(e.target.files[0])
    }
    else{
        videoPreview.style.display = "flex";
        videoPreview.src = URL.createObjectURL(e.target.files[0])
    }
    $("#upload-wrapper")[0].style.display = "none";
  }

  $("#pin").on("change", loadPreview)
</script>
</html>