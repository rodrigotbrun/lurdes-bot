<?php

require_once __DIR__ . '/bootstrap.php';

$q = \LurdesBot\Music\Youtube\Entity\QueueItem::first();

var_dump($q->toArray());