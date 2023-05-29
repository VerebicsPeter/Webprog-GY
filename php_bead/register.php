<?php
require_once "classes/auth.php";

$auth = new Auth();

function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== "");
}
function validate($input, &$errors, $auth)
{   // check if everything is entered
    if (is_empty($input, "username")) {
        $errors[] = "No username entered!";
    }
    if (is_empty($input, "password")) {
        $errors[] = "No password entered!";
    }
    if (is_empty($input, "password_repeat")) {
        $errors[] = "Password was not repeated!";
    }
    if (is_empty($input, "email")) {
        $errors[] = "No email entered!";
    }
    // check if the email is valid
    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format!";
    }
    // check if passwords match
    if ($input['password'] !== $input['password_repeat']) {
        $errors[] = "Passwords do not match!";
    }
    // check if username already exist
    if (count($errors) == 0) {
        if ($auth->user_exists($input['username']))
            $errors[] = "Username already taken!";
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
    <section id="registration" class="container">
    <h2>Registration</h2>
    <?php if ($errors) {?>
    <ul>
        <?php foreach ($errors as $error) {?>
        <li><?=$error?></li>
        <?php }?>
    </ul>
    <?php }?>
    <form action="" method="post" novalidate>
        <label for="username"><span>*</span>Username:</label><br>
        <input id="username" name="username" type="text"
        value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"><br>

        <label for="password"><span>*</span>Password:</label><br>
        <input id="password" name="password" type="password"><br>

        <label for="password-repeat"><span>*</span>Repeat password:</label><br>
        <input id="password-repeat" name="password_repeat" type="password"><br>

        <label for="email"><span>*</span>Email address:</label><br>
        <input id="email" name="email" type="email"
        value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"><br>

        <input class="mt-1 btn btn-sm btn-primary" type="submit" value="Register">
    </form>
    </section>
    
    <hr>

    <section id="navlinks" class="container">
        <a href="login.php" class="m-2">Login</a>
    </section>

    <hr>
</body>
</html>
