<?php

namespace App\Repository\Contract;


/**
 * MessageBrokerInterface interface
 * @package App/Repository/RabbitMQRepository
 */
interface MessageBrokerInterface
{


    /**
     * send function
     *
     * @param string $params
     * @param string $queue
     * @return string
     */
    public function send(string $params,string $queue): string;

    /**
     * returnWithresponse function
     *
     * @param string $notification_type
     * @param array $response
     * @return bool
     */
    public function returnWithresponse(string $notification_type,array $response);

    

    

}
