<?php
    $products = [
        ['name' => 'Asus TUF 144 Hz IPS gamer monitor', 'price' => 67990, 'amount' => 348],
        ['name' => 'Electrolux PerfectCare elöltöltős mosógép', 'price' => 89990, 'amount' => 27],
        ['name' => 'Orion 32-inch HD Ready LED televízió', 'price' => 49990, 'amount' => 245],
        ['name' => 'Canon multifunkciós színes lézernyomtató', 'price' => 77590, 'amount' => 9],
        ['name' => 'Samsung kombinált álló hűtőszekrény', 'price' => 170490, 'amount' => 6],
        ['name' => 'Nestlé csokinyuszi Télapó cosplayben', 'price' => 299, 'amount' => 1250],
        ['name' => 'Kinder meglepetés tojás', 'price' => 499, 'amount' => 970],
        ['name' => 'Lenovo vízálló sport-okosóra', 'price' => 18990, 'amount' => 430],
        ['name' => 'Logitech vezeték nélküli USB billentyűzet', 'price' => 12990, 'amount' => 78]
    ];

    function sum($products){
        $sum = 0;
        foreach($products as $p){
            $sum += $p["price"]*$p["amount"];
        }

        return $sum;
    }

    $sum = sum($products);

    $product = current(array_filter($products, fn($p) => $p["amount"] < 10))["name"];

    function cmp($a, $b)
    {
    if ($a["amount"] == $b["amount"]) {
        return 0;
    }
    return ($a["amount"] < $b["amount"]) ? 1 : -1;
    }

    usort($products, "cmp");
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>1. feladat</title>
</head>
<body>
    <h1>Eladások áttekintése</h1>
    <table>
        <thead>
            <tr>
                <th>Megnevezés</th>
                <th>Darab</th>
                <th>Egységár</th>
                <th>Eladási ár</th>
            </tr>
        </thead>
        <tbody>         
            <?php foreach($products as $p) : ?>
                <tr>
                    <td> <?= $p["name"] ?> </td>                 
                    <td> <?= $p["amount"] ?> </td>
                    <td> <?= $p["price"] ?> Ft </td>
                    <td> <?= $p["price"]*$p["amount"] ?> Ft </td>
                </tr>           
            <?php endforeach; ?>
        </tbody>
    </table>

    <b>Eladási összérték:</b> <?= $sum ?> Ft <br>
    <b>Kevesett eladott termék:</b> <?= $product ?>
</body>
</html>