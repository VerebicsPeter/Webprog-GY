<?php

$product_id = $_POST["product_id"] ?? "";
$old_price = $_POST["old_price"] ?? "";
$new_price = $_POST["new_price"] ?? "";

$learazas = "";

if(count($_POST) > 0) {
    $errors = [];

    if(trim($product_id) === "")
        $errors["product_id"] = "Termékazonosító kitöltése kötelező!";
    else if(strlen($product_id) != 6)
        $errors["product_id"] = "Termékazonosító kötelezően 6 karakter hosszú kell legyen!";

    if(trim($old_price) === "")
        $errors["old_price"] = "Régi ár kitöltése kötelező!";
    else if(filter_var($old_price, FILTER_VALIDATE_INT) === false)
        $errors["old_price"] = "Régi ár egész szám kell legyen!";
    else if((int)$old_price <= 0)
        $errors["old_price"] = "Régi ár pozitív szám kell legyen!";

    if(trim($new_price) === "")
        $errors["new_price"] = "Új ár kitöltése kötelező!";
    else if(filter_var($new_price, FILTER_VALIDATE_INT) === false)
        $errors["new_price"] = "Új ár egész szám kell legyen!";
    else if((int)$new_price <= 0)
        $errors["new_price"] = "Új ár pozitív szám kell legyen!";
    else if((int)$new_price >= (int)$old_price)
        $errors["new_price"] = "Új ár legyen kisebb a régi árnál!";

    $errors = array_map(fn($e) => "<span style='color: red'>$e</span>", $errors);

    if(count($errors) == 0){
       $learazas = 100 * (((int)$old_price - (int)$new_price) / (int)$old_price);
    }
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>2. feladat</title>
</head>
<body>
    <h1>Leárazáskalkulátor</h1>
    <form action="2.php" method="post" novalidate>
        <label for="product_id">Termékazonosító:</label><input type="text" name="product_id" value="<?= $product_id ?>"> <?= $errors["product_id"] ?? ""?> <br>
        <label for="old_price">Régi ár:</label><input type="text" name="old_price" value="<?= $old_price ?>"> <?= $errors["old_price"] ?? ""?> <br>
        <label for="new_price">Új ár:</label><input type="text" name="new_price" value="<?= $new_price ?>"> <?= $errors["new_price"] ?? ""?> <br>
        <button type="submit">OK</button>
    </form>
    <span>Leárazás: <?= $learazas != "" ? $learazas."%" : ""?> </span>
</body>
</html>
