<?php


namespace App\API;


class RandomUserApi
{
    protected $name;

    protected $email;

    protected $avatar;

    public function __construct()
    {
        $json = $this->json_decode();

        $this->name = ucfirst($json->name->first) . ' ' . ucfirst($json->name->last);
        $this->avatar = $json->picture->large;
        $this->email = $json->email;
    }
    protected function json_decode()
    {
        $json = file_get_contents('https://randomuser.me/api/');
        return json_decode($json)->results[0];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

}