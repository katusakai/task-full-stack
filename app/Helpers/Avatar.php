<?php


namespace App\Helpers;


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
        $this->name = time() . strstr($image->getClientOriginalName(), '.');
        Image::make($image)->fit(128, 128)->save(public_path('/uploads/avatars/').$this->name);
    }

}