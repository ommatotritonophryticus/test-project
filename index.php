<?php

require __DIR__."/templates/index_template.php";
require __DIR__."/libs/db.php";
require __DIR__."/libs/secrets.php";


if($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_COOKIE["session"])) {
        header("Location: /user_info.php");
        exit();
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = true;
    
    if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'])
    {
	    $remote_ip = $_SERVER['REMOTE_ADDR'];
	    $capcha_response = $_POST['g-recaptcha-response'];
	    $request = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$server_secret."&response=".$capcha_response."&remoteip=".$remote_ip);
	    $result = json_decode($request, TRUE);

	    if ($result['success'])
	    {
		    $error = false;
	    }
    }

    if (db_login_test(shield($_POST["username"]), make_password_hash($_POST["password"])) && !$error) 
    {
        $user_id = db_get_user_id_about_login(shield($_POST["username"]));
        db_create_session($user_id);
        
        $session = db_get_active_sessions($user_id);
        
        setcookie("session", $session);
        
        header("Location: /user_info.php");
        exit();
    }
}
include("templates/base.php");

?>
