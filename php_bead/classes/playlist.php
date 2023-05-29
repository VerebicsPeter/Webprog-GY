<?php
require_once "jsonstorage.php";
require_once "track.php";
class Playlist
{
    public $_id = null;
    public $name;
    public $creator;
    public $public;
    public $tracks;

    public function __construct($name = null, $creator = null, $public = null, $tracks = null)
    {
        $this->name = $name;
        $this->creator = $creator;
        $this->public = $public;
        $this->tracks = $tracks;
    }

    public static function from_array(array $arr): Playlist
    {
        $instance = new Playlist();
        $instance->_id = $arr['_id'] ?? null;
        $instance->name = $arr['name'] ?? null;
        $instance->creator = $arr['creator'] ?? null;
        $instance->tracks = $arr['tracks'] ?? null;
        $instance->public = $arr['public'] ?? null;
        return $instance;
    }

    public static function from_object(object $obj): Playlist
    {
        return self::from_array((array) $obj);
    }
}

class PlaylistRepository
{
    private $storage;
    public function __construct()
    {
        $this->storage = new JsonStorage('data/playlists.json');
    }
    private function convert(array $arr): array
    {
        return array_map([Playlist::class, 'from_object'], $arr);
    }
    public function all()
    {
        return $this->convert($this->storage->all());
    }
    public function add(Playlist $playlist): string
    {
        return $this->storage->insert($playlist);
    }
    public function update_tracks(Playlist $playlist, array $tracks)
    {
        $this->storage->update(
            function ($p) use ($playlist) {return $p->_id === $playlist->_id;}, // match by id
            function ($p) use ($tracks) {$p->tracks = $tracks;}                 // set the tracks
        );
    }
    public function get_playlist_by_id(string $id = null) : Playlist
    {
        $result = $this->all()[$id];
        if (isset($result)) return $result;
        return null;
    }
}
?>