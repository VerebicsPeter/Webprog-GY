<?php
    require_once "classes/auth.php";
    require_once "classes/user.php";
    require_once "classes/track.php";

    session_start();
    $auth = new Auth();
    if (!$auth->is_authenticated()) {die();}

    $track_repository = new TrackRepository();

    $selected_tracks;
    if (count($_GET) != 0) {
        $category = $_GET['category'] ?? "";
        if ($category === "" || $category === "title")
            $selected_tracks = $track_repository->get_tracks_by_title($_GET['search'] ?? "");
        if ($category === "artist")
            $selected_tracks = $track_repository->get_tracks_by_artist($_GET['search'] ?? "");
        if ($category === "genres")
            $selected_tracks = $track_repository->get_tracks_by_genres($_GET['search'] ?? "");
    }

    if (isset($selected_tracks)) {
        if (count($selected_tracks) === 0)
        echo '<div class="alert alert-info">No results found.</div>';
        else
        {
            echo '<table class="table table-striped table-sm border w-90">
                    <thead>
                    <tr>
                        <th scope="col" class="col-6">Title</th>
                        <th scope="col" class="col-6">Artist</th>
                        <th scope="col" class="col-1">Add</th>
                    </tr>
                    </thead>';
            $arr = $selected_tracks;
            usort($arr, function ($a, $b) {return strcmp($a->title, $b->title);});
            foreach ($arr as $track) {
                echo '<tr>';
                echo '<td>'.$track->title.'</td>';
                echo '<td>'.$track->artist.'</td>';
                echo '<td>';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="tracks[]" value="'.$track->_id.'">';
                echo '<input type="submit" value="Add" class="btn btn-sm btn-primary">';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }
?>