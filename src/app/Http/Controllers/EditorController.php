<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\ShopRepresentative;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditorController extends Controller
{
    public function admin()
    {
        $user = Auth::user();
        $areas = Area::all();
        $genres = Genre::all();
        $shop_representative = ShopRepresentative::where('user_id', $user->id)->first();

        if(!empty($shop_representative)) {
            $reservations = Reservation::where('shop_id', $shop_representative->shop_id)->orderBy('date', 'asc')->orderBy('time', 'asc')->paginate(8);
        } else {
            $reservations = null;
        }

        return view('editor.shop-admin', compact('user', 'areas', 'genres', 'shop_representative', 'reservations'));
    }

    public function create(Request $request)
    {
        $shop = Shop::create(
            $request->only([
                'name',
                'area_id',
                'genre_id',
                'summary',
                'image',
            ])
        );

        $user = Auth::user();

        ShopRepresentative::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);

        return view('editor.done');
    }

    public function update(Request $request)
    {
        $shop = Shop::find($request->id);
        $shop->update(
            $request->only([
                'name',
                'area_id',
                'genre_id',
                'summary',
                'image',
            ])
        );

        return redirect()->back()->with('message','店舗情報を更新しました');
    }
}
