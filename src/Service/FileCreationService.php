<?php

namespace App\Service;

use App\Exception\FileNotCreateException;
use App\Repository\Contract\FileRepositoryInterface;
use App\Service\Contract\ApplicationServiceInterface;
use Symfony\Component\HttpFoundation\Response;



/**
 * this class is getting data by create_file_queue listner
 * @package App\Listener\CreateFileListner
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */
class FileCreationService implements ApplicationServiceInterface
{

    private  $repository;

    /**
     * __construct function
     *
     * @param FileRepositoryInterface $repository
     */
    public function __construct(FileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * execute function
     * Note: this funtion will create new file and in 
     * failure it will also work in reattempt queue.
     * @param array $array
     * @return array
     */
    public function execute($request)
    {
        try {
            $file_name = $this->repository->createFilenameByurl($request['url']);
            return $this->repository->write($request['hash'], $request['path'], $file_name);
        } catch (\Exception $ex) {

            return new Response(
                $ex->getMessage() . '- Line-' . $ex->getLine() . '-File-' . $ex->getFile(),
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
