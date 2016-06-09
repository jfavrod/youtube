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


    /**
     * playlistVideos
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

        $query = self::$url.'/playlistItems?part=snippet&playlistId=' .
            $playlistId.'&key='.self::$key;

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
}

