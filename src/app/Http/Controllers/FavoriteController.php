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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FavoriteController extends Controller
{
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
}
