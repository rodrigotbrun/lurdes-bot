<?php

/*
 * Copyright 2017 Aaron Scherer
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE
 *
 * @package     restcord/restcord
 * @copyright   Aaron Scherer 2017
 * @license     MIT
 */

namespace RestCord\Mock;

/**
 * Oauth2 Intellisense Helper.
 */
interface Oauth2
{
    /**
     * @param array $options []
     *
     * @return array Returns the bot's OAuth2 application info.
     */
    public function getCurrentApplicationInformation(array $options);
}
