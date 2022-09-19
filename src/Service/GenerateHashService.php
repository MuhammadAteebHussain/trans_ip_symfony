<?php

namespace App\Service;

use App\Repository\Contract\CallHttpApiRepositoryInterface;
use App\Repository\Contract\HashRepositoryInterface;
use App\Repository\Contract\MessageBrokerInterface;
use App\Service\Contract\ApplicationServiceInterface;
use Symfony\Component\HttpFoundation\Response;




/**
 * GenerateHashService class
 * @package App\Listener\GenerateHashListner
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */
class GenerateHashService implements ApplicationServiceInterface
{

    private  $hash_repository;
    private  $queue;
    private  $http;

    /**
     * __construct function
     *  3 dependencies of this class this class will generate hash
     * and then send file generate data in quque
     * 
     * @param HashRepositoryInterface $hash_repository
     * @param MessageBrokerInterface $queue
     * @param CallHttpApiRepositoryInterface $http
     */
    public function __construct(HashRepositoryInterface $hash_repository, MessageBrokerInterface $queue, CallHttpApiRepositoryInterface $http)
    {
        $this->hash_repository = $hash_repository;
        $this->queue = $queue;
        $this->http = $http;
    }


    /**
     * execute function
     *  it will call any url file and then generate hash
     *  If it will failed then send data in generate_hash_queue
     *  for generate file it will send data in create_file_queue
     * @param array $request
     * @return response json string it will also print in console
     * Note :- make sure your listners will up for running this process
     */
    public function execute($request)
    {

        try {

            $urls = explode(",", $request['url']);
            $path = $request['path'];
            $response = [];
            foreach ($urls as $i => $url) {
                $url_data = $this->http->getHttpRequest($url);
                $request['url'] = $url;
                $request['path'] = $path;
                if ($url_data->getStatusCode() != $_ENV['SUCCESS_CODE']) {
                    $this->queue->returnWithresponse($_ENV['AMQP_CREATE_HASH_QUEUE'], $request);
                    $response[$i]['success'] = false;
                } else {
                    $hash_data = $this->hash_repository->encrypt($url_data->getContent());
                    $response[$i]['success'] = true;
                    $response[$i]['hash'] = "";
                    $response[$i]['path'] = $path;
                    $request['hash'] = $hash_data;
                    $this->queue->returnWithresponse($_ENV['AMQP_CREATE_FILE_QUEUE'], $request);
                }
            }

            return new Response(
                json_encode($response),
                Response::HTTP_OK,
            );
        } catch (\Exception $ex) {

            $this->queue->returnWithresponse($_ENV['AMQP_CREATE_HASH_QUEUE'], $request);
            return new Response(
                $ex->getMessage() . '-' . $ex->getLine() . '-' . $ex->getFile(),
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
