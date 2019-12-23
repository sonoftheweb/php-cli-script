<?php

namespace Controllers;

use Cli\App;

abstract class BaseController
{
    /**
     * Application reference
     */
    protected $app;

    /**
     * Abstract "run" method for all controllers
     *
     * @param array $argv
     * @return mixed
     */
    abstract public function run(array $argv);

    /**
     * Abstract method to build csv files for all controllers
     *
     * @param array $data
     * @param string $delimiter
     * @return mixed
     */
    abstract public function generateCsvFile(array $data);

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Attach an instance of App class
     *
     * @return App
     */
    protected function getApp()
    {
        return $this->app;
    }
}