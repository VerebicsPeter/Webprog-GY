<?php
require_once "classes/auth.php";

session_start();
$auth = new Auth();

function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== "");
}

function validate($input, &$errors, $auth)
{
    if (is_empty($input, "username")) {
        $errors[] = "You must enter your username!";
    }
    if (is_empty($input, "password")) {
        $errors[] = "You must enter your password!";
    }
    if (count($errors) == 0) {
        if (!$auth->check_credentials($input['username'], $input['password'])) {
            $errors[] = "Incorrect password or username!";
        }
    }

    return !(bool) $errors;
}

$errors = [];
if (count($_POST) != 0) {
    if (validate($_POST, $errors, $auth)) {
        $auth->login($_POST);
        header('Location: createpost.php');
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php if ($errors) {?>
    <ul>
        <?php foreach ($errors as $error) {?>
        <li><?=$error?></li>
        <?php }?>
    </ul>
    <?php }?>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input id="username" name="username" type="text"><br>
        <label for="password">Password:</label><br>
        <input id="password" name="password" type="password"><br>
        <input style="margin: 10px 0px 10px 0px;" type="submit" value="Login">
    </form>
    <a href="register.php">Register</a>
</body>
</html>
