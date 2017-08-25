<?php

namespace LurdesBot\WebControl\Controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class Controller {

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var array */
    protected $arguments;

    /** @var Container */
    protected $ci;

    /**
     * Controller constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container) {
        $this->ci = $container;
    }

    /**
     * @param $req Request
     * @param $res Response
     * @param $args array
     */
    public function __invoke($req, $res, $args) {
        $this->request = $req;
        $this->response = $res;
        $this->arguments = $args;
        $this->run($req, $res, $args);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $arguments
     *
     * @return mixed
     */
    abstract function run(Request $request, Response $response, array $arguments = []);

    /**
     * @param $view string
     */
    protected function view($view) {
        // TODO
    }

}