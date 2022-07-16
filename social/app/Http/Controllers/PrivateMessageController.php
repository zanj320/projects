<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Followers;
use App\Models\User;
use App\Models\PrivateMessages;
use App\Http\Resources\PrivateMessageResource;

use Auth;

class PrivateMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function loadPrivateMessages($user_id) {
/*         $user = DB::table('users')->join('followers', 'users.id', '=', 'followers.following_id')
        ->select('users.*')
        ->where('followers.user_id', Auth::user()->id)
        ->where('followers.following_id', $user_id)
        ->get(); */

        $is_following = Followers::where('user_id', Auth::user()->id)->where('following_id', $user_id)->count();
        if ($is_following<=0) {
            return redirect("/u/$user_id");
        }

        $user_data = User::findOrFail($user_id);
        //$sent_messages = PrivateMessages::where('sent_id', Auth::user()->id)->where('recieved_id', $user_id)->get();
        //$recieved_messages = PrivateMessages::where('sent_id', $user_id)->where('recieved_id', Auth::user()->id)->get();

        $messages = PrivateMessages::
        where('sent_id', Auth::user()->id)
        ->where('recieved_id', $user_id)
        ->orwhere(function($query) use ($user_id) {
            $query->where('sent_id', $user_id)
            ->where('recieved_id', Auth::user()->id);
        })->orderby('created_at', 'ASC')->get();
        
        return view('private-message', [
            'user' => $user_data,
            'messages' => $messages
            //'sent_messages' => $sent_messages,
            //'recieved_messages' => $recieved_messages
        ]);
    }

    public static function sendMessage(Request $request) {
        $validated = $request->validate([
            'body' => 'required|max:255'
        ]);

        $id = explode('/', url()->previous())[4];

        $new_PrivateMessage  = ['id' => NULL, 'sent_id' => Auth::user()->id, 'recieved_id' => $id, 'body' => $validated['body'], 'created_at' => now(), 'updated_at' => now()];

        PrivateMessages::create($new_PrivateMessage);

        return redirect('/msg/' . $id);
    }
}
