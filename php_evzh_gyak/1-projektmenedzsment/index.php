<?php
    $data = [
        ["name" => "Dr. Programo Zoltán", "color" => "#517d81", "schedule" => [9 => 2, 12 => 4]],
        ["name" => "Koaxk Ábel", "color" => "orange", "schedule" => [11 => 1, 13 => 3]],
        ["name" => "Locsolók Anna", "color" => "red", "schedule" => []],
        ["name" => "Trap Pista", "color" => "navy", "schedule" => [10 => 4, 15 => 2]],
        ["name" => "Wincs Eszter", "color" => "hotpink", "schedule" => [9 => 2, 12 => 3, 15 => 1]],
        ["name" => "Zsíros B. Ödön", "color" => "greenyellow", "schedule" => [9 => 8]]
    ];

    $total_hours = 0;

    foreach ($data as $worker){
        if (isset($worker['schedule'])){
        foreach ( $worker['schedule'] as $value){
            $total_hours += $value;
        }}
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Projektmenedzsment</title>
</head>
<body>
    <h1>Projektmenedzsment</h1>
    <table>
        <thead>
        <tr>
            <th>Név</th>
            <!-- órák -->
            <?php for ($x = 9; $x <=16; $x++):?>
                <th><?php echo $x.":00"; ?></th>
            <?php endfor; ?>
        </tr>
        </thead>
        <tbody>
            <!-- egy sor minden alkalmazottra -->
            <?php foreach ($data as $worker): ?>
                <tr>
                    <td><?php echo $worker['name'] ?></td>
                    <?php $i = 9; while($i <= 16): ?>
                        <?php if (isset($worker['schedule'][$i])): ?>
                            <td colspan="<?php echo $worker['schedule'][$i] ?>" style="background-color: <?php echo $worker['color'] ?>">
                            </td>
                            <?php $i += $worker['schedule'][$i] ?>
                        <?php else : ?>
                            <td></td>
                            <?php $i++ ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <b>Összes munkaóra: </b> <?php echo $total_hours ?> óra
</body>
</html>
