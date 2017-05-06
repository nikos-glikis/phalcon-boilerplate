<?php

use Phalcon\Cli\Task;


class MainTask extends MyTask
{
    /**
     * @param array $params
     */
    public function mainAction(array $params)
    {
        echo "This is the default task and the default action" . PHP_EOL;
        var_dump($params);
        var_dump(ENV);
        $this->console->handle(
            [
                "task" => "main",
                "action" => "test",
            ]
        );
    }

    public function testAction()
    {
        echo "this is test\n";
    }
}