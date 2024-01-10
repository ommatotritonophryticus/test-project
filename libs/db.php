<?php

require __DIR__."/utils.php";

$dbFile = "db.sqlite3";

$db = new SQLite3($dbFile);

$db->exec('
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY,
        username TEXT,
        email TEXT,
        phone TEXT,
        password TEXT
    );');
$db->exec('
    CREATE TABLE IF NOT EXISTS session (
        id INTEGER PRIMARY KEY,
        unique_id TEXT,
        user INTEGER,
        date_to_live TEXT,
        active INTEGER DEFAULT 1
    );');

function db_create_session(int $user_id)
{
    global $db;
    $id = uniqid();
    $db->exec('
        INSERT INTO session ("user", "date_to_live", "unique_id") VALUES
            ('.$user_id.', DATETIME("now", "+2 hours"), "'.uniqid().'")
    ');
}

function db_get_active_sessions(int $user_id)
{
    global $db;
    return $db->querySingle('
        SELECT unique_id FROM session
        WHERE 
            '.$user_id.' == user AND
            date_to_live >= DATETIME("now") AND
            active = 1
    ');
}

function db_username_exist_test(string $username) 
{
    
    global $db;
    $result = $db->querySingle(
        "SELECT COUNT(*) FROM users WHERE 
            username LIKE '".$username."'"
    );
    return $result != 0;
}

function db_email_exist_test(string $email) 
{
    
    global $db;
    $result = $db->querySingle(
        "SELECT COUNT(*) FROM users WHERE 
            email LIKE '".$email."'"
    );
    return $result != 0;
}

function db_phone_exist_test(string $phone) 
{
    
    global $db;
    $result = $db->querySingle(
        "SELECT COUNT(*) FROM users WHERE 
            phone LIKE '".$phone."';"
    );
    return $result != 0;
}

function db_user_data_corrent_test 
(
    string $username, 
    string $email,
    string $phone)
    {
        $errors = [];
        if(db_username_exist_test($username)) {
            $errors["username"] = true;
        }
        if (db_email_exist_test($email)) {
            $errors["email"] = true;
        }
        if (db_phone_exist_test($phone)) {
            $errors["phone"] = true;
        }
        return $errors;
}

function db_create_user(
    string $username, 
    string $email,
    string $phone,
    string $password) 
    {
        global $db;
        $request = '
            INSERT INTO "users" ("username", "email", "phone", "password") VALUES (
                "'.$username.'",
                "'.$email.'",
                "'.$phone.'",
                "'.$password.'");';
        $db->query($request);
}


function db_login_test(string $login, string $password) 
{
    global $db;
    $result = $db->querySingle('
        SELECT COUNT(*) FROM users WHERE
            ("phone" LIKE "'.$login.'" OR "email" LIKE "'.$login.'") AND
            "password" LIKE "'.$password.'";
    ');
    return $result == 1;
}

function db_get_user_id_about_login(string $login) 
{
    global $db;
    $result = $db->querySingle('
    SELECT "id" FROM users WHERE
        "phone" LIKE "'.$login.'" OR "email" LIKE "'.$login.'"
    ');
    return $result;
}

function db_get_user_info(string $session_id)
{
    global $db;
    $result = [];
    $query = $db->query('
        SELECT users.id, users.username, users.email, users.phone FROM session
        INNER JOIN users
            ON session.user = users.id 
        WHERE 
            session.unique_id = "'.$session_id.'"
    ');
    while ($row = $query->fetchArray())
    {
        $result['username'] = $row["username"];
        $result['email'] = $row['email'];
        $result['phone'] = $row['phone'];
        $result['id'] = $row['id'];
    }
    return $result;
}

function db_username_without_user_exist_test(int $user_id, string $username)
{
    global $db;
    $result = $db->querySingle('
        SELECT COUNT(*) FROM users WHERE
            username = "'.$username.'" AND
            id != '.$user_id.'
    ');
    return $result != 0;
}

function db_email_without_user_exist_test(int $user_id, string $email)
{
    global $db;
    $result = $db->querySingle('
        SELECT COUNT(*) FROM users WHERE
            email = "'.$email.'" AND
            id != '.$user_id.'
    ');
    return $result != 0;
}

function db_phone_without_user_exist_test(int $user_id, string $phone)
{
    global $db;
    $result = $db->querySingle('
        SELECT COUNT(*) FROM users WHERE
            phone = "'.$phone.'" AND
            id != '.$user_id.'
    ');
    return $result != 0;
}

function db_new_user_data_corrent_test 
(
    int $user_id,
    string $username, 
    string $email,
    string $phone)
    {
        $errors = [];
        if(db_username_without_user_exist_test($user_id, $username)) {
            $errors["username"] = true;
        }
        if (db_email_without_user_exist_test($user_id, $email)) {
            $errors["email"] = true;
        }
        if (db_phone_without_user_exist_test($user_id, $phone)) {
            $errors["phone"] = true;
        }
        return $errors;
}


function db_change_username(int $user_id, string $username)
{
    global $db;
    $db->exec('
        UPDATE users SET 
            "username" = "'.$username.'"
        WHERE
            "id" = '.$user_id.'
    ');
}

function db_change_email(int $user_id, string $email)
{
    global $db;
    $db->exec('
        UPDATE users SET 
            "email" = "'.$email.'"
        WHERE
            "id" = '.$user_id.'
    ');
}

function db_change_phone(int $user_id, string $phone)
{
    global $db;
    $db->exec('
        UPDATE users SET 
            "phone" = "'.$phone.'"
        WHERE
            "id" = '.$user_id.'
    ');
}

function db_change_password(int $user_id, string $password)
{
    global $db;
    $db->exec('
        UPDATE users SET 
            "password" = "'.$password.'"
        WHERE
            "id" = '.$user_id.'
    ');
}


?>

