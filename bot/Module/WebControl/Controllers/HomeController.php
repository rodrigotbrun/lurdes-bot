<?php

namespace LurdesBot\WebControl\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends Controller {

    /**
     * @param Request $request
     * @param Response $response
     * @param array $arguments
     *
     * @return mixed
     */
    function run(Request $request, Response $response, array $arguments = []) {
        echo 'Lurdes Bot';
    }

}
