<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Favorite;
use Auth;
use Carbon\Carbon;
use App\Http\Requests\ReservationRequest;
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
        $area = $request->input('area');
        $genre = $request->input('genre');
        $keyword = $request->input('keyword');

        $query = Shop::query();

        if(!empty($area)) {
            $query->where('area', 'LIKE', $area);
        }

        if(!empty($genre)) {
            $query->where('genre', 'LIKE', $genre);
        }

        if(!empty($keyword)) {
            $query->where('shop_name', 'LIKE', "%{$keyword}%")
                ->orWhere('area', 'LIKE', "%{$keyword}%")
                ->orWhere('genre', 'LIKE', "%{$keyword}%")
                ->orWhere('detail', 'LIKE', "%{$keyword}%");
        }

        $shops = $query->get();
        $user = Auth::user();
        $favorites = Favorite::where('user_id',$user->id)->get();


        return view('shop-all', compact('user', 'favorites', 'shops', 'area'));
    }

    public function search(Request $request)
    {
        $query = Shop::query();
        $query = $this->getSearchQuery($request, $query);
        $shops = $query->get();

        return view('shop-all', compact('user', 'favorites', 'shops'));
    }

    public function detail(Request $request)
    {
        $user = Auth::user();
        $shop = Shop::find($request->id);
        $today = Carbon::today()->format('Y-m-d');

        return view('shop-detail', compact('user', 'shop', 'today'));
    }

    public function reservationUpdate(Request $request)
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

    public function reservationDestroy(Request $request)
    {
        Reservation::find($request->id)->delete();
        return redirect()->back();
    }

    public function favorites(Request $request)
    {
        $user = Auth::user();

        Favorite::create([
            'user_id' => $user->id,
            'shop_id' => $request->shop_id,
        ]);

        return redirect()->back();
    }

    public function favorite(Request $request)
    {
        if ( $request->input('favorite') == 0) {
            //ステータスが0のときはデータベースに情報を保存
            Favorite::create([
                'shop_id' => $request->input('shop_id'),
                'user_id' => auth()->user()->id,
            ]);
           //ステータスが1のときはデータベースに情報を削除
        } elseif ( $request->input('favorite')  == 1 ) {
            Favorite::where('shop_id', "=", $request->input('shop_id'))
                ->where('user_id', "=", auth()->user()->id)
                ->delete();
        }
        return  $request->input('favorite');
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
        $reservations = Reservation::where('user_id',$user->id)->get();
        $favorites = Favorite::where('user_id',$user->id)->get();
        $today = Carbon::today()->format('Y-m-d');

        return view('mypage', compact('user', 'reservations', 'favorites', 'today'));
    }
}
