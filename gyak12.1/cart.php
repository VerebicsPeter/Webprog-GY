<h2>Kosár: </h2>
<?php 
//var_dump($_SESSION);
?>
<ul>
    <?php if (isset($_SESSION["products"]) && count($_SESSION["products"]) != 0) {
    foreach ($_SESSION["products"] as $p) {?>
    <li><?=$p?></li>
    <?php }}?>
</ul>