<?php

namespace App\Http\Controllers;

use App\Aggregators\Users;
use App\User;
use App\Validations\UserValidation;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Users $users)
    {
        $users = $users->get(15);
        return response()->json(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user, UserValidation $userValidation)
    {
        $responseText = 'Profile updated';

        $request->validate($userValidation->text());

        $userToUpdate = User::find($user);
        $userToUpdate->name = $request->name;
        $userToUpdate->email = $request->email;

        if($request->avatar)
        {
            $image = $request->avatar;
            $avatarName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($request->avatar)->fit(128, 128)->save(public_path('/uploads/avatars/').$avatarName);
            $userToUpdate->avatar = $avatarName;
            $responseText .= ' with avatar';
        }

        $userToUpdate->save();

        return response()->json(['success' => $responseText], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        User::destroy($user);
    }
}
