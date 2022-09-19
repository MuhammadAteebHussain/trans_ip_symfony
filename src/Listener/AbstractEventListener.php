<?php

namespace App\Listener;

use ErrorException;
use Exception;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use PhpAmqpLib\Connection\AMQPStreamConnection;

use function env;

abstract class AbstractEventListener
{
    const RETRY_LIMIT = 2;
    const NOT_AVAILABLE_LITERAL = 'N/A';
    const SEPARATOR_LITERAL = ' - ';
    const SINGLE_NEW_LINE_LITERAL = "\n";
    const DOUBLE_NEW_LINE_LITERAL = "\n\n";

    const STEP_MESSAGE_RECEIVED = " [1.0] Received : ";
    const STEP_RETRY_REASON = " [1.1] Retry Reason : ";
    const STEP_RETRY_ATTEMPTS = " [1.2] Retry Attempts : ";
    const STEP_PUSHED_TO_ERRORS = " [1.3] Pushed To Errors.";
    const STEP_FRESH_EVENT = " [1.1] Fresh Event.";
    const STEP_MESSAGE_PROCESSING_STARTED = " [2.0] Processing Started.";
    const STEP_MESSAGE_PROCESSING_ENDED = " [2.X] Processing Ended.";

    const STEP_EXCEPTION_MESSAGE = " [3.0] Exception Occurred : ";
    const STEP_EXCEPTION_TRACE = " [3.1] Exception Trace : ";

    const STEP_MESSAGE_PROCESSED = " [X] Processed Successfully";
    const STEP_MESSAGE_FAILED = " [X] Process Failed";

    protected  $connection;
    protected  $queue_name;
    protected  $channel;
    protected  $outgoing_webhook;
    /**
     * @throws ErrorException
     * @throws Exception
     */
    public function listen()
    {
        /**
         * don't dispatch a new message to a worker until it has processed and
         * acknowledged the previous one. Instead, it will dispatch it to the
         * next worker that is not still busy.
         * # global=true to mean that the QoS settings should apply per-channel
         */
        $this->channel->basic_qos(
            null,   #prefetch size - prefetch window size in octets, null meaning "no specific limit"
            1,  #prefetch count - prefetch window in terms of whole messages
            null    #global - global=null to mean that the QoS settings should apply per-consumer,
        );

        /**
         * indicate interest in consuming messages from a particular queue. When they do
         * so, we say that they register a consumer or, simply put, subscribe to a queue.
         * Each consumer (subscription) has an identifier called a consumer tag
         */
        $this->channel->basic_consume(
            $this->queue_name,          #queue
            '', #consumer tag - Identifier for the consumer, valid within the current channel. just string
            false,  #no local - TRUE: the server will not send messages to the connection that published them
            false,  #no ack, false - acks turned on, true - off.  send a proper acknowledgment once done with a task
            false,  #exclusive - queues may only be accessed by the current connection
            false,  #no wait - TRUE: the server will not respond. The client should not wait for a reply method
            array($this, 'consume') #callback
        );

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();
    }

    /**
     * @throws Exception
     * Application headeers not sending by my publisher
     * TODO::Send Application Headers by RabbmitMQRepository
     * @param AMQPMessage $message
     * @return bool
     */
    public function validate(AMQPMessage $message): bool
    {
        if (isset($message->get_properties()['application_headers'])) {
            // /* @var AMQPTable $event_headers /
            $event_headers = $message->get_properties()['application_headers'];
            $headers_data = $event_headers->getNativeData();

            if (isset($headers_data['x-death']) && !empty($headers_data['x-death'])) {
                $x_death = $headers_data['x-death'];

                if (isset($x_death[0]) && !empty($x_death[0])) {
                    echo static::STEP_RETRY_REASON, $x_death[0]['reason'] ?? static::NOT_AVAILABLE_LITERAL, static::SINGLE_NEW_LINE_LITERAL;

                    $retry_attempts = (int)$x_death[0]['count'];
                    echo static::STEP_RETRY_ATTEMPTS, $retry_attempts, static::SINGLE_NEW_LINE_LITERAL;

                    if ($retry_attempts > static::RETRY_LIMIT) {
                        static::publish(
                            new AMQPMessage($message->body)
                        );

                        echo static::STEP_PUSHED_TO_ERRORS, static::SINGLE_NEW_LINE_LITERAL;

                        return false;
                    }
                }
            } else {
                echo static::STEP_FRESH_EVENT, static::SINGLE_NEW_LINE_LITERAL;
            }
        } else {
            echo static::STEP_FRESH_EVENT, static::SINGLE_NEW_LINE_LITERAL;
        }

        return true;
    }

    /**
     * publish function
     *  publishing data in error queue if failed
     * @param AMQPMessage $message
     * @return void
     */
    public function publish(AMQPMessage $message)
    {
        $this->channel->basic_publish(
            $message,
            $_ENV['AMQP_ERROR_EXCHANGE_NAME'],
            $_ENV['AMQP_ERROR_QUEUE_NAME']
        );
    }
}
