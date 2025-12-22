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


    public function setUp(): void
    {
        $this->connector = new Connector();
    }


    public function testExceptionOnGettingNotSetToken()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Token has not been set');
        
        $this->connector->getToken();
    }


    public function testTokenAccessors()
    {
        $this->connector->setToken($this->token);
        $this->assertEquals($this->token, $this->connector->getToken());
    }


    public function testExceptionOnGettingNotSetUsername()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Username has not been set');
        
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
