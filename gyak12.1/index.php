<?php
require_once "classes/product.php";

session_start();

$repository = new ProductRepository();
$categories = ["Étel", "Ital", "Ruha"];
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
    <ul>
        <?php
foreach ($categories as $c) {
    echo "<li><a href=\"products.php?category=" . $c . "\">" . $c . "</a></li>";
}
?>
    </ul>

    <?php require_once "cart.php"?>
</body>

</html>