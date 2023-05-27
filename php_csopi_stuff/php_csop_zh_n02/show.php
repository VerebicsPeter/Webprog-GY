<?php 

if (isset($_GET['id'])){
    $id = $_GET['id'];
    $data = json_decode(file_get_contents('3.json'), true);
    if (isset($data[$id])){
        $r = $data[$id];
    } else header('location: 3.php');
} else header('location: 3.php');

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>3. feladat</title>
</head>
<body>
    <!-- Ez két oldal egyben, ezek közül egyszerre csak az egyiket kell
    megjeleníteni, vagy akár ki is lehet szervezni külön fájlokba! -->
    
    <h1>Cím részletei</h1>
    <form action="" method="post">
        <b>Azonosító:</b> <?= $r["id"] ?> <br>
        <b>Cím:</b> <?= $r["address"] ?> <br>
        <b>Megjegyzés:</b> <?= $r["notes"] ?> <br>
        <textarea name="notes" cols="60" rows="4"></textarea> <br>
        <button type="submit">Mentés</button>
    </form>
</body>
</html>