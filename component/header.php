<?php
    include_once './database/db.php'; 
    include_once './helper/userHelper.php';

    $user = get_logged_in_user();
?>
<div class="header-container">
    <div class="logo-container">
        <a href="/">
            <svg class="logo" height="24" width="24" viewBox="0 0 24 24"><path fill="currentColor" d="M0 12c0 5.123 3.211 9.497 7.73 11.218-.11-.937-.227-2.482.025-3.566.217-.932 1.401-5.938 1.401-5.938s-.357-.715-.357-1.774c0-1.66.962-2.9 2.161-2.9 1.02 0 1.512.765 1.512 1.682 0 1.025-.653 2.557-.99 3.978-.281 1.189.597 2.159 1.769 2.159 2.123 0 3.756-2.239 3.756-5.471 0-2.861-2.056-4.86-4.991-4.86-3.398 0-5.393 2.549-5.393 5.184 0 1.027.395 2.127.889 2.726a.36.36 0 0 1 .083.343c-.091.378-.293 1.189-.332 1.355-.053.218-.173.265-.4.159-1.492-.694-2.424-2.875-2.424-4.627 0-3.769 2.737-7.229 7.892-7.229 4.144 0 7.365 2.953 7.365 6.899 0 4.117-2.595 7.431-6.199 7.431-1.211 0-2.348-.63-2.738-1.373 0 0-.599 2.282-.744 2.84-.282 1.084-1.064 2.456-1.549 3.235C9.584 23.815 10.77 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0 0 5.373 0 12"></path></svg>
        </a>
    </div>
    <div class="links-container">
        <ul>
            <li class="nav-link <?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? "active" : "" ?>"><a href="/">Home</a></li>
        </ul>
    </div>
    <div class="search-container">
        <svg class="search-icon" height="16" width="16" viewBox="0 0 24 24"><path fill="currentColor" d="M10 16c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6m13.12 2.88-4.26-4.26A9.842 9.842 0 0 0 20 10c0-5.52-4.48-10-10-10S0 4.48 0 10s4.48 10 10 10c1.67 0 3.24-.41 4.62-1.14l4.26 4.26a3 3 0 0 0 4.24 0 3 3 0 0 0 0-4.24"></path></svg>
        <input class="search-input" type="text" id="search-bar" placeholder="Search" onkeyup="searchListener()" 
                value=<?php 
                        if(isset($_GET['title'])){
                            echo $_GET['title'];
                        }
                    ?>>
    </div>
    <div class="profile-container">
        <a href="/profile.php" class="picture-container">
            <img src="./asset/image/profile-picture/<?= $user['profile_picture'] ?>" alt="">
        </a>
        <div class="options-menu-container">
            <button class="options-wrapper" onclick="$('#options-menu').toggle()">
                <div class="options-icon-container">
                    <svg class="options-icon" height="12" width="12" viewBox="0 0 24 24" aria-hidden="true" aria-label="" role="img"><path d="M12 19.5.66 8.29c-.88-.86-.88-2.27 0-3.14.88-.87 2.3-.87 3.18 0L12 13.21l8.16-8.06c.88-.87 2.3-.87 3.18 0 .88.87.88 2.28 0 3.14L12 19.5z"></path></svg>
                </div>
            </button>
            <div class="options-menu" id="options-menu">
                <div class="menu-profile-container">
                    <div class="title">
                        Currently in
                    </div>
                    <div class="menu-profile">
                        <div class="profile-picture">
                            <img src="./asset/image/profile-picture/<?= $user['profile_picture'] ?>" alt="">
                        </div>
                        <div class="profile-information">
                            <div class="profile-name">
                                <?= $user['username'] ?>
                            </div>
                            <div class="profile-email">
                                <?= $user['email'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="title">
                        More Options
                    </div>
                    <div class="menu-links">
                        <ul>
                            <li class="link-item">
                                <a href="/settings.php">Settings</a>
                            </li>
                            <li class="link-item">
                                <a href="/controller/logoutController.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
     function searchListener(){
        var search = $("#search-bar").val()
        setTimeout(() => {  

            if(search === $("#search-bar").val()){
                if(search === ""){
                    window.location = '/'
                }
                else{
                    window.location = '/search.php?title=' + $("#search-bar").val()
                }s
            }

        }, 500);
    }
</script>