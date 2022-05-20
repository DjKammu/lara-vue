<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

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
        return view('home');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function products(Request $request)
    {
       $products = Product::query();
       
       $keyword = $request->keyword;
       $date = $request->date;
       
       // For search date

        if(request()->filled('date')){
            $products->whereDate('updated_at', '=', Carbon::parse($date)->format('Y-m-d'));
         }  


       // For search keyword
       if(request()->filled('keyword')){
            $products->where('name', 'LIKE', "%{$keyword}%");
         }  

          
          // For search user

         if(request()->filled('user')){
            $user = request()->user;
            $products->whereHas('user', function($q) use ($user){
                $q->where('id', $user);
            });
         } 

       $products = $products->paginate((new Product)->perPage);



       return response()->json(
            $products
       );

    }

}
