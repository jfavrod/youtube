<?php
namespace Epoque\YouTube;

use Epoque\YouTube\Daemon;


class Video
{
    public $id          = -1;
    public $title       = '';
    public $description = '';
    public $embedHtml   = '';

    public function __construct($snippet)
    {
        $this->id = $snippet->resourceId->videoId;
        $this->title = $snippet->title;
        $this->description = $snippet->description;

        $query = Daemon::$config['url'].'/videos?part=player&id='.$this->id.'&key='.Daemon::$config['key'];
        $this->embedHtml = json_decode(file_get_contents($query))->items[0]->player->embedHtml;
    }
}

