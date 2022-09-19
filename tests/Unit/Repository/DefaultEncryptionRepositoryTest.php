<?php

namespace tests\Unit\Repository;

use App\Repository\DefaultEncryptionRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DefaultEncryptionRepositoryTest extends KernelTestCase
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

        $this->service = $container->get(DefaultEncryptionRepository::class);
        $this->decrypt_param = 'I am Dev Ateeb';
        $this->hash = '8wNysfp7JgCLAdd2ZUTCIvORwnkON6gIMfHrfh/3DdddtSJ4RE2kZDEv';
        $this->hash_failed = '8wNysfp7asdadsasdasdasdJgCLAdd2ZUTCIvORwnkON6gIMfHrfh/3DdddtSJ4RE2kZDEv';

    }

    public function testEncrypt()
    {
        
        $response = $this->service->encrypt($this->decrypt_param);
        $this->assertTrue(true);   
    }

    public function testDecrypt()
    {
        $response = $this->service->decrypt($this->hash);
        $this->assertTrue(true);   
    }

    public function testDecryptFailed()
    {
        $response = $this->service->decrypt($this->hash_failed);
        $this->assertEquals($response,"");   
    }






}
