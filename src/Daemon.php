<?php
namespace Epoque\YouTube;

use Epoque\YouTube\Video;


class Daemon
{
    public static $url = 'https://www.googleapis.com/youtube/v3';
    public static $key;
    public static $channelId;


    public static function init($spec=[])
    {
        if (array_key_exists('url', $spec)) {
            self::$url = $spec['url'];
        }

        if (array_key_exists('key', $spec)) {
            self::$key = $spec['key'];
        }

        if (array_key_exists('channelId', $spec)) {
            self:$channelId = $spec['channelId'];
        }
    }


    public static function playlistVideos($playlistId)
    {
        $videos = [];

        $query    = self::$url.'/playlistItems?part=snippet&playlistId=' .
            $playlistId.'&fields=items&key='.self::$key;
        
        foreach (json_decode(file_get_contents($query))->items as $playlistItem) {
            array_push($videos, new Video($playlistItem->snippet));
        }

        return $videos;
    }
}

