<?php

namespace App\Repository\Contract;



/**
 * CallHttpApiRepositoryInterface class
 * Implementation you can see
 * @package App\Repository\SymfonyHttpRepository 
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */
interface CallHttpApiRepositoryInterface
{
    /**
     * getHttpRequest function
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return mixed
     */
    public function getHttpRequest(string $url, array $params=[],array $headers=[]);
    /**
     * postHttpRequest function
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return mixed
     */
    public function postHttpRequest(string $url, array $params=[],array $headers=[]);

}
