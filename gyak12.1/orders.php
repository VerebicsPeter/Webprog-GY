<?php
require_once "classes/order.php";
session_start();
$repository = new OrderRepository();
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
    <table>
        <thead>
            <tr>
                <th>Név</th>
                <th>Cím</th>
                <th>Termékek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($repository->all() as $order) {?>
            <tr>
                <td><?=$order->name?></td>
                <td><?=$order->address?></td>
                <td><?=implode(", ", $order->products)?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</body>

</html>