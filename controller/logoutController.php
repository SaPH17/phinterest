<?php
session_start();
session_unset();
session_destroy();
setcookie('email', "", time() - 3600, "/", null);
setcookie('password', "", time() - 3600, "/", null);
header('location: /login.php');