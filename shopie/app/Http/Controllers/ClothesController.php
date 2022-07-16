<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use \App\Rules\Capital;

use \App\Models\Brand;
use \App\Models\Category;
use \App\Models\Clothe;
use \App\Models\User;
use \App\Models\Image;
use \App\Models\Location;
use \App\Models\Avaliability;
use \App\Models\Like;

use Auth;

class ClothesController extends Controller
{
    public function __construct() {
        /* $this->middleware('auth'); */

/*         $this->middleware(function ($request, $next) {
            if (Auth::user()==null || Auth::user()->role=='u') {
                return redirect('/login');
            }

            return $next($request);
        }); */
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clothes = Clothe::inRandomOrder();

        if ($request['category'])
            $clothes->where('category_id', $request['category']);

        if ($request['brand'])
            $clothes->where('brand_id', $request['brand']);

        $brands = Brand::all();
        $categories = Category::all();

        return view('clothes.displayAll', [
            'clothes' => $clothes->paginate(3),
            'brands' => $brands,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!AdminController::isAdmin()) {
            return redirect('/clothes');
        }
        
        $brands = Brand::all();
        $categories = Category::all();
        $locations = Location::all();

        return view('clothes.create', [
            'brands' => $brands,
            'categories' => $categories,
            'locations' => $locations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'regex:/^([a-zA-Z]+)( [a-zA-Z]+)*$/', new Capital],
            'price' => ['required', 'between:0,9999.99'],
            'quantity' => ['integer', 'min:0', 'max:200'],
            'description' => ['min:0', 'max:255'],
            'location' => ['required'],
            'category' => ['required'],
            'brand' => ['required'],
            'image' => ['required', 'mimes:jpeg,jpg,png', 'max:8192']
        ]);
        
        $new_image_name = time() . '-' . Brand::find($validated['brand'])->name . '-' . Category::find($validated['category'])->name . '.' . $request->file('image')->guessExtension();

        $request->image->move(public_path('images'), $new_image_name); //public_path images je za public mapo
        
        Clothe::create([
            'brand_id' => $validated['brand'],
            'category_id' => $validated['category'],
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description']
        ]);

        $recent_id = DB::getPdo()->lastInsertId();

        Avaliability::create([
            'clothe_id' => $recent_id,
            'location_id' => $validated['location'],
            'quantity' => $validated['quantity']
        ]);

        Image::create([
            'clothe_id' => $recent_id,
            'image_path' => $new_image_name
        ]);

        return redirect('/clothes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clothe = Clothe::find($id);

        $liked = Auth::user()!=null ? Like::where('clothe_id', $id)->where('user_id', Auth::user()->id)->count() : null;
        
        return view('clothes.displayOne', [
            'clothe' => $clothe,
            'liked' => $liked
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()==null) {
            return redirect('/clothes');
        }

        $user_id = Auth::user()->id;

        if ((Like::where('user_id', $user_id)->where('clothe_id', $id)->count()<=0)) {
            Like::create([
                'user_id' => $user_id,
                'clothe_id' => $id
            ]);
        } else {
            Like::where('user_id', $user_id)->where('clothe_id', $id)->delete();
        }

        return redirect('/clothes/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Clothe::destroy($id);

        return redirect('/clothes');
    }
}
