<?php
require_once "classes/product.php";
require_once "classes/order.php";
require_once "classes/auth.php";
session_start();
$auth = new Auth();
if (!$auth->is_authenticated()) {
    header('Location: login.php');
    die();
}
$order_repository = new OrderRepository();
function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== "");
}
function validate($input, &$errors)
{
    if (is_empty($input, "name") ||
        is_empty($input, "address")) {
        $errors[] = "Az adatok megadása kötelező";
    }

    return !(bool) $errors;
}

$errors = [];
if (isset($_SESSION["products"]) && count($_SESSION["products"]) != 0) {
    if (validate($_POST, $errors)) {
        $order_repository->add(new Order($_POST["name"], $_POST["address"], $_SESSION["products"]));
        unset($_SESSION["products"]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php require_once "cart.php"?>

    <?php if ($errors) {?>
    <ul>
        <?php foreach ($errors as $error) {?>
        <li><?=$error?></li>
        <?php }?>
    </ul>
    <?php }?>

    <form action="" method="post">
        <label for="name">Név: </label>
        <input id="name" name="name" type="text"><br>
        <label for="address">Cím: </label>
        <input id="address" name="address" type="text"><br>
        <button type="submit">Megrendelés</button>
    </form>

    <a href="orders.php">Megrendelések</a>
</body>

</html>