<?php

namespace tests\Unit\Repository;

use App\Repository\SymfonyHttpRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SymfonyHttpRepositoryTest extends KernelTestCase
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

        $this->service = $container->get(SymfonyHttpRepository::class);

        $this->url = 'https://www.google.com';


        $this->data = array(
            'unit testing' => 'working fine'
        );
    }

    public function testGetHttpRequest()
    {
        $this->service->getHttpRequest($this->url,$this->data);
        $this->assertTrue(true);
    }
}
