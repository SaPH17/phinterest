<?php
    include './database/db.php';

    if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){
        header("Location: ./controller/loginController.php");
        return;
    }
    
    if(isset($_SESSION['userId'])){
        header("Location: /");
        return;
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
    <link rel="stylesheet" href="./style/css/auth.css">
    <link rel="shortcut icon" href="./asset/icon/favicon.png" type="image/x-icon"/>
</head>
<body>

    <div class="container">
        <div class="signup-title-container">
            <h2 class="signup-title">
                Sign in to get your ideas
            </h2>
        </div>
        <div class="form-container">
            <div class="form-icon">
                <svg height="40" viewBox="-3 -3 82 82" width="40" style="display: block;"><circle cx="38" cy="38" fill="white" r="40"></circle><path d="M27.5 71c3.3 1 6.7 1.6 10.3 1.6C57 72.6 72.6 57 72.6 37.8 72.6 18.6 57 3 37.8 3 18.6 3 3 18.6 3 37.8c0 14.8 9.3 27.5 22.4 32.5-.3-2.7-.6-7.2 0-10.3l4-17.2s-1-2-1-5.2c0-4.8 3-8.4 6.4-8.4 3 0 4.4 2.2 4.4 5 0 3-2 7.3-3 11.4C35.6 49 38 52 41.5 52c6.2 0 11-6.6 11-16 0-8.3-6-14-14.6-14-9.8 0-15.6 7.3-15.6 15 0 3 1 6 2.6 8 .3.2.3.5.2 1l-1 3.8c0 .6-.4.8-1 .4-4.4-2-7-8.3-7-13.4 0-11 7.8-21 22.8-21 12 0 21.3 8.6 21.3 20 0 12-7.4 21.6-18 21.6-3.4 0-6.7-1.8-7.8-4L32 61.7c-.8 3-3 7-4.5 9.4z" fill="#e60023" fill-rule="evenodd"></path></svg>
            </div>
            <div class="form-title">
                Welcome to PHinterest
            </div>
            <div class="subtitle">
                Find new ideas to try
            </div>
            <div class="input-container">
                <form action="./controller/loginController.php" method="POST">
                    <div class="form-input">
                        <input type="text" name="email" placeholder="Email" 
                                value=<?php
                                    if(isset($_SESSION['email'])){
                                        echo $_SESSION['email'];
                                        unset($_SESSION['email']);
                                    }
                                ?>>
                    </div>
                    <div class="form-input">
                        <input type="password" name="password" placeholder="Password" 
                                value=<?php
                                    if(isset($_SESSION['password'])){
                                        echo $_SESSION['password'];
                                        unset($_SESSION['password']);
                                    }
                                ?>>
                    </div>
                    <div class="form-input">
                        <input type="checkbox" name="remember-me" id="remember-me" placeholder="Password">
                        <label for="remember-me">Remember Me</label>
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
                    <div class="button-container">
                        <button class="cta-button" name="action" value="login" type="submit">Continue</button>
                    </div>
                </form>
            </div>
            <div class="links-container">
                By continuing, you agree to PHinterest's <a href="" class="form-link">Terms of Service</a> and acknowledge you've read our <a href="" class="form-link">Privacy Policy</a>
            </div>
            <div class="auth-container">
                <a href="./register.php">Not on PHinterest yet? Sign up</a>
            </div>
        </div>
    </div>
</body>
</html>