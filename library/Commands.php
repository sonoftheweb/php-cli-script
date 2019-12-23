<?php


namespace Cli;


use Controllers\BaseController;

class Commands
{
    /**
     * @var $registry
     */
    protected $registry = [];

    /**
     * @var $controllers
     */
    protected $controllers = [];

    /**
     * Registers a controller instance
     *
     * @param $command_name
     * @param BaseController $controller
     */
    public function registerController($command_name, BaseController $controller)
    {
        $this->controllers = [$command_name => $controller];
    }

    /**
     * Registers a single "non controller" command
     *
     * @param $name
     * @param $call
     */
    public function register($name, $call)
    {
        $this->registry[$name] = $call;
    }

    /**
     * Get controllers instance from registered controller
     *
     * @param $command
     * @return mixed|null
     */
    public function getController($command)
    {
        return isset($this->controllers[$command]) ? $this->controllers[$command] : null;
    }

    /**
     * Get the call from controller and pass back the controller and method to run
     *
     * @param $command_name
     * @return array|mixed|null
     * @throws \Exception
     */
    public function getCall($command_name)
    {
        $controller = $this->getController($command_name);
        if ($controller instanceof BaseController) {
            return [$controller, 'run'];
        }

        $command = $this->get($command_name);
        if ($command === null) {
            throw new \Exception("Command " . $command_name . "not found.");
        }

        return $command;
    }

    /**
     * Get the command
     * @param $command
     * @return mixed|null
     */
    public function get($command)
    {
        return isset($this->registry[$command]) ? $this->registry[$command] : null;
    }
}