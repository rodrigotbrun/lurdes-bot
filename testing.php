<?php

use LurdesBot\Music\Youtube\Entity\QueueItem;

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/bot/Module/Music/Youtube/lib-download/yt_downloader.php';

$next = QueueItem::orderBy('created_at', 'ASC')->first()->track()->first();
$file = new \yt_downloader('http://www.youtube.com/watch?v=R_AlPm6dG1w', TRUE, 'audio');

