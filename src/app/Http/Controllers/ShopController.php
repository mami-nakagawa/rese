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

class ShopController extends Controller
{

    public function thanks()
    {
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

    public function detail(Request $request)
    {
        $user = Auth::user();
        $shop = Shop::find($request->id);
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $reviews = Review::all();
        $star_avg = Review::where('shop_id',$shop->id)->avg('star');
        $star_avg = substr($star_avg, 0, 4);
        $review_count = Review::where('shop_id',$shop->id)->count();

        return view('shop-detail', compact('user', 'shop', 'tomorrow', 'reviews', 'star_avg', 'review_count'));
    }

    public function reservation(ReservationRequest $request)
    {
        Reservation::create(
            $request->only([
                'user_id',
                'shop_id',
                'date',
                'time',
                'number',
            ])
        );

        return view('done');
    }

    public function reservationUpdate(ReservationRequest $request)
    {
        $reservation = Reservation::find($request->id);
        $reservation->update(
            $request->only([
                'date',
                'time',
                'number',
            ])
        );

        return redirect()->back();
    }

    public function reservationDestroy(Request $request)
    {
        Reservation::find($request->id)->delete();
        return redirect()->back();
    }

    public function favorite(Request $request)
    {
        $user = Auth::user();

        Favorite::create([
            'user_id' => $user->id,
            'shop_id' => $request->shop_id,
        ]);

        return redirect()->back();
    }

    public function favoriteDestroy(Request $request)
    {
        $user = Auth::user();
        favorite::where('shop_id',$request->shop_id)->where('user_id',$user->id)->delete();

        return redirect()->back();
    }

    public function mypage()
    {
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('H:i:s');
        $reservations = Reservation::where('user_id',$user->id)->whereDate('date','>=',$today)->get();
        $favorites = Favorite::where('user_id',$user->id)->get();
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $visits = Reservation::where('user_id',$user->id)->whereDate('date','<=',$today)->get();
        $reviews = Review::all();

        return view('mypage', compact('user', 'reservations', 'favorites', 'tomorrow', 'visits', 'today', 'now', 'reviews'));
    }

    public function review(ReviewRequest $request)
    {
        Review::create(
            $request->only([
                'user_id',
                'shop_id',
                'star',
                'comment',
            ])
        );

        return redirect()->back();
    }
}
