<?php


namespace App\Helpers;


class HashHelper
{
    public static function generateJobHash() : string
    {
        return md5(mt_rand(32, 60));
    }

    public static function generateHashPass($password) : string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
