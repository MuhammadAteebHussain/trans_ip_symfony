<?php

namespace App\Repository;

use App\Repository\Contract\HashRepositoryInterface;

/**
 * HashRepositoryInterface interface
 * @package App/Contracts/Repository/HashRepositoryInterface
 * Note:- The reason why i used this encryption mechnaism
 * this is one of the secure aand easist implementation for 
 * genrating hash
 */
class DefaultEncryptionRepository  implements HashRepositoryInterface
{

    /**
     * it is using for encryption
     *
     * @param string $param
     * @return string
     */
    public function encrypt(string $param): string
    {
        $key = substr(hash($_ENV['ALGO'], $_ENV['KEY_CODE'], true), 0, 32);
        $cipher = $_ENV['CIPHER'];
        $iv_len = openssl_cipher_iv_length($cipher);
        $tag_length = $_ENV['TAG_LENGTH'];
        $iv = openssl_random_pseudo_bytes($iv_len);
        $tag = ""; // will be filled by openssl_encrypt
        $ciphertext = openssl_encrypt($param, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag, "", $tag_length);
        return base64_encode($iv . $ciphertext . $tag);
    }

    /**
     * decrypt function
     *
     * @param string $param
     * @return string
     */
    public function decrypt(string $param): string
    {
        $encrypted = base64_decode($param);
        $key = substr(hash($_ENV['ALGO'], $_ENV['KEY_CODE'], true), 0, 32);
        $cipher = $_ENV['CIPHER'];
        $iv_len = openssl_cipher_iv_length($cipher);
        $tag_length = $_ENV['TAG_LENGTH'];
        $iv = substr($encrypted, 0, $iv_len);
        $ciphertext = substr($encrypted, $iv_len, -$tag_length);
        $tag = substr($encrypted, -$tag_length);
        return openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag);
    }
}
