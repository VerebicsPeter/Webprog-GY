<?php
function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== ""); //üres -e még úgyis, hogy levágjuk trimmel mindenféle spaceket, elől-hátul \n\t stb.
}
function validate($input, &$data, &$errors)
{
    $data["a"] = null;
    $data["b"] = null;
    if (is_empty($input, "a") || is_empty($input, "b")) {
        $errors[] = "Az értékek megadása kötelező";
    } 
    else if (!is_numeric($input["a"]) || !is_numeric($input["b"])) {
        $errors[] = "Számokat kell megadni";
    } 
    else if($input["a"] == 0){
        $errors[] = "Az a nem lehet 0";
    }
    else {
        $data["a"] = (int) $input["a"];
        $data["b"] = (int) $input["b"];
    }
    //var_dump(!(bool)$errors);
    return !(bool) $errors;
}

$errors = [];
$data = [];
$input = $_GET;

// validate
if (count($_GET) !== 0) {
    if (validate($input, $data, $errors)) {

        // input
        $a = $data["a"];
        $b = $data["b"];

        // processing
        $x = -$b / $a;
    }
}

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
    <?php if ($errors): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
        <li><?=$error?></li>
        <?php endforeach;?>
    </ul>
    <?php endif;?>

    <form action="" method="get">
        <label for="a">a: </label>
        <input type="text" name="a" value="<?=isset($_GET["a"]) ? $_GET["a"] : 0?>">
        <label for="b">b: </label>
        <input type="text" name="b" value="<?=isset($_GET["b"]) ? $_GET["b"] : 0?>">
        <button type="submit">Send</button>
    </form>

    <?php 
    if (isset($x)) {
        echo "X = " . $x;
    }
    ?>

</body>

</html>