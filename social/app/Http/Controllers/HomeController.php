<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Message;

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
    public static function index()
    {
        $following = Auth::user()->following;

/*         dd($following); */
        
        $messages = Message::whereIn('user_id', $following->pluck('id'))
            ->orWhere('user_id', Auth::user()->id)
            ->latest()
            ->get();

/*         dd(env('DB_DATABASE')); */

        return view('home', [
            "messages" => $messages,
            "following" => $following
        ]);
    }
}
