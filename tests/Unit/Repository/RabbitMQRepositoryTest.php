<?php

namespace tests\Unit\Repository;

use App\Repository\RabbitMQRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RabbitMQRepositoryTest extends KernelTestCase
{

    protected $service;

    /**
     * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
     * 
     * Note:I m not using here faker the reason is mostly 
     * data are static for my test cases
     */

    protected function setUp(): void
    {


        self::bootKernel();

        $container = static::getContainer();

        $this->service = $container->get(RabbitMQRepository::class);

        $this->message = 'This is Test Message';

        $this->queue = $_ENV['AMQP_TEST_PUB'];

        $this->data = array(
            'unit testing' => 'working fine'
        );
    }

    public function testSendMessage()
    {

        $this->service->send($this->message, $this->queue);
        $this->assertTrue(true);
    }

    public function returnWithresponse()
    {
        $response = $this->service->createFileNameByUrl($this->queue, $this->data);
        $this->assertTrue(true);
    }
}
