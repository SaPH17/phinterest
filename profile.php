<?php
    include './database/db.php'; 
    include './helper/userHelper.php';
    include './helper/boardHelper.php';

    if(!isset($_SESSION['userId'])){
        header("Location: ./login.php");
    }

    $user_data = get_logged_in_user();
    
    if(isset($_GET['id'])){
        $sql = "SELECT * FROM users WHERE id = ?";

        $statement = $conn->prepare($sql);
        $statement->bind_param("s", $_GET['id']);
        $statement->execute();

        $res = $statement->get_result();
        $user_data = $res->fetch_assoc();
    }

    $sort_type = 1;

    if(isset($_GET['sort']) && $_GET['sort'] >= 1 && $_GET['sort'] <= 3){
        $sort_type = $_GET['sort'];
    }
    $boards = get_full_board_data($user_data['id'], $sort_type);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHinterest</title>
    <link rel="stylesheet" href="./style/css/base.css">
    <link rel="stylesheet" href="./style/css/profile.css">
    <link rel="stylesheet" href="./style/css/header.css">
    <link rel="shortcut icon" href="./asset/icon/favicon.png" type="image/x-icon"/>
    <script src="./script/jquery-3.6.0.js"></script>
</head>
<body>
    <?php 
        include './component/header.php';
    ?>
    <div class="app-content">
        <div class="information-container">
            <div class="profile-image">
                <img src="./asset/image/profile-picture/<?= $user_data['profile_picture'] ?>" alt="">
            </div>
            <div class="profile-username">
                <?= $user_data['username'] ?>
            </div>
            <?php
                if($user_data['id'] == $_SESSION['userId']){
            ?>
                <div class="button-container">
                    <a class="button-item" href="/settings.php">Edit Profile</a>
                </div>
            <?php
                }
            ?>
        </div>
        <div class="board-container">
            <div class="board-btn-container">
                <div class="btn-wrapper">
                    <div class="btn sort-btn" onclick="$('#sort-menu').toggle()">
                        <svg height="20" width="20" viewBox="0 0 24 24"><path d="M9 19.5a1.75 1.75 0 1 1 .001-3.501A1.75 1.75 0 0 1 9 19.5M22.25 16h-8.321c-.724-2.034-2.646-3.5-4.929-3.5S4.795 13.966 4.071 16H1.75a1.75 1.75 0 0 0 0 3.5h2.321C4.795 21.534 6.717 23 9 23s4.205-1.466 4.929-3.5h8.321a1.75 1.75 0 0 0 0-3.5M15 4.5a1.75 1.75 0 1 1-.001 3.501A1.75 1.75 0 0 1 15 4.5M1.75 8h8.321c.724 2.034 2.646 3.5 4.929 3.5s4.205-1.466 4.929-3.5h2.321a1.75 1.75 0 0 0 0-3.5h-2.321C19.205 2.466 17.283 1 15 1s-4.205 1.466-4.929 3.5H1.75a1.75 1.75 0 0 0 0 3.5"></path></svg>
                    </div>
                    <div class="dropdown-menu" id="sort-menu">
                        <div class="title">
                            Sort boards by
                        </div>
                        <?php
                            if($user_data['id'] == $_SESSION['userId']){
                        ?>
                            <div class="menu-item">
                                <a href=<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "?sort=1" ?>>Name Ascending</a>
                            </div>
                            <div class="menu-item">
                                <a href=<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "?sort=2" ?>>Name Descending</a>
                            </div>
                            <div class="menu-item">
                                <a href=<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "?sort=3" ?>>Last Saved to</a>
                            </div>
                        <?php
                            }
                            else{
                        ?>
                            <div class="menu-item">
                                <a href=<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "?id=" . $user_data["id"] . "&sort=1" ?>>Name Ascending</a>
                            </div>
                            <div class="menu-item">
                                <a href=<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "?id=" . $user_data["id"] . "&sort=2" ?>>Name Descending</a>
                            </div>
                            <div class="menu-item">
                                <a href=<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "?id=" . $user_data["id"] . "&sort=3" ?>>Last Saved to</a>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
                    if($user_data['id'] == $_SESSION['userId']){
                ?>
                    <div class="btn-wrapper">
                        <div class="btn create-btn" onclick="$('#create-menu').toggle()">
                            <svg height="20" width="20" viewBox="0 0 24 24"><path d="M22 10h-8V2a2 2 0 0 0-4 0v8H2a2 2 0 0 0 0 4h8v8a2 2 0 0 0 4 0v-8h8a2 2 0 0 0 0-4"></path></svg>
                        </div>
                        <div class="dropdown-menu" id="create-menu">
                            <div class="title">
                                Create
                            </div>
                            <div class="menu-item">
                                <a href="./create-pin.php">Pin</a>
                            </div>
                            <div class="menu-item">
                                <a href="./create-board.php">Board</a>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
            <div class="board-content">
                <?php 
                    for($i = 0; $i < count($boards); $i++){
                        $row = $boards[$i];
                        $image_count = count($row['pin']);
                ?>
                    <a href="/board.php?id=<?= $row['board_id'] ?>" class="board-card">
                        <div class="board-images">
                            <div class="board-overlay"></div>
                            <div class="left-preview">
                                <?php
                                    if($image_count > 0){
                                        $media = $row['pin'][0]['media'];
                                        echo $row['pin'][0]['type'] == "video" ? "<video src='./asset/video/$media#t=1'></video>" : "<img src='./asset/image/pin/$media'>";
                                    }
                                    else{
                                        echo "<div class=placeholder></div>";
                                    }
                                ?>
                            </div>
                            <div class="right-preview">
                                <?php
                                    if($image_count > 1){
                                        $media = $row['pin'][1]['media'];
                                        echo $row['pin'][1]['type'] == "video" ? "<video src='./asset/video/$media#t=1'></video>" : "<img src='./asset/image/pin/$media'>";
                                    }
                                    else{
                                        echo "<div class=placeholder></div>";
                                    }
                                    if($image_count > 2){
                                        $media = $row['pin'][2]['media'];
                                        echo $row['pin'][2]['type'] == "video" ? "<video src='./asset/video/$media#t=1'></video>" : "<img src='./asset/image/pin/$media'>";
                                    }
                                    else{
                                        echo "<div class=placeholder></div>";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="board-information">
                            <div class="board-title">
                                <?= $row['name'] ?>
                            </div>
                            <div class="board-pins">
                                <?= $row['total'] . " Pins"?>
                            </div>
                        </div>
                    </a>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>