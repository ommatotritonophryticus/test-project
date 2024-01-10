<?php

function get_title() {
    return "Auth";
}


function get_content($args) {
?>
    <h1 class="title">User data change</h1>
    <form method="POST">
        <p>Username</p>
        <?php if ($args["error_username"]) : ?><div class="error">Incorrect username</div><?php endif; ?>
        <input type="text" <?php if ($args["error_username"]) : ?> class="incorrect-field" <?php endif; ?>  type="text" name="username" value="<?= $args["username"] ?>"/>
        
        <p>Email</p>
        <?php if ($args["error_email"]) : ?><div class="error">Incorrect email</div><?php endif; ?>
        <input type="text" <?php if ($args["error_email"]) : ?> class="incorrect-field" <?php endif; ?>  type="text" name="email" value="<?= $args["email"] ?>"/>
        
        <p>Phone (format "+7XXXXXXXXXX")</p>
        <?php if ($args["error_phone"]) : ?><div class="error">Incorrect phone</div><?php endif; ?>
        <input type="text" <?php if ($args["error_phone"]) : ?> class="incorrect-field" <?php endif; ?>  type="text" name="phone" placeholder="+7XXXXXXXXXX" value="<?= $args["phone"] ?>"/>
        
        <p>Password</p>
        <?php if ($args["error_password"]) : ?><div class="error">Passwords different</div><?php endif; ?>
        <input type="password" <?php if ($args["error_password"]) : ?> class="incorrect-field" <?php endif; ?>  type="password" name="password"/>
        
        <p>Password again</p>
        <input type="password" <?php if ($args["error_password"]) : ?> class="incorrect-field" <?php endif; ?>  type="password" name="password_again"/>
        <br />
        <input class="btn btn-success" type="submit" value="Change" />
        <br />
        <a href="/logout.php"><input type="button" class="btn btn-danger" value="Logout" /></a>
    </form>
<?php
}
?>
