<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php
    if(isset($_GET["name"]))
        $name = $_GET["name"];
    else   
        $name = "";    
?>

<body>
    <form action="" method="get">
        <label for="name">Name: </label>
        <input type="text" name="name" value="<?=$name?>">
        <button type="submit">Send</button>
    </form>

<?php
    if(!empty($name))
        echo "Hello $name!" . " Hossz: " . strlen($_GET["name"]);
?>

</body>

</html>