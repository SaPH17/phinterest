<?php

if(!function_exists('encrypt')){
    function encrypt($string){
        return password_hash($string, PASSWORD_BCRYPT);
    }
}

if(!function_exists('verify_password')){
    function verify_password($plain, $hashed){
        return password_verify($plain, $hashed);
    }
}

?>