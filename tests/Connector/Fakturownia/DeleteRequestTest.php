<?php

namespace Radowoj\Invoicer\Tests\Connector\Fakturownia;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\ClientException;
use Radowoj\Invoicer\Connector\Fakturownia\Response;
use Radowoj\Invoicer\Connector\Fakturownia\Connector;

class DeleteRequestTest extends TestCase
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
        $this->connector->setToken($this->token);
        $this->connector->setUsername($this->username);
    }

    public function testSendRequest()
    {
        $this->expectException(ClientException::class);

        $idInvoice = 1;
        $response = $this->connector->delete($idInvoice);

        // $this->assertSame(Response::STATUS_CODE_OK, $response->getStatusCode());
        // $this->assertSame('ok', $response->getStatusString());
    }
}
