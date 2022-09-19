<?php

namespace App\Repository;

use App\Exception\FileNotCreateException;
use App\Repository\Contract\FileRepositoryInterface;
use Exception;

/**
 * FileRepositoryInterface interface
 * @package App/Contracts/Repository/FileRepositoryInterface
 * Note:- TThis class have multiple methods for cretting and moving files
 */
class DefaultFileRepository  implements FileRepositoryInterface
{
  const VALID_DIRECTORY_MESSAGE = "Please enter Valid Directory";


  /**
   * write function
   *
   * @param string $data
   * @param string $path
   * @param string $file_name
   * @return boolean
   * @throws FileNotCreateException if location not found
   */
  public function write(string $data, string $path, string $file_name): bool
  {
    if (!file_exists($path)) {
      self::VALID_DIRECTORY_MESSAGE;
      throw new FileNotCreateException();
    }
    file_put_contents($path . '/' . $file_name, $data);
    return true;
  }


  /**
   * createFileNameByUrl function
   *
   * @param string $url
   * @return string
   */
  public function createFileNameByUrl(string $url): string
  {
    $url_array = explode('/', $url);
    $last_element = end($url_array);
    $file_name = (strlen($last_element) > 13) ? substr($last_element, 0, 13) : $last_element;
    return rand() . '_' . $file_name;
  }
}
