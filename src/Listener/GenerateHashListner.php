<?php

declare(strict_types=1);

namespace App\Listener;

use Error;
use ErrorException;
use Exception;
use PhpAmqpLib\Message\AMQPMessage;
use App\Listener\AbstractEventListener;
use App\Service\GenerateHashService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use TypeError;



/**
 * GenerateHashService class
 * @package App\Service\GenerateHashService
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */
class GenerateHashListner extends AbstractEventListener
{
    private  $generate_hash_listner;

    public function __construct(
        GenerateHashService $generate_hash_listner
    ) {
        $this->connection = new AMQPStreamConnection($_ENV['AMQP_HOST'], $_ENV['AMQP_PORT'], $_ENV['AMQP_USER'], $_ENV['AMQP_PASS']);
        $this->channel = $this->connection->channel();
        $this->queue_name = $_ENV['AMQP_CREATE_HASH_QUEUE'];
        $this->generate_hash_listner = $generate_hash_listner;
    }

    /**
     * @param AMQPMessage $message
     * @throws Exception
     */
    public function consume(AMQPMessage $message)
    {


        try {

            echo self::STEP_MESSAGE_RECEIVED, $message->body, self::DOUBLE_NEW_LINE_LITERAL;

            /**
             *  Validate the message first if its re-tries limit has met so that it will be moved into error exchange,
             *  otherwise we will process it.
             */
            if ($this->validate($message)) {
                sleep(10);
                /** Process the message and perform the operations. **/
                echo self::STEP_MESSAGE_PROCESSING_STARTED, self::SINGLE_NEW_LINE_LITERAL;

                $this->generate_hash_listner->execute($this->parseData($message->body));
                echo self::STEP_MESSAGE_PROCESSING_ENDED, self::SINGLE_NEW_LINE_LITERAL;
            }

            /** Acknowledge the message so that it will be removed from the queue. **/
            $message->ack();

            echo self::STEP_MESSAGE_PROCESSED, self::DOUBLE_NEW_LINE_LITERAL;
        } catch (Error | TypeError | ErrorException | Exception $exception) {

            /* Don't acknowledge the message so that it will move into dead letter exchange and will be re-tired. */
            $message->nack(false);
        }
    }


    /**
     * parseData function
     * @param string $message
     * @return mixed
     */
    public function parseData($message)
    {
        $json = json_decode($message);

        if ($json->NotificationType == $this->queue_name) {
            $params = json_decode(json_encode($json), true);
            return $params['data'];
        } else {
            self::NOT_AVAILABLE_LITERAL;
            return self::NOT_AVAILABLE_LITERAL;
        }
    }


    /**
     * publish function
     * it will published message in error queue
     * TODO:: Need to confgure error Queue
     * @param AMQPMessage $message
     * @return void
     */
    public function publish(AMQPMessage $message)
    {
        $this->channel->basic_publish(
            $message,
            $_ENV['AMQP_ERROR_EXCHANGE_NAME'],
            $_ENV['AMQP_ORDER_CHECKOUT_ERROR_QUEUE_NAME']
        );
    }
}
