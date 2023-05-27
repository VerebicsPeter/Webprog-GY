<?php

/*
Készítsünk egy másik oldalt, ahol megtekinhetjük az autókat! Legyen egy ide vezető link az űrlap alatt!
    Generáljunk egy táblázatot, amelynek egyes soraiban az autók adatait jelenítjük meg az előzőleg betöltött tömb alapján 1.5 pont
    Legyen a táblázat felett egy állapottartó űrlap egyetlen szöveges mezővel, ahova beírhatunk egy gyártót 1 pont
    Beadáskor frissítsük a táblázatot, hogy csak a kiválaszott márkájú autókat mutassa, vagy üres szöveges mező esetén az összeset. 1.5 pont
*/

include_once "car.php";
include_once "2.php";

if (count($_GET) != 0) {
    $cars = $repository->getCarsByBrand($_GET["brand"]);
} else {
    $cars = $repository->all();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feladat 3</title>
</head>

<body>
    <form action="" method="get">
        <label for="brand">Brand:</label>
        <input type="text" name="brand" value="<?=isset($_GET["brand"]) ? $_GET["brand"] : "" ?>"> <br>
        <button type="submit">Filter</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>License Plate</th>
                <th>Color</th>
                <th>Brand</th>
                <th>Year</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cars as $car) {?>
            <tr>
                <td><?=$car->plate?></td>
                <td><?=$car->color?></td>
                <td><?=$car->brand?></td>
                <td><?=$car->year?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</body>
