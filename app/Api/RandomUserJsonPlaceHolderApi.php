<?php


namespace App\Api;


class RandomUserJsonPlaceHolderApi
{
    protected $name;

    protected $email;


    public function __construct()
    {
        $json = $this->json_decode();

        $this->name = $json->name;
        $this->email = $json->email;
    }


    protected function json_decode()
    {
        $json = file_get_contents('https://jsonplaceholder.typicode.com/users/' . rand(1, 10));
        return json_decode($json);
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


}