<?php
include "classes/product.php";
include "classes/order.php";

$product_repository = new ProductRepository();
$order_repository = new OrderRepository();

if (count($_GET) != 0) {
    $products = $product_repository->getProductsByCategory($_GET["category"]);
} else {
    $products = $product_repository->all();
}

if (count($_POST) != 0 && !empty($_POST["name"]) && !empty($_POST["address"]) && !empty($_POST["products"])) {
    $order_repository->add(new Order($_POST["name"], $_POST["address"], $_POST["products"]));
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
        <br><br>
        <label for="name">Név: </label>
        <input id="name" name="name" type="text"><br>
        <label for="address">Cím: </label>
        <input id="address" name="address" type="text"><br>
        <button type="submit">Megrendelés</button>
    </form>
    <br><br>
    <a href="orders.php">Megrendelések</a>
</body>

</html>