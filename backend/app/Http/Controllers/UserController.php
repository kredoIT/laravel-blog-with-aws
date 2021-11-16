<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    const S3_AVATAR_FOLDER = 'avatars/';

    private $user;

    /**
     * Create a new controller instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display user profile data
     *
     * @return View
     */
    public function show()
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        $posts = $user->posts->sortByDesc('id');

        return view('users.show')
                ->with('user', $user)
                ->with('posts', $posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function edit()
    {
        $user = $this->user->findOrFail(Auth::user()->id);

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Redirect
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|min:1|max:50',
            'email'     => 'required|email|max:50|' . Rule::unique('users')->ignore(Auth::user()->id),
            'avatar'    => 'mimes:jpg,png,jpeg,gif|max:1048'
        ]);

        $user           = $this->user->find(Auth::user()->id);
        $user->name     = $request->name;
        $user->email    = $request->email;
        
        if ($request->avatar) {
            $user->avatar = $this->saveImage($request, $user->avatar);
        }

        $user->save();

        return redirect()->route('user.show');
    }

    /**
     * Update and rename image file for saving
     *
     * @param Request $request
     * @param String $avatar
     * @return String
     */
    private function saveImage($request, $avatar = null)
    {
        # rename the image to remove the risk of overwriting 
        $name   = time() . '.' . $request->avatar->extension();

        # put into public to be accessible
        $request->avatar->storeAs(self::S3_AVATAR_FOLDER, $name, 's3');
        
        # check if has existing avatar saved in db && in storage
        if ($avatar) { $this->deleteAvatar($avatar); }

        return $name;
    }

    /**
     * Delete avatar when deleting the profile
     *
     * @param String $avatar
     * @return Void
     */
    private function deleteAvatar($avatar)
    {
        $imgPath = self::S3_AVATAR_FOLDER . $avatar;

        if (Storage::disk('s3')->exists($folder . $avatar)) {
            Storage::disk('s3')->delete($folder . $avatar);
        }
    }
}
