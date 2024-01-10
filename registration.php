<?php

require __DIR__."/templates/registration_template.php";
require __DIR__."/libs/db.php";
require __DIR__."/libs/secrets.php";

if($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_COOKIE["session"])) {
        header("Location: /user_info.php");
        exit();
    }

}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = db_user_data_corrent_test(
        shield($_POST["username"]), 
        shield($_POST["email"]), 
        shield($_POST["phone"])
    );
    
    $errors["password"] = $_POST["password"] != $_POST["password_again"] || $_POST["password"] == "";
    $errors["email"] = $errors["email"] || !correct_email_check(shield($_POST["email"]));
    $errors["phone"] = $errors["phone"] || !correct_phone_check(shield($_POST["phone"]));

    if(!($errors["username"] || $errors["email"] || $errors["phone"] || $errors["password"]))
    {
        $result = db_create_user(
            shield($_POST["username"]),
            shield($_POST["email"]),
            shield($_POST["phone"]),
            make_password_hash($_POST["password"])
        );
        header("Location: /");
        exit();
    } else {
        $args = array(
                "old_username" => $_POST["username"],
                "old_email" => $_POST["email"],
                "old_phone" => $_POST["phone"],
                "error_username" => $errors["username"],
                "error_email" => $errors["email"],
                "error_phone" => $errors["phone"],
                "error_password" => $errors["password"]
        );
    }
}

include("templates/base.php");

?>
