<?php

namespace LurdesBot\Music\Youtube;

class YoutubeAPI {

    public static function videoIdFromUrl($url) {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
        return $matches[1];
    }

}