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
use App\Http\Requests\ReviewRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function review(ReviewRequest $request)
    {
        if($request->image){
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('/', $image);
            $image = Storage::disk('s3')->url($path);

        }else{
            $image = null;
        }

        Review::create([
            'user_id' => $request->user_id,
            'shop_id' => $request->shop_id,
            'star' => $request->star,
            'comment' => $request->comment,
            'image' => $image,
        ]);

        return redirect()->back();
    }
}
