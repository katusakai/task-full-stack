<?php


namespace App\Validations;


class UserValidation
{
    public function text() : array
    {
        $validatedData = [
            'name' => 'required|max:50',
            'email' => 'required|max:50|email'
        ];

        return $validatedData;
    }

    public function image() : array
    {
        $validatedData = [
            'avatar' => 'required',
        ];

        return $validatedData;
    }
}