<?php

namespace Test;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use NikosGlikis\Object0rPhpHelpers\Helpers\StringHelper;
use Phalcon\Http\ResponseInterface;

/**
 * Class UnitTest
 */
class EnvTest extends \UnitTestCase
{
    public function testBasics()
    {
        $client = $this->getGuzzleClient();

        $response = $client->request("GET", "/");
        $body = $response->getBody()->getContents();
        $this->checkResponseEnvironmentHeaders($response);

        $this->assertTrue(StringHelper::stringContains($body, "Congratulations!"), "Body does not contain Congratulations");
        $this->assertTrue(StringHelper::stringContains($body, "PersonID"), "Body does not contain PersonID dump");
        $this->assertTrue(StringHelper::stringContains($body, "LastName"), "Body does not contain PersonID dump");
        $this->assertTrue(StringHelper::stringContains($body, "Address"), "Body does not contain PersonID dump");
        $this->assertTrue(StringHelper::stringContains($body, "City"), "Body does not contain PersonID dump");
    }

    public function testProdEnv()
    {
        $client = $this->getGuzzleClient();
        $response = $client->request("GET", "/index/gettestval");
        $body = $response->getBody()->getContents();
        $this->assertTrue(isValidJson($body), "Body is not a valid json");

        $bodyArray = \GuzzleHttp\json_decode($body, true);

        $this->assertTrue(is_array($bodyArray), "BodyArray is not an array.");
        $this->assertTrue(isset($bodyArray['testval']));
        $this->assertTrue(isset($bodyArray['testval2']));

        $this->assertEquals($bodyArray['testval'], 'prod');
        $this->assertEquals($bodyArray['testval2'], 'prod');


        $this->checkResponseEnvironmentHeaders($response, 'prod');
    }

    public function testTestEnvGet()
    {
        $client = $this->getGuzzleClient();
        $response = $client->request("GET", "index/gettestval?_x_env=test");
        $body = $response->getBody()->getContents();
        $this->checkValidTestResponse($body);
        $this->checkResponseEnvironmentHeaders($response, 'test');
    }

    public function testTestEnvCookie()
    {
        $client = $this->getGuzzleClient();
        $response = $client->request("GET", "index/gettestval", array('headers' => ['Cookie' => '_x_env=test']));
        $body = $response->getBody()->getContents();
        $this->checkValidTestResponse($body);
        $this->checkResponseEnvironmentHeaders($response, 'test');
    }

    public function testTestEnvPost()
    {
        $client = $this->getGuzzleClient();
        $response = $client->request
        (
            "POST", "index/gettestval",
            [
                'form_params' =>
                    [
                        '_x_env' => 'test'
                    ]
            ]
        );
        $body = $response->getBody()->getContents();
        $this->checkValidTestResponse($body);
        $this->checkResponseEnvironmentHeaders($response, 'test');
    }

    private function checkValidTestResponse($body)
    {
        $this->assertTrue(isValidJson($body), "Body is not a valid json");

        $bodyArray = \GuzzleHttp\json_decode($body, true);

        $this->assertTrue(is_array($bodyArray), "BodyArray is not an array.");
        $this->assertTrue(isset($bodyArray['testval']));
        $this->assertTrue(isset($bodyArray['testval2']));

        $this->assertEquals('test', $bodyArray['testval']);
        $this->assertEquals('prod', $bodyArray['testval2']);
    }

    private function checkResponseEnvironmentHeaders(Response $response, $env = 'prod')
    {
        $headers = $response->getHeaders();
        $this->assertTrue(is_array($headers), "Headers is not an array");
        $this->assertTrue(is_array($headers['X-ENV']), "X-ENV header is not array");
        $this->assertTrue(isset($headers['X-ENV'][0]), "X-ENV header is not set[0]");
        $this->assertEquals($env, $headers['X-ENV'][0], "X-ENV header is not prod");

    }

    public function test500ExceptionProd()
    {
        $client = $this->getGuzzleClient(['http_errors' => false]);
        $response = $client->request("GET", "index/exception");
        $body = $response->getBody()->getContents();
        $this->assertEquals(500, $response->getStatusCode(), "Exception error code is not 500");
        $validMessage = '500: Some error happend.';
        $this->assertEquals($validMessage, $body, "Exception error code is not " . $validMessage);
    }

    public function test500ExceptionTest()
    {
        $client = $this->getGuzzleClient(['http_errors' => false]);
        $response = $client->request("GET", "index/exception?_x_env=test");
        $body = $response->getBody()->getContents();
        $this->assertEquals(500, $response->getStatusCode(), "Exception error code is not 500");
        $validMessage = '500: Some error happend.';
        $this->assertNotEquals($validMessage, $body, "Exception error code is " . $validMessage);
        $validMessage = 'Something bad happened.<br>';
        $this->assertStringStartsWith($validMessage, $body, "Exception error code does not start with " . $validMessage);
        $this->assertContains($validMessage, $body, "Body does not contain stacktrace.");
    }

}
