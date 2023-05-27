<?php
require_once "classes/product.php";
require_once "classes/order.php";
session_start();
$product_repository = new ProductRepository();
$order_repository = new OrderRepository();

if (count($_GET) != 0) {
    $products = $product_repository->getProductsByCategory($_GET["category"]);
} else {
    $products = $product_repository->all();
}

if (count($_POST) != 0) {
    if (!isset($_SESSION["products"])) {
        $_SESSION["products"] = $_POST["products"];
    } else {
        array_push($_SESSION["products"], ...$_POST["products"]); //spread operator
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
    <h2><?=$_GET["category"] ?? "Összes"?></h2>

    <form action="" method="post">

        <?php
$i = 0;
foreach ($products as $p) {
    echo '<input type="checkbox" id="' . $i . '" name="products[]" value="' . $p->name . '">';
    echo '<label for="' . $i . '">' . $p->name . '</label><br>';
    $i++;
}
?>
        <button type="submit">Kosárba tesz</button>
    </form>

    <?php require_once "cart.php"?>

    <a href="makeorder.php">Kosár megrendelése</a> <br>
    <a href="orders.php">Megrendelések</a>
</body>

</html>