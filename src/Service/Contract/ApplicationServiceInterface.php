<?php

namespace App\Service\Contract;


/**
 * ApplicationServiceInterface interface
 * 
 * This interface must have to implement in all application service classes
 * Services are brige that handle data by interfaces and then return data
 * perform action e.g copy file send data
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */
interface ApplicationServiceInterface
{


    /**
     * it will return array
     * @param mixed
     * @return array 
     */

    public function execute($request);
}
