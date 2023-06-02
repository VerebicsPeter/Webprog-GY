<?php

include_once "classes/vulnerability.php";

$vulnerability_store = new VulnerabilityStorage();

$shortdesc = $_POST['shortdesc'] ?? "";
$longdesc = $_POST['longdesc'] ?? "";
$danger = $_POST['danger'] ?? "";
$image = $_POST['image'] ?? "";

if (count($_POST) > 0)
{
    $vulnerability_store->add(new Vulnerability($shortdesc, $longdesc, $danger, $image));
    header('Location: index.php');
}

?>