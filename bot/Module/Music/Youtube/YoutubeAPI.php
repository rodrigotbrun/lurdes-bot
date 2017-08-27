<?php

namespace LurdesBot\Music\Youtube;

use Madcoda\Youtube\Youtube;

class YoutubeAPI extends Youtube {

    /**
     * YoutubeAPI constructor.
     */
    public function __construct() {
        parent::__construct([
           'key' => CONFIG['google_api_key']
        ]);
    }

    public static function videoIdFromUrl($url) {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
        return $matches[1];
    }

}