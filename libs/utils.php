<?php

function make_password_hash(string $password) 
{
    $salt = "some_salt";
    $result = $password.$salt;
    for($i = 0; $i < 10; $i++) {
        $result = md5($result.$salt);
    }
    return $result;
}

function shield(string $value) {
    return htmlspecialchars(str_replace('"', "", $value));
}

function correct_email_check(string $mail) {
    return preg_match('/\w+@\w+\.\w+/', $mail);
}

function correct_phone_check(string $phone) {
    return preg_match('/^\+7\d{10}$/', $phone);
}

?>
