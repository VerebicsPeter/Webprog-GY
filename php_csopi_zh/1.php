<?php

/*
Készítsünk egy autó adatainak megadására alkalmas űrlapot!
    Legyenek mezők az autó rendszámához, színéhez, gyártójához és gyártási évéhez 0.5 pont
    Írjunk hibaüzeneket egy listába az űrlap felett az alábbi esetekben:
        Ha nincs minden mező megadva 1 pont
        Ha évnek nem négyjegyű szám van megadva 1 pont
    Hiba esetén legyen az űrlap állapottartó, jó bemenet esetén ne legyen 1 pont
*/

include_once "car.php";
include_once "2.php";

function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== "");
}

function validate($input, &$data, &$errors)
{
    $data["plate"] = null;
    $data["color"] = null;
    $data["brand"] = null; $data["year"] = null;

    if (is_empty($input, "plate") ||
        is_empty($input, "brand") ||
        is_empty($input, "color") ||
        is_empty($input, "year")) {
        $errors[] = "Az értékek megadása kötelező!";
    } 
    else if (strlen($input["year"]) !== 4 || !is_numeric($input["year"])) {
        $errors[] = "Évszámot kell megadni!";
    }
    else {
        $data["plate"] = $input["plate"];
        $data["color"] = $input["color"];
        $data["brand"] = $input["brand"];
        $data["year"] = (int) $input["year"];
    }
    return !(bool) $errors;
}

$errors = []; $data = [];
$input = $_POST;

if (count($_POST) !== 0) {
    if (validate($input, $data, $errors)) {
        // input
        $plate = $data["plate"];
        $color = $data["color"];
        $brand = $data["brand"];
        $year = $data["year"];

        $repository->add(new Car($plate, $color, $brand, $year));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feladat 1</title>
</head>
<body>
    <?php if ($errors): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
        <li><?=$error?></li>
        <?php endforeach;?>
    </ul>
    <?php endif;?>

    <form action="" method="post">
        <label for="plate">License plate:</label>
        <input type="text" name="plate" value="<?=isset($_POST["plate"]) ? $_POST["plate"] : ""?>"> <br>
        <label for="color">Color:</label>
        <input type="text" name="color" value="<?=isset($_POST["color"]) ? $_POST["color"] : ""?>"> <br>
        <label for="brand">Brand:</label>
        <input type="text" name="brand" value="<?=isset($_POST["brand"]) ? $_POST["brand"] : ""?>"> <br>
        <label for="year">Year:</label>
        <input type="text" name="year" value="<?=isset($_POST["year"]) ? $_POST["year"] : ""?>"> <br>
        <button type="submit">Submit</button>
    </form>
    <a href="3.php">View cars</a>

    <?php 
    if (isset($year)) {
        echo "plate: " . $plate;
        echo ", color: " . $color;
        echo ", brand: " . $brand;
        echo ", year: "  . $year;
    }
    ?>

</body>
</html>