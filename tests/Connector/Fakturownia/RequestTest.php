<?php

namespace Radowoj\Invoicer\Tests\Connector\Fakturownia;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Radowoj\Invoicer\Connector\Fakturownia\Connector;

class RequestTest extends TestCase
{

    protected $token = 'someToken';

    protected $username = 'someUsername';

    /**
     * @var Connector
     */
    protected $connector = null;


    public function setUp()
    {
        $this->connector = new Connector();
    }


    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Token has not been set
     */
    public function testExceptionOnGettingNotSetToken()
    {
        $this->connector->getToken();
    }


    public function testTokenAccessors()
    {
        $this->connector->setToken($this->token);
        $this->assertEquals($this->token, $this->connector->getToken());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Username has not been set
     */
    public function testExceptionOnGettingNotSetUsername()
    {
        $this->connector->getUsername();
    }


    public function testUsernameAccessors()
    {
        $this->connector->setUsername($this->username);
        $this->assertEquals($this->username, $this->connector->getUsername());
    }


    public function testDefaultClient()
    {
        $this->assertInstanceOf(Client::class, $this->connector->getClient());
    }


    public function testClientAccessors()
    {
        $mock = $this->getMockBuilder(Client::class)->getMock();
        $this->connector->setClient($mock);
        $this->assertSame($mock, $this->connector->getClient());
    }


}