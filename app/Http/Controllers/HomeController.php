<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'Dashhboard';
        return view('home', compact('title'));
    }

    public function profile()
    {
        $title = 'Profile';
        return view('profile', compact('title'));
    }

    public function profilePictureupdate(Request $request)
    {
        if (!empty($request->file('image'))) {
            $image = time() . '.' . $request->file('image')->extension();
            $request
                ->file('image')
                ->move(public_path('uploads/profile'), $image);
        }
        $user = User::findOrFail(Auth::user()->id);
        $user->image = $image;
        if ($user->update()) {
            $json = [
                'type' => 1,
                'msg' => 'Profile updated successfully',
            ];
        } else {
            $json = [
                'type' => 0,
                'msg' => 'Something went wrong',
            ];
        }
        return response()->json($json);
    }

    public function profilePictureremove()
    {
        $user = User::findOrFail(Auth::user()->id);
        $image = $user->image;
        $user->image = "";
        $filePath = public_path('uploads/profile/' . $image);
        if ($user->update()) {
            if (File::exists($filePath)) {
                File::delete($filePath);
                $json = [
                    'type' => 1,
                    'msg' => public_path('assets/img/profile-img.jpg'),
                ];
            }
        } else {
            $json = [
                'type' => 0,
                'msg' => 'Something went wrong',
            ];
        }
        return response()->json($json);
    }

    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->name;
        if ($user->save()) {
            return redirect()
                ->route('profile.profile')
                ->with('success', 'Data is saved successfully');
        } else {
            return redirect()
                ->route('profile.profile')
                ->with('error', 'Something went wrong');
        }
    }

    public function profilePasswordupdate(Request $request)
    {

        $request->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required|confirmed|min:8',
        ]);

        $user = auth()->user();

        // Check if the current password matches the password in the database
        if (Hash::check($request->currentpassword, $user->newpassword)) {
            // Update the password
            $user->update([
                'password' => Hash::make($request->newpassword),
            ]);

            return redirect()
                ->route('profile.profile')
                ->with('success', 'Data is saved successfully');
        } else {
            return redirect()
                ->route('profile.profile')
                ->with('error', 'Something went wrong');
        }
    }
}
