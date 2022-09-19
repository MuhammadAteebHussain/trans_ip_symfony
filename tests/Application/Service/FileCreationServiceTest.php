<?php

namespace tests\Application\Service;

use App\Service\FileCreationService;
use App\Service\GenerateHashService;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FileCreationServiceTest extends KernelTestCase
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

        $this->service = $container->get(FileCreationService::class);

        $this->valid_single_url = 'https://media-exp1.licdn.com/dms/image/C4D03AQE9E_7ixM5XKg/profile-displayphoto-shrink_800_800/0/1648899913450?e=1669248000&v=beta&t=hT8Ja6kbEOEflEppj04-0iPT0ZFS6maINMtnJHCmYAs';

        $this->url_with_retry = 'https://www.purevpn.com/abcdedfgggg';

        $this->invalid_url_format = 'asdasdasds';

        $this->valid_directory = 'public';

        $this->invalid_directory = 'creating/abcdcd/';

        $this->hash = 'OOK8dMlqglwTfnRut9h3\/+6zpO3Ymb5RDt68dTktic3hnzm3REnxHZIeybrcVb5t2GQAqfn0uCZF5mhhnbEGmLGrs9Nvc4YUzqynCGwgQlhp3uz4sWPgcZQtN5482brnTphKgBH20a6MYLt2bHDiECNPSAwpwBO2j4phVLIvDOtWCQ2a3cj64FVkYZeA9dMhxENJZtcQ57GX1GeVytiUCvnGSzMtweZpHUHJWoJKug9\/Q89OvDORH0tnOrYfJDlahN1hgfdohIY2VibEXgg2gDcQ5FLoh3skN3ur8RVJkkADehQ1InDUcnV+71kbv+rIoNFk+3JjEceWft5LYsCrlJU5Xh38CApE2b5ju\/kpsvuP7naSe6eC+MriIFHHSUoWIbZEaR30unPDInBJ';


    }

    public function testExecuteStoreFileSuccessFully()
    {
        
        $data = array(
            'url' => $this->valid_single_url,
            'path' => $this->valid_directory,
            'hash' => $this->hash
        );
        $response = $this->service->execute($data);
        $this->assertTrue(true);   
    }

    public function testExecuteStoreFileFailed()
    {
        
        $data = array(
            'url' => $this->valid_single_url,
            'path' => $this->invalid_directory,
            'hash' => $this->hash
        );
        $response = $this->service->execute($data);
        $this->assertStringContainsString('Invalid File Path', $response);
    }





}
