<?php

namespace tests\Unit\Repository;

use App\Repository\DefaultEncryptionRepository;
use App\Repository\DefaultFileRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DefaultFileRepositoryTest extends KernelTestCase
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

        $this->service = $container->get(DefaultFileRepository::class);

        $this->valid_single_url = 'https://media-exp1.licdn.com/dms/image/C4D03AQE9E_7ixM5XKg/profile-displayphoto-shrink_800_800/0/1648899913450?e=1669248000&v=beta&t=hT8Ja6kbEOEflEppj04-0iPT0ZFS6maINMtnJHCmYAs';

        $this->url_with_retry = 'https://www.purevpn.com/abcdedfgggg';

        $this->invalid_url_format = 'asdasdasds';

        $this->valid_directory = 'public';

        $this->valid_file_name = rand().'_unit_test.html';


        $this->invalid_directory = 'creating/abcdcd/';

        $this->data = 'OOK8dMlqglwTfnRut9h3\/+6zpO3Ymb5RDt68dTktic3hnzm3REnxHZIeybrcVb5t2GQAqfn0uCZF5mhhnbEGmLGrs9Nvc4YUzqynCGwgQlhp3uz4sWPgcZQtN5482brnTphKgBH20a6MYLt2bHDiECNPSAwpwBO2j4phVLIvDOtWCQ2a3cj64FVkYZeA9dMhxENJZtcQ57GX1GeVytiUCvnGSzMtweZpHUHJWoJKug9\/Q89OvDORH0tnOrYfJDlahN1hgfdohIY2VibEXgg2gDcQ5FLoh3skN3ur8RVJkkADehQ1InDUcnV+71kbv+rIoNFk+3JjEceWft5LYsCrlJU5Xh38CApE2b5ju\/kpsvuP7naSe6eC+MriIFHHSUoWIbZEaR30unPDInBJ';

    }

    public function testWrite()
    {
        
        $this->service->write($this->data, $this->valid_directory, $this->valid_file_name);
        $this->assertTrue(true);   
    }

    public function testCreateFileNameByUrl()
    {
        $response = $this->service->createFileNameByUrl($this->valid_single_url);
        $this->assertTrue(true);   
    }





}
