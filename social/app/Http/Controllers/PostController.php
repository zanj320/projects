<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\Message;

class PostController extends Controller
{
    public static function insert_new_post(Request $request) {
        //DB::insert('INSERT INTO messages VALUES(NULL, ?, ?, now(), now())', [2,"test"]);
        
        $validated = $request->validate([
            'body' => 'required|max:255',
        ]);

        $new_message  = ['id' => NULL, 'user_id' => Auth::user()->id, 'body' => $validated['body'], 'created_at' => now(), 'updated_at' => now()];

        Message::create($new_message);
        
        return HomeController::index();
    }

    public static function delete_post() {
        Message::where('id', $_POST["id"])->where('user_id', Auth::user()->id)->delete();
        //Message::destroy(14); //po primarnem

        return HomeController::index();
    }
}
