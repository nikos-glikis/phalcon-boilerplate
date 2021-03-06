<?php

use GuzzleHttp\Client;
use Phalcon\Di;
use Phalcon\Test\UnitTestCase as PhalconTestCase;

abstract class UnitTestCase extends PhalconTestCase
{
    /**
     * @var bool
     */
    private $_loaded = false;


    public function setUp()
    {
        parent::setUp();

        // Load any additional services that might be required during testing
        $di = Di::getDefault();

        // Get any DI components here. If you have a config, be sure to pass it to the parent

        $this->setDi($di);

        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError(
                "Please run parent::setUp()."
            );
        }
    }

    protected function getGuzzleClient($options = array())
    {
        $globalOptions = [
            // Base URI is used with relative requests
            'base_uri' => 'http://localhost:8101/',
            // You can set any number of default request options.
            'timeout' => 2.0,
        ];
        $finalOptions = array_merge($globalOptions, $options);
        return new Client($finalOptions);
    }

}