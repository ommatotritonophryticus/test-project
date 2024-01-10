<?php

require __DIR__."/../libs/secrets.php";

function get_title() {
    return "Registration";
}

function get_content($args) {
    global $client_secret;
?>
    <script>
         function enableBtn(){
           document.getElementById("submit_button").disabled = false;
         }
    </script>
    <h1 class="title">Registration</h1>
    <form method="POST">
        <p>Username</p>
        <?php if ($args["error_username"]) : ?><div class="error">Incorrect username</div><?php endif; ?>
        <input type="text" <?php if ($args["error_username"]) : ?> class="incorrect-field" <?php endif; ?> name="username" value="<?= $args["old_username"] ?>"/>
        
        <p>Email</p>
        <?php if ($args["error_email"]) : ?><div class="error">Incorrect email</div><?php endif; ?>
        <input type="text" <?php if ($args["error_email"]) : ?> class="incorrect-field" <?php endif; ?> name="email" value="<?= $args["old_email"] ?>"/>
        
        <p>Phone (format "+7XXXXXXXXXX")</p>
        <?php if ($args["error_phone"]) : ?><div class="error">Incorrect phone</div><?php endif; ?>
        <input type="text" <?php if ($args["error_phone"]) : ?> class="incorrect-field" <?php endif; ?> name="phone" placeholder="+7XXXXXXXXXX" value="<?= $args["old_phone"] ?>"/>
        
        <p>Password</p>
        <?php if ($args["error_password"]) : ?><div class="error">Passwords different</div><?php endif; ?>
        <input <?php if ($args["error_password"]) : ?> class="incorrect-field" <?php endif; ?>  type="password" name="password"/>
        
        <p>Password again</p>
        <input <?php if ($args["error_password"]) : ?> class="incorrect-field" <?php endif; ?>  type="password" name="password_again"/>
        <br /><div class="g-recaptcha" data-sitekey="<?= $client_secret ?>" data-callback="enableBtn"></div>
        <br/><input class="btn btn-success"type="submit" value="Register" id="submit_button" disabled="disabled"/>
    </form>
    <a href="/"><input type="button" class="btn btn-primary" value="Back" /></a>
    <script src='https://www.google.com/recaptcha/api.js'></script>
<?php
}

?>
