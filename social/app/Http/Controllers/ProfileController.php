<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
/* use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; */

use App\Models\User;
use App\Models\Followers;

use Auth;
use Validator;
use Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function view_profile($user_id) {
        $user = User::findOrFail($user_id);
        //dd($user);

        //$stmt = "select u.*, if((u.id in (select un.id from users un join followers f on(un.id=f.following_id) where f.user_id=?)), 'yes', 'no') as 'follows' from users u where u.id!=? and u.id=? limit 1";

        //$user = DB::select($stmt, [$user_id, Auth::user()->id, $user_id]);

        $follows = true;
        if (Followers::where('user_id', Auth::user()->id)->where('following_id', $user_id)->count()<=0) 
            $follows = false;
        
        return view('profile', ["user" => $user, 'follows' => $follows]);
    }

    public static function loadEditDataForm() {
        return view('edit-data', ["user" => Auth::user()]);
    }

    public static function editData(Request $request) {
        //dd($_POST["password_confirmation"]);

/*         $v = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^([a-zA-Z]+)( [a-zA-Z]+)*$/'],
            'password_confirmation' => 'required',
        ]); */

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'regex:/^([a-zA-Z]+)( [a-zA-Z]+)*$/'],
            'password_confirmation' => 'required',
        ]);

        if (Hash::check($validated['password_confirmation'], Auth::user()->password)) {
            /* User::where('user_id', Auth::user()->id)->update(['name' => $validated['name']]); */
            $user = User::find(Auth::user()->id);
            $user->name = $validated['name'];
            $user->save();
        } else {
            $error = ValidationException::withMessages([
                'password_confirmation' => 'Invalid password.',
            ]);

            throw $error;
        }

        return redirect('edit-data');
    }

    public static function showSearchedUsers(Request $request) {
        $validated = $request->validate([
            'search' => 'required'
        ]);

        /*  $validator = Validator::make(
            ['search' => $_GET['search']],
            ['search' => 'requred']
        );

        dd($validator); */

        
        //$stmt = "select u.*, if((u.id in (select un.id from users un join followers f on(un.id=f.following_id) where f.user_id=?)), 'yes', 'no') as 'follows' from users u where u.id!=? and u.name like ?";
        //$users = DB::select($stmt, [Auth::user()->id, Auth::user()->id, '%' . $validated['search'] . '%']);
        
        $users = User::where('name', 'like', '%' . $validated['search'] . '%')->get();
        
        return view('searched-users', ['users' => $users]);
    }

    public static function followUser(Request $request) {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);

        $new_insert = [
            'user_id' => Auth::user()->id,
            'following_id' => $validated['id'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        
        Followers::create($new_insert);

        return redirect('/u/' . $validated['id']);
    }

    public static function unfollowUser(Request $request) {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);
        
        Followers::where('user_id', Auth::user()->id)->where('following_id', $validated['id'])->delete();
        
        return redirect('/u/' . $validated['id']);
    }
}
