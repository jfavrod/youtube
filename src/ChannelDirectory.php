<?php
namespace Epoque\YouTube;


class ChannelDirectory
{
    private static $channels = [
        'AdamKokesh' => 'UC0RJJ_Wm7jyOU9eY10LgcwA',
        'Jan Helfeld' => 'UCwYtzX-vfZ2krwYqVQHOvSQ',
        'Peter Schiff' => 'UCIjuLiLHdFxYtFmWlbTGQRQ',
        'Stefan Molyneux' => 'UCC3L8QaxqEGUiBC252GHy3w',
        'The Rubin Report' => 'UCJdKr0Bgd_5saZYqLCa9mng',
        'The Young Turks' => 'UC1yBKRuGpC1tSM73A0ZjYjQ',
        'TomWoodsTV' => 'UCsgWR55UyAiFarZYl1u1l9Q'
    ];


    public static function lookup($query)
    {
        if (array_key_exists($query, self::$channels)) {
            return self::$channels[$query];
        }
        else if (in_array($query, self::$channels)) {
            return array_keys(self::$channels, $query);
        }
        else {
            return '';
        }
    }
}

