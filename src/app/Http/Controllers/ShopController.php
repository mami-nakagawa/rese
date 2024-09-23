<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Favorite;
use App\Models\Review;
use Auth;
use Carbon\Carbon;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ReviewRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{

    public function thanks()
    {
        Auth::logout();

        return view('thanks');
    }

    public function index(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $area = $request->input('area');
        $genre = $request->input('genre');
        $keyword = $request->input('keyword');

        $query = Shop::query();

        if(!empty($area)) {
            $query->where('area_id', 'LIKE', $area);
        }

        if(!empty($genre)) {
            $query->where('genre_id', 'LIKE', $genre);
        }

        if(!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('summary', 'LIKE', "%{$keyword}%");
        }

        $shops = $query->get();
        $user = Auth::user();
        $reviews = Review::all();

        return view('shop-all', compact('areas', 'genres', 'user', 'shops', 'reviews'));
    }

    public function detail($shop_id)
    {
        $user = Auth::user();
        $shop = Shop::where('id',$shop_id)->first();
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $reviews = Review::all();
        $star_avg = Review::where('shop_id',$shop_id)->avg('star');
        $star_avg = substr($star_avg, 0, 4);
        $review_count = Review::where('shop_id',$shop_id)->count();

        return view('shop-detail', compact('user', 'shop', 'tomorrow', 'reviews', 'star_avg', 'review_count'));
    }

    public function mypage()
    {
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->subMinute(10)->format('H:i:s');
        $reservations = Reservation::where('user_id',$user->id)->whereDate('date','>=',$today)->get();
        $favorites = Favorite::where('user_id',$user->id)->get();
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $visits = Reservation::where('user_id',$user->id)->whereDate('date','<=',$today)->get();
        $reviews = Review::all();

        return view('mypage', compact('user', 'reservations', 'favorites', 'tomorrow', 'visits', 'today', 'now', 'reviews'));
    }
}
