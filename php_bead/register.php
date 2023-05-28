<?php
require_once "classes/auth.php";

$auth = new Auth();

function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== "");
}
function validate($input, &$errors, $auth)
{
    if (is_empty($input, "username")) {
        $errors[] = "No username entered!";
    }
    if (is_empty($input, "password")) {
        $errors[] = "No password entered!";
    }
    if (is_empty($input, "email")) {
        $errors[] = "No email entered!";
    }
    if (count($errors) == 0) {
        if ($auth->user_exists($input['username'])) {
            $errors[] = "Username already taken!";
        }
    }

    return !(bool) $errors;
}

$errors = [];
if (count($_POST) != 0) {
    if (validate($_POST, $errors, $auth)) {
        $auth->register($_POST);
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--Bootstrap-5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listify - Registration</title>
</head>

<body>
    <h2>Registration</h2>
    <?php if ($errors) {?>
    <ul>
        <?php foreach ($errors as $error) {?>
        <li><?=$error?></li>
        <?php }?>
    </ul>
    <?php }?>
    <form action="" method="post" novalidate>
        <label for="username"><span style="color: red;">*</span>Username:</label><br>
        <input id="username" name="username" type="text"><br>

        <label for="password"><span style="color: red;">*</span>Password:</label><br>
        <input id="password" name="password" type="password"><br>

        <label for="email"><span style="color: red;">*</span>Email address:</label><br>
        <input id="email" name="email" type="email"><br>

        <input style="margin: 10px 0px 10px 0px;" type="submit" value="Register">
    </form>
    <a href="login.php">Login</a>
</body>
</html>