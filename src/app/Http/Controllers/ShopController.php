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
        $user = Auth::user();
        $shops = Shop::all();
        $reviews = Review::all();
        foreach($shops as $shop) {
            $review = Review::where('shop_id',$shop->id)->first();
            if($review) {
                $star_avg = Review::where('shop_id',$shop->id)->avg('star');
            } else {
                $star_avg = 0;
            }
            $shop->update([
                'star_avg' => $star_avg,
            ]);
        }

        // 検索
        $areas = Area::all();
        $genres = Genre::all();
        $area = $request->input('area');
        $genre = $request->input('genre');
        $keyword = $request->input('keyword');

        $query = Shop::query();

        if($area=="all" || null) {
            $query->get();
        } else {
            $query->where('area_id', 'LIKE', $area);
        }

        if($genre=="all" || null) {
            $query->get();
        } else {
            $query->where('genre_id', 'LIKE', $genre);
        }

        if(!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('summary', 'LIKE', "%{$keyword}%");
        }

        $shops = $query->get();

        // ソート
        $sort = $request->sort;

        switch ($sort) {
            case '1':
                // ランダム
                $shops = $query->inRandomOrder()->get();
                break;
            case '2':
                // 評価が高い順
                $shops = $query->orderBy('star_avg', 'desc')->get();
                break;
            case '3':
                // 評価が低い順
                $shops = $query->orderByRaw('star_avg = 0')->orderBy('star_avg', 'asc')->get();
                break;
            default :
                // デフォルトはID順
                $shops = $query->get();
                break;
        }

        return view('shop-all', compact('sort', 'areas', 'genres', 'user', 'shops', 'reviews'));
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
