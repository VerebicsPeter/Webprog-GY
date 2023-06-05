<?php

require_once "classes/auth.php";
require_once "classes/user.php";
require_once "classes/track.php";
require_once "classes/playlist.php";


session_start();
$auth = new Auth();

if (!($auth->is_authenticated() && $auth->is_admin())) {
    header('Location: index.php'); die();
}

$track_repository = new TrackRepository();
$plist_repository = new PlaylistRepository();

$id = $_GET['id'] ?? "";

if (count($_GET) != 0) {
    if ($id != "") {
        $track = $track_repository->get_track_by_id($id);

        if (!isset($track)) {header('Location: edittracks.php'); die();}
        
        $plist_repository->remove_track($track);

        $track_repository->delete_track_by($track->_id);

        header("Location: edittracks.php");
    } 
    else {
        header("Location: edittracks.php");
    }
}

?>