<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function index() {}

    public function register(RegisterRequest $request) {
        $data = $request->validated();
        
        try {
            $user = new User();
            $user->name = ucfirst(strtolower($data['name']));
            $user->surname = ucfirst(strtolower($request->surname));
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $token = $user->createToken('web-token')->plainTextToken;

            $message = "You have been succesfully registered.";
        } catch(Exception $e) {
            $token = null;

            $message = $e->getMessage();
        }
        
        return [
            'message' => $message,
            'token' => $token,
            'user' => $user
        ];
    }

    public function login(Request $request) {
        $this->validateLogin($request);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('web-token')->plainTextToken;

            $message = "You have been sucessfully logged in.";
        } else {
            $token = null;
            $user = null;

            $message = "Invalid email or password.";

            return abort(401, "Invalid email or password.");
        }

        return [
            'message' => $message,
            'token' => $token,
            'user' => $user
        ];
    }

    function validateLogin($request) {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];

        $errorMessages = [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',

            'password.required' => 'Password is required.'
        ];

        return $request->validate($rules, $errorMessages);
    }

    public function logout(Request $request) {
        try {
            $request->user()->currentAccessToken()->delete();
            
            $message = "You have been succesfully logged out.";
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        return [
            'message' => $message
        ];
    }

    public function deleteUser(Request $request) {
        $user = auth('sanctum')->user();

        $same = true;
        if (!Hash::check($request->old_password, $user->password)) {
            $same = false;
            return abort(401, "Invalid password.");
        }

        try {
            User::where('id_user', auth('sanctum')->user()->id_user)->delete();

            $message = "Sucessfully deleted this user.";
        } catch(Exception $e) {
            $message = $e->getMessage();
        }

        return [
            'message' => $message,
            'same' => $same
        ];
    }

    public function editUser(Request $request) {
        $this->validateEdit($request);

        $user = auth('sanctum')->user();

        $message = "Invalid password";

        if ($user && Hash::check($request->old_password, $user->password)) {
            
            $user_db = User::where('id_user', $user->id_user)->first();

            $user_db->update(['name'=>ucfirst(strtolower($request->name)), 'surname'=>ucfirst(strtolower($request->surname))]);

            if ($request->new_password != null)
                $user_db->update(['password'=>Hash::make($request->new_password)]);

            $message = "User data updated.";
        } else {
            return abort(401, "Invalid password.");
        }

        return [
            'message' => $message,
            'user' => $user_db
        ];
    }

    function validateEdit($request) {
        $rules = [
            'name' => ['required','min:3', 'max:50', 'regex:/^[a-zA-ZšđčćžŠĐČĆŽ]+$/'],
            'surname' => ['required', 'min:3', 'max:50', 'regex:/^[a-zA-ZšđčćžŠĐČĆŽ]+$/'],
            'new_password' => ['nullable', 'min:6', 'max:255', 'regex:/[a-z]/', 'regex:/[A-Z]/','regex:/[0-9]/','regex:/[@$!%*#?&_.-]/']
        ];

        $errors = [
            'name.reqired' => 'Name is required.',
            'name.min' => 'Name should be at least 3 length.',
            'name.max' => 'Name should be at most 50 length.',
            'name.regex' => 'Name can only contain letters.',
            
            'surname.min' => 'Surname should be at least 3 length.',
            'surname.max' => 'Surname should be at most 50 length.',
            'surname.regex' => 'Surname can only contain letters.',

            'new_password.min' => 'Password should be at least 6 length.',
            'new_password.max' => 'Password should be at most 255 length.',
            'new_password.regex' => 'Password must contain at least 1 upper, 1 lower, 1 number and 1 special character (@$!%*#?&_.-)'
        ];
        
        return $request->validate($rules, $errors);
    }
}
