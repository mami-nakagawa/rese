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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
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

        return redirect()->route('done');
    }

    public function done()
    {
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

    public function qrcode($id)
    {
        $reservation = Reservation::where('id',$id)->first();

        return view('qrcode', compact('reservation'));
    }
}
