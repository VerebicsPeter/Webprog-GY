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
        header('Location: index.php');
        die();
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
    <title>Listify - Login</title>
</head>

<body>
    <section id="login" class="container">
    <h2>Login</h2>
    <div class="row">
        <div class="col-3">
        <form action="" method="post" novalidate>
            <label for="username">Username:</label><br>
            <input id="username" name="username" value="<?= $_POST['username'] ?? "" ?>" type="text"><br>
            <label for="password">Password:</label><br>
            <input id="password" name="password" type="password"><br>
            <input class="mt-2 btn btn-sm btn-primary" type="submit" value="Log in">
        </form>  
        </div>
        <div class="col-9">
        <?php if ($errors) {?>
        <ul>
            <?php foreach ($errors as $error) {?>
            <li><?=$error?></li>
            <?php }?>
        </ul>
        <?php }?>
        </div>
    </div>
    </section>

    <hr>

    <section id="navlinks" class="container">
        <a href="index.php" class="m-2">Home</a>
        <a href="signup.php" class="m-2">Sign up</a>
    </section>
    
    <hr>
</body>
</html>
