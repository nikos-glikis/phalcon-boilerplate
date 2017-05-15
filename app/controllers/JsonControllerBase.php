<?php

class JsonControllerBase extends ControllerBase
{
    private $_boot_time;
    private $_boot_memory;

    function initialize()
    {
        session_write_close();
        $this->_boot_time = microtime(TRUE);
        $this->_boot_memory = memory_get_usage();
    }

    function respondOkJson($data)
    {
        $response = new \Phalcon\Http\Response();

        $response->setStatusCode(200, "OK");
        if (is_array($data) && !isset($data['debug'])) {
            $data['debug'] = $this->_getDebug();
        }
        $response->setContent(json_encode($data));
        $response->setHeader("Content-Type", "application/json");
        $response->setHeader("Accept", "application/json");
        return $response;
    }

    function _getDebug()
    {
        return
            [
                'time' => $this->_getCurrentTime(),
                'memory' => $this->_getCurrentMemory(),
                'total_memory' => $this->_getTotalMemory(),
            ];
    }

    function _getCurrentTime()
    {
        return microtime(TRUE) - $this->_boot_time;
    }

    function _getCurrentMemory()
    {
        return memory_get_usage() - $this->_boot_memory;
    }

    function _getTotalMemory()
    {
        return memory_get_usage() - $this->_boot_memory;
    }
}
