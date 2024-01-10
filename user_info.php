<?php

require __DIR__."/templates/user_info_template.php";
require __DIR__."/libs/db.php";

if($_SERVER["REQUEST_METHOD"] == "GET") {

    if(!isset($_COOKIE["session"])) {
        header("Location: /");
        exit();
    }
    
    $args = db_get_user_info(shield($_COOKIE["session"]));


}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_info = db_get_user_info(shield($_COOKIE["session"]));

    $errors = db_new_user_data_corrent_test(
        $user_info['id'],
        shield($_POST["username"]), 
        shield($_POST["email"]), 
        shield($_POST["phone"])
    );
    
    $errors["password"] = $_POST["password"] != $_POST["password_again"] || $_POST["password"] == "";
    $errors["email"] = $errors["email"] || !correct_email_check(shield($_POST["email"]));
    $errors["phone"] = $errors["phone"] || !correct_phone_check(shield($_POST["phone"]));
    
    if($user_info["username"] != shield($_POST["username"]) && !($errors["username"]))
    {
        db_change_username($user_info["id"], shield($_POST["username"]));
        $errors["username"] = false;
    }
    if($user_info["email"] != shield($_POST["email"]) && !($errors["email"]))
    {
        db_change_email($user_info["id"], shield($_POST["email"]));
        $errors["email"] = false;
    }
    if($user_info["phone"] != shield($_POST["phone"]) && !($errors["phone"]))
    {
        db_change_phone($user_info["id"], shield($_POST["phone"]));
        $errors["phone"] = false;
    }
    if(!$errors["password"] && $_POST["password"] != "")
    {
        db_change_password($user_info["id"], make_password_hash($_POST['password']));
    }
    
    
    
    if($user_info["username"] != shield($_POST["username"]) && !($errors["username"]))
    {
        db_change_username($user_info["id"], shield($_POST["username"]));
    }

    $user_info = db_get_user_info(shield($_COOKIE["session"]));

    $args = array(
            "username" => $user_info["username"],
            "email" => $user_info["email"],
            "phone" => $user_info["phone"],
            "error_username" => $errors["username"],
            "error_email" => $errors["email"],
            "error_phone" => $errors["phone"],
            "error_password" => $errors["password"]
    );
}

include("templates/base.php");

?>
