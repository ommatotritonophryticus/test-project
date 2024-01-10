<?php

require __DIR__."/../libs/secrets.php";

function get_title() {
    return "Auth";
}

function get_content($args) {
    global $client_secret;
?>
    <script>
         function enableBtn(){
           document.getElementById("submit_button").disabled = false;
         }
    </script>
    <h1 class="title">Test Project</h1>
    <form method="POST">
        <p>Email or phone number</p>
        <input type="text" name="username"/>
        <p>Password</p>
        <input type="password" name="password"/>
        <br /><div class="g-recaptcha" data-sitekey="<?= $client_secret ?>" data-callback="enableBtn"></div>
        <br /><input class="btn btn-primary" type="submit" value="Login" id="submit_button" disabled="disabled"/>
    </form>
    <a href="/registration.php">
        <input type="button" class="btn btn-success" value="Registration"/>
    </a>
    <script src='https://www.google.com/recaptcha/api.js'></script>
<?php
}

?>
