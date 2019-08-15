<?php


namespace App\Aggregators;


use App\User;
use App\Helpers\UrlParser;

class Users
{
    public function get($limit)
    {
        $users =  User::orderBy('created_at', 'desc')->paginate($limit);

        foreach ($users->items() as $key => $user) {
            $this->aggregate($user);
            $users[$key] = $user;
        }

        return $users;
    }

    private function aggregate($user) {
        $user->avatar = $this->avatarUrl($user->avatar);
        return $user;
    }

    private function avatarUrl($avatar)
    {
            if (UrlParser::ifLocal($avatar)) {
                $avatar = '/uploads/avatars/' . $avatar;
            }
        return $avatar;
    }
}