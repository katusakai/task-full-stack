<?php


namespace App\Helpers;


use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Avatar
{
    protected $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function upload($request)
    {
        $image = $request;
        $this->name = time() . Str::random(10) . '.jpg';
        Image::make($image)->fit(128, 128)->save(public_path('/uploads/avatars/').$this->name);
    }

}