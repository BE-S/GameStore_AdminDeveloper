<?php


namespace App\Http\Service;


class AuthService
{
    public function changePass($user, $credentials)
    {
        return $user->update([
            'password' => $this->generateHashPass($credentials['password']),
        ]);
    }

    public function generateJobHash()
    {
        return md5(mt_rand(32, 60));
    }

    public function generateHashPass($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

