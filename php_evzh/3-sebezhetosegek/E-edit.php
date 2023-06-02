<?php

include_once "classes/vulnerability.php";

$vulnerability_store = new VulnerabilityStorage();

$vulnerability;
$id = $_POST['id'] ?? "";
$shortdesc = $_POST['shortdesc'] ?? "";
$longdesc = $_POST['longdesc'] ?? "";
$danger = $_POST['danger'] ?? "";
$image = $_POST['image'] ?? "";

if (count($_POST) > 0)
{
    if (isset($id)) {
        $vulnerability = $vulnerability_store->get_by_id($id);
    }
    if (!isset($vulnerability)) header('Location: index.php');
    else {
        $updated = new Vulnerability($shortdesc, $longdesc, $danger, $image);
        $vulnerability_store->update_by_id($id, $updated);
        header('Location: D-details.php?id='.$id);
    }
}

?>