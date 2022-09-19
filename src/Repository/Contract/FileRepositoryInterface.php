<?php

namespace App\Repository\Contract;


/**
 * FileRepositoryInterface class
 * Implementation you can see
 * @package App\Repository\DefaultFileRepository 
 * @author Ateeb <muhammad_ateeb_hussain@hotmail.com>
 */

interface FileRepositoryInterface
{


   
    /**
     * save file function
     *
     * @param string $data
     * @param string $path
     * @return boolean
     */
    public function write(string $data,string $path,string $file_name): bool;

    /**
     * createFileNameByUrl function
     * craate a new name by using file
     * @param string $url
     * @return string
     */
    public function createFileNameByUrl(string $url): string;
    

}
