<?php

namespace tests\Application\Service;

use App\Service\GenerateHashService;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GenerateHashServiceTest extends KernelTestCase
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

        $this->service = $container->get(GenerateHashService::class);

        $this->valid_single_url = 'https://media-exp1.licdn.com/dms/image/C4D03AQE9E_7ixM5XKg/profile-displayphoto-shrink_800_800/0/1648899913450?e=1669248000&v=beta&t=hT8Ja6kbEOEflEppj04-0iPT0ZFS6maINMtnJHCmYAs';

        $this->url_with_retry = 'https://www.purevpn.com/abcdedfgggg';

        $this->valid_comma_seperated_url = 'http://www.google.com/image.png,https://www.usertesting.com/platform';

        $this->invalid_url_format = 'asdasdasds';

        $this->valid_directory = 'public';

        $this->invalid_directory = 'creating/abcdcd/';

    }

    public function testExecuteSuccessSingleUrl()
    {


        $data = array(
            'url' => $this->valid_single_url,
            'path' => $this->valid_directory,
        );
        $data = $this->service->execute($data);
        $this->assertStringContainsString('"success":true', $data);
        $this->assertTrue(true);   

    }

    public function testExecuteSuccessMultipleUrls()
    {
        $data = array(
            'url' => $this->valid_comma_seperated_url,
            'path' => $this->valid_directory
        );
        $data = $this->service->execute($data);
        $this->assertStringContainsString('"success":true', $data);
        $this->assertTrue(true);   
    }

    public function testExecuteFailureAndRetryUrl()
    {
        $data = array(
            'url' => $this->url_with_retry,
            'path' => $this->valid_directory,
            'hash' => $this->valid_directory,
            
        );
        $data = $this->service->execute($data);
        $this->assertStringContainsString('"success":false', $data);
        $this->assertTrue(true);   

    }

    public function testExecuteInvalidUrlFormat()
    {
        $data = array(
            'url' => $this->invalid_url_format,
            'path' => $this->valid_directory
        );
        $data = $this->service->execute($data);

        $this->assertStringContainsString('Invalid URL', $data);
        $this->assertTrue(true);   
    }


}
