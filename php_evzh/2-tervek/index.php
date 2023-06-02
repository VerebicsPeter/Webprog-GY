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
            <tr class="deathstar">
                <td>Példa Projekt 1</td>
                <td>Példa Péter</td>
                <td></span><span class="time"></span><span class="time"></span></td>
                <td>🥇</td>
                <td>98</td>
            </tr>
            <tr>
                <td>Példa Projekt 2</td>
                <td>Példa Gergő</td>
                <td><span class="time"></span><span class="time"></span><span class="time"></span><span class="time"></span></td>
                <td>🥉</td>
                <td>97</td>
            </tr>
        </tbody>
    </table>
    
</body>
</html>
<script src="src/index.js"></script>