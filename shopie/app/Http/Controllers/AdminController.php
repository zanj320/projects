<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class AdminController extends Controller
{
    public static function isAdmin() {
        return Auth::user()->role=='a';
    }
}
