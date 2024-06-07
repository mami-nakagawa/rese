<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Favorite;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{

    public function thanks()
    {
        return view('thanks');
    }

    public function index()
    {
        $user = Auth::user();
        $favorites = Favorite::where('user_id',$user->id)->get();
        $shops = Shop::all();

        return view('shop-all', compact('favorites', 'shops'));
    }

    public function detail(Request $request)
    {
        $shop = Shop::find($request->id);

        return view('shop-detail', compact('shop'));
    }

    public function store()
    {
        return view('done');
    }

    public function mypage()
    {
        $user = Auth::user();
        $reservations = Reservation::where('user_id',$user->id)->get();
        $favorites = Favorite::where('user_id',$user->id)->get();
        $shops = Shop::all();

        return view('mypage', compact('user', 'reservations', 'favorites', 'shops'));
    }
}
