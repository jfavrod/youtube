<?php
namespace Epoque\YouTube;

use Epoque\YouTube\Video;


/**
 * Daemon
 * 
 * The static master class for working with the YouTube API.
 */

class Daemon
{    
    private static $defaults = [
        'url' => 'https://www.googleapis.com/youtube/v3',
        "key" => '',
        'channelId' => ''
    ];

    public static $config = [];


    /**
     * init
     * 
     * (Re)initalize the Daemon class.
     * 
     * @param assoc_array $spec Key value pairs for setting the Daemon
     * class data members.
     */

    public static function init($spec=[])
    {
        foreach (self::$defaults as $dkey => $dval) {
            self::$config[$dkey] = $dval;
        }
        
        foreach ($spec as $skey => $sval) {
            if (array_key_exists($skey, self::$config)) {
                self::$config[$skey] = $sval;
            }
        }
    }


    /**
     * playlistVideos
     *
     * Grabs the videos from a given YouTube playlist.
     * 
     * @param string $playlistId The id of the YouTube playlist.
     * @param int $count (Optional) The number of items to grab; all
     * if not given.
     *
     * @return array An array containing YouTubeVideo Objects
     * representing the items in the YouTube playlist; empty on fail.
     */

    public static function playlistVideos($playlistId, $count=0)
    {
        $videos = [];
        $totalVideos = 0;

        $query = self::$config['url'].'/playlistItems?part=snippet&playlistId=' .
            $playlistId.'&key='.self::$config['key'];

        if ($count > 0) {
            $totalVideos =
                json_decode(file_get_contents($query))->pageInfo->totalResults;

            if ($count <= $totalVideos) {
                $query .= '&maxResults='.$count;
            }
        }

        $query .= '&fields=items';
        
        foreach (json_decode(file_get_contents($query))->items as $playlistItem) {
            array_push($videos, new Video($playlistItem->snippet));
        }

        return $videos;
    }


    public function __toString()
    {
        $string = "YouTube Daemon {\n";
        
        foreach (self::$config as $ckey => $cval) {
            $string .= "    $ckey: $cval\n";
        }
        
        $string .= "}\n";
        
        return $string;
    }
}

