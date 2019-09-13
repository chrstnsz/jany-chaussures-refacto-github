<?php

namespace Models;

class Auth extends Model
{
    public function getUser($username)
    {
        $req = $this->pdo->prepare('SELECT * FROM admin WHERE username = :username');
        $req->execute(['username' => $username]);
        $user = $req->fetch();

        return $user;
    }
}