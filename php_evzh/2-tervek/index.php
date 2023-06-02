<?php

$imperial_plans = [
    [
        'codename' => 'Stellarsphere',
        'engineer' => 'Makey Muse',
        'time' => 10,
        'priority' => 'standard'
    ],
    [
        'codename' => 'Mark Omega',
        'engineer' => 'Jamer Bando',
        'time' => 5,
        'priority' => 'important'
    ],
    [
        'codename' => 'Stellaris',
        'engineer' => 'Galen Erso',
        'time' => 30,
        'priority' => 'important'
    ],
    [
        'codename' => 'Pax Aurora',
        'engineer' => 'Tino Sartk',
        'time' => 5,
        'priority' => 'backlog'
    ],
    [
        'codename' => 'War-Mantle',
        'engineer' => 'Jono Snuv',
        'time' => 20,
        'priority' => 'important'
    ],
    [
        'codename' => 'Stardust',
        'engineer' => 'Galen Erso',
        'time' => 21,
        'priority' => 'important'
    ],
    [
        'codename' => 'EFOP-4.2.3-22',
        'engineer' => 'Lorando Otvys',
        'time' => 10,
        'priority' => 'standard'
    ],
    [
        'codename' => 'Cluster-Prism',
        'engineer' => 'Aerek Kartmah',
        'time' => 15,
        'priority' => 'important'
    ],
    [
        'codename' => 'Not the Death Star, trust me',
        'engineer' => 'Galen Erso',
        'time' => 20,
        'priority' => 'backlog'
    ],
    [
        'codename' => 'Black-Saber',
        'engineer' => 'Shray K',
        'time' => 10,
        'priority' => 'backlog'
    ]
];

// important 🥇
// standard  🥈
// backlog   🥉

function priority(string $priority): int {
    if ($priority === "important") return 1;
    if ($priority === "standard") return 2;
    return 3;
}

function probability($plan) : int {
    if ($plan['engineer'] !== "Galen Erso")
        return 100 - priority($plan['priority']) * (1 + abs(20 - $plan['time']));
    return 0;
}

usort($imperial_plans, function ($plan_a, $plan_b) {
    if (probability($plan_a) === probability($plan_b)) return 0;
    return (probability($plan_a) < probability($plan_b)) ? 1 : -1;
});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/index.css">
    <title>2. feladat - Tervek</title>
</head>
<body>
    <h1>2. feladat - Tervek</h1>
    <div id="introduction">
        <img src="src/character.png">
        <span>Segíts nekem megtalálni<br>a Halálcsillag terveit!</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fedőnév</th>
                <th>Főmérnök</th>
                <th>Idő</th>
                <th>Prioritás</th>
                <th>Valószínűség</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($imperial_plans as $plan):?>
                <tr <?php if ($plan['codename'] === $imperial_plans[0]['codename']) echo 'class="deathstar"'?>>
                    <td><?=$plan['codename']?></td>
                    <td><?=$plan['engineer']?></td>
                    <td>
                        <?php 
                        $n = intdiv($plan['time'], 5);
                        for ($i = 0; $i < $n; $i++) {?>
                            <span class="time"></span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($plan['priority'] === "important"):?>
                            🥇
                        <?php endif; ?>
                        <?php if ($plan['priority'] === "standard"):?>
                            🥈
                        <?php endif; ?>
                        <?php if ($plan['priority'] === "backlog"):?>
                            🥉
                        <?php endif; ?>
                    </td>
                    <td>
                        <?=probability($plan)?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
</body>
</html>
<script src="src/index.js"></script>