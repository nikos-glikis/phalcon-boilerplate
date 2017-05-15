<?php

namespace Test;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use NikosGlikis\Object0rPhpHelpers\Helpers\StringHelper;
use Phalcon\Http\ResponseInterface;

/**
 * Class UnitTest
 */
class JsonTest extends \UnitTestCase
{
    function testJsonHeaders()
    {
        $client = $this->getGuzzleClient();

        $response = $client->request("GET", "/json/gettestval");
        $body = $response->getBody()->getContents();
        $headers = $response->getHeaders();

        $this->assertTrue(is_array(\GuzzleHttp\json_decode($body, true)), "Result is not valid json");

        $this->assertTrue(isset($headers['Content-Type']));
        $this->assertTrue(isset($headers['Content-Type'][0]));
        $this->assertEquals($headers['Content-Type'][0], 'application/json');
        $this->assertTrue(isset($headers['Accept']));
        $this->assertTrue(isset($headers['Accept'][0]));
        $this->assertEquals($headers['Accept'][0], 'application/json');

        $bodyArray = \GuzzleHttp\json_decode($body, true);
        $this->assertTrue(is_array($bodyArray));
        $this->assertTrue(isset($bodyArray['debug']));
        $this->assertTrue(isset($bodyArray['debug']['time']));
        $this->assertTrue(isset($bodyArray['debug']['memory']));
        $this->assertTrue(isset($bodyArray['debug']['total_memory']));

    }
}
