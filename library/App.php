<?php

namespace Cli;

use Controllers\BaseController;

class App
{
    /**
     * @var $output
     */
    protected $output;

    /**
     * @var $commands
     */
    protected $commands;

    public function __construct()
    {
        $this->output = new Output();
        $this->commands = new Commands();
    }

    /**
     * Get the output of every command
     * Note: output includes all responses and errors
     *
     * @return Output
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Register a controller based on the command
     * Passes the task to Cli\Commands->registerController
     *
     * @param $name
     * @param BaseController $controller
     */
    public function registerController($name, BaseController $controller)
    {
        $this->commands->registerController($name, $controller);
    }

    /**
     * Register a single command for things like help
     * Passes the task to Cli\Commands->register
     *
     * @param $name
     * @param $call
     */
    public function registerCommand($name, $call)
    {
        $this->commands->register($name, $call);
    }

    /**
     * Run Commands
     *
     * @param array $argv
     * @param string $default
     */
    public function runCommand(array $argv, $default='help')
    {
        $command_name = $default;

        if (isset($argv[1])) {
            $command_name = $argv[1];
        }

        //sanitize argv
        $argv = $this->escapeArgs($argv);

        try {
            call_user_func($this->commands->getCall($command_name), $argv);
        } catch (\Exception $e) {
            $this->getOutput()->display($e->getMessage());
            exit;
        }
    }

    /**
     * Escape each args
     *
     * @param $argv
     * @return mixed
     */
    public function escapeArgs($argv)
    {
        foreach ($argv as &$arg) {
            $arg = escapeshellarg($arg);
        }

        return $argv;
    }
}