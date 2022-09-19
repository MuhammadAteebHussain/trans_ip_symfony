<?php
declare(strict_types=1);

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

use Throwable;

/**
 * Class FileNotCreateException
 * @package App\Repository\Contract\FileRepositoryInterface
 */
class FileNotCreateException extends Exception
{
    const EXCEPTION_MESSAGE_FORMAT = 'Invalid File Path.';
    const CUSTOM_EXCEPTION_CODE = 'TIP_200';

    /**
     * @inheritDoc
     */
    public function __construct(
        $message = self::EXCEPTION_MESSAGE_FORMAT,
        int $http_code = Response::HTTP_OK,
        $previous = null
    ) {
        parent::__construct($message, $http_code, $previous);
    }
}
