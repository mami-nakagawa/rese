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
    public function index($shop_id)
    {
        $user = Auth::user();
        $shop = Shop::where('id',$shop_id)->first();
        $reviews = Review::all();
        $user_review = Review::where('shop_id',$shop_id)->where('user_id',$user->id)->first();

        return view('review.review', compact('user', 'shop', 'reviews', 'user_review'));
    }

    public function create(ReviewRequest $request)
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

        $create = 1;

        return view('review.done', compact('create'));
    }

    public function update(ReviewRequest $request)
    {
        $review = Review::find($request->id);

        if($request->file('image')){
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('/', $image);
            $image = Storage::disk('s3')->url($path);
        } elseif(!$request->file('image') && $review->image) {
            $image = $review->image;
        } else {
            $image = null;
        }

        $review->update([
            'star' => $request->star,
            'comment' => $request->comment,
            'image' => $image,
        ]);

        return view('review.done');
    }

    public function destroy(Request $request)
    {
        Review::find($request->id)->delete();

        return redirect()->back();
    }
}
