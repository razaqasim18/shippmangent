<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Models\Crew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        return view('crews_view.home');
    }


    public function profile()
    {
        $title = 'Profile';
        return view('crews_view.profile', compact('title'));
    }

    public function profilePictureupdate(Request $request)
    {
        if (!empty($request->file('image'))) {
            $image = time() . '.' . $request->file('image')->extension();
            $request
                ->file('image')
                ->move(public_path('uploads/crew'), $image);
        }
        $crew = Crew::findOrFail(Auth::guard('crew')->user()->id);
        $crew->image = $image;
        if ($crew->update()) {
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
        $crew = Crew::findOrFail(Auth::guard('crew')->user()->id);
        $image = $crew->image;
        $crew->image = "";
        $filePath = public_path('uploads/crew/' . $image);
        if ($crew->update()) {
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
        $crew = Crew::findOrFail(Auth::guard('crew')->user()->id);
        $crew->name = $request->name;
        if ($crew->save()) {
            return redirect()
                ->route('crews.profile.profile')
                ->with('success', 'Data is saved successfully');
        } else {
            return redirect()
                ->route('crews.profile.profile')
                ->with('error', 'Something went wrong');
        }
    }

    public function profilePasswordupdate(Request $request)
    {

        $request->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required|confirmed|min:8',
        ]);

        $crew = auth('crew')->user();

        // Check if the current password matches the password in the database
        if (Hash::check($request->currentpassword, $crew->newpassword)) {
            // Update the password
            $crew->update([
                'password' => Hash::make($request->newpassword),
            ]);

            return redirect()
                ->route('crews.profile.profile')
                ->with('success', 'Data is saved successfully');
        } else {
            return redirect()
                ->route('crews.profile.profile')
                ->with('error', 'Something went wrong');
        }
    }
}
