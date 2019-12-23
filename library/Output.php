<?php


namespace Cli;


class Output
{
    /**
     * Output message
     *
     * @param $message
     */
    public function out($message)
    {
        echo $message;
    }

    /**
     * Add new line to message
     */
    public function newLine()
    {
        $this->out("\n");
    }

    /**
     * Tune the display of the message and output it
     *
     * @param $message
     */
    public function display($message)
    {
        $this->newLine();
        $this->out($message);
        $this->newLine();
        $this->newLine();
    }
}