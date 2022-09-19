<?php

namespace App\Repository\Contract;



/**
 * HashRepositoryInterface class
 * Implementation you can see
 * @package App\Repository\DefaultEncryptionRepository 
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */
interface HashRepositoryInterface
{


    /**
     * it will used for encryption
     *
     * @param string $param
     * @return string
     */
    public function encrypt(string $param): string;
    

    /**
     * It will used to descrption
     *
     * @param string $params
     * @return string
     */
    public function decrypt(string $params): string;

    
    

}
