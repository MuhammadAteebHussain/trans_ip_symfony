<?php

namespace App\Repository;

use App\Repository\Contract\MessageBrokerInterface;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\HttpFoundation\Response;



/**
 * RabbitMQRepository class
 * FileRepositoryInterface interface
 * @package App/Contracts/Repository/FileRepositoryInterface
 *  Note:- The reason why i used this rabbitMQ the most organize open source
 * that will be helpful for queues and messages the package that i am using AMQPStreamConnection,AMQPMessage
 *  2- Here this calls work as a publisher and for listers you can see an abstract for listning quues
 */
class RabbitMQRepository  implements MessageBrokerInterface
{

    protected $response;

    /**
     * send function
     *
     * @param string $param
     * @param string $queue
     * @return string
     */
    public function send(string $param, string $queue): string
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'root', 'root');
        $channel = $connection->channel();
        $msg = new AMQPMessage($param);
        $channel->basic_publish($msg, '', $queue);
        $channel->close();
        $connection->close();
        return $param;
    }

    /**
     * returnWithresponse function
     *
     * @param string $notification_type
     * @param array $response
     * @return void
     */
    public function returnWithresponse(string $notification_type, array $response): void
    {
        $data = array(
            'NotificationType' => $notification_type,
            'data' => $response,
        );
        $message = json_encode($data);
        $this->send($message, $notification_type);
    }
}
