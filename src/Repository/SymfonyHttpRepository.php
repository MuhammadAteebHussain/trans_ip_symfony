<?php

namespace App\Repository;

use App\Repository\Contract\CallHttpApiRepositoryInterface;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * CallHttpApiRepositoryInterface interface
 * @package App/Contracts/Repository/CallHttpApiRepositoryInterface
 * Note:- Default symfony HTTP request call system
 */
class SymfonyHttpRepository implements CallHttpApiRepositoryInterface
{

    protected $http;
    /**
     * __construct function
     *
     * @param HttpClientInterface $http
     */
    public function __construct(HttpClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * getHttpRequest function
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return mixed
     */
    public function getHttpRequest(string $url, array $params = [], array $headers = [])
    {
        return  $this->http->request(
            'GET',
            $url
        );
    }

    /**
     * postHttpRequest function
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return mixed
     */
    public function postHttpRequest(string $url, array $params = [], array $headers = [])
    {
        return $this->http->request('POST', $url, $params, [
            'headers' => $headers,
        ]);
    }
}
