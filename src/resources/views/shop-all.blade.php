@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop-all.css')}}">
@endsection

@section('shop_search')
<div class="shop__search">
    <form class="search-form" action="/" method="get">
        @csrf
        <div class="search-form__select">
            <select class="search-form__area-select" name="area">
                <option disabled selected>All area</option>
                @foreach($areas as $area)
                <option value="{{ $area->id }}" @if(request('area')==$area->id) selected @endif>{{$area->area_name}}
                </option>
                @endforeach
            </select>
        </div>
        <div class="search-form__select">
            <select class="search-form__genre-select" name="genre">
                <option disabled selected>All genre</option>
                @foreach($genres as $genre)
                <option value="{{ $genre->id }}" @if(request('genre')==$genre->id) selected @endif>{{$genre->genre_name}}
                </option>
                @endforeach
            </select>
        </div>
        <div class="search-form__input">
            <input class="search-form__keyword" type="text" name="keyword" id="search-text" placeholder="Search ..." value="{{request('keyword')}}">
        </div>
        <input class="search-form__btn" type="submit" value="検索">
    </form>
</div>
@endsection

@section('content')
<div class="card__flex">
    @foreach($shops as $shop)
    <div class="card">
        <div class="card__img">
            <img src="{{$shop->image}}" alt="shop_image" />
        </div>
        <div class="card__content">
            <div class="card__content-top">
                <h3 class="card__content-ttl">
                    {{$shop->shop_name}}
                </h3>
                <div class="card__content-review">
                    @php
                        $star_avg = App\Models\Review::where('shop_id',$shop->id)->avg('star');
                        $star_avg = substr($star_avg, 0, 4);
                        $review_count = App\Models\Review::where('shop_id',$shop->id)->count();
                    @endphp
                    <div class="review__star">
                        @if(empty($star_avg))
                            <span class="star star0"></span>
                        @elseif($star_avg >= 1 && $star_avg <= 1.4)
                            <span class="star star1"></span>
                        @elseif($star_avg >= 1.5 && $star_avg < 2)
                            <span class="star star1-5"></span>
                        @elseif($star_avg >= 2 && $star_avg <= 2.4)
                            <span class="star star2"></span>
                        @elseif($star_avg >= 2.5 && $star_avg < 3)
                            <span class="star star2-5"></span>
                        @elseif($star_avg >= 3 && $star_avg <= 3.4)
                            <span class="star star3"></span>
                        @elseif($star_avg >= 3.5 && $star_avg < 4)
                            <span class="star star3-5"></span>
                        @elseif($star_avg >= 4 && $star_avg <= 4.4)
                            <span class="star star4"></span>
                        @elseif($star_avg >= 4.5 && $star_avg < 5)
                            <span class="star star4-5"></span>
                        @elseif($star_avg == 5)
                            <span class="star star5"></span>
                        @endif
                    </div>
                    @if($review_count == 0)
                        <p class="review__count">(0件)</p>
                    @else
                        <p class="star__avg">{{$star_avg}}</p>
                        <a class="review__count" href="#{{$shop->id}}">({{$review_count}}件)</a>
                    @endif
                </div>
            </div>
            <div class="card__content-tag">
                <p class="card__content-tag-item">#{{$shop->area->area_name}}</p>
                <p class="card__content-tag-item">#{{$shop->genre->genre_name}}</p>
            </div>
            <div class="card__content-btn">
                <form class="shop-detail__form" action="/detail/{shop_id}" method="get">
                @csrf
                    <input class="shop-detail__input" type="hidden" name="id" value="{{$shop->id}}">
                    <button class="shop-detail__btn" type="submit">詳しくみる</button>
                </form>
                <div class="favorite">
            @php
                $favorite = App\Models\Favorite::where('user_id',$user->id)->where('shop_id',$shop->id)->first();
            @endphp
            @if(empty($favorite))
                <form class="favorite__form" action="/favorite" method="post">
                @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <button class="gray-heart" type="submit"></button>
                </form>
            @else
                <form class="favorite__form" action="/favorite_delete" method="post">
                @method('DELETE')
                @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <button class="red-heart" type="submit"></button>
                </form>
            @endif
                </div>
            </div>
        </div>
    </div>
    <!--レビュ一覧ーモーダル-->
    <div class="modal" id="{{$shop->id}}">
        <a href="#!" class="modal-overlay"></a>
        <div class="modal__inner">
            <div class="modal-review__content">
                <h4 class="modal__ttl">お店のレビュー</h4>
                @foreach($reviews as $review)
                @if($review->shop_id == $shop->id)
                <div class="review__content">
                    <table class="modal-review-all__table">
                        <tr class="modal-review-all__row">
                            <th class="modal-review__label">投稿者</th>
                            <td class="modal-review__data">{{$review->user->name}}</td>
                        </tr>
                        <tr class="modal-review-all__row">
                            <th class="modal-review__label">評価点</th>
                            <td class="modal-review__data">
                                <div class="review__star">
                                @if($review->star == 1)
                                    <span class="yellow-star">★</span><span class="gray-star">★★★★</span>
                                @elseif($review->star == 2)
                                    <span class="yellow-star">★★</span><span class="gray-star">★★★</span>
                                @elseif($review->star == 3)
                                    <span class="yellow-star">★★★</span><span class="gray-star">★★</span>
                                @elseif($review->star == 4)
                                    <span class="yellow-star">★★★★</span><span class="gray-star">★</span>
                                @elseif($review->star == 5)
                                    <span class="yellow-star">★★★★★</span>
                                @endif
                                </div>
                            </td>
                        </tr>
                        <tr class="modal-review-all__row">
                            <th class="modal-review__label">コメント</th>
                            <td class="modal-review__data">{{$review->comment}}</td>
                        </tr>
                    </table>
                </div>
                @endif
                @endforeach
            </div>
            <a href="#" class="modal__close-btn">×</a>
        </div>
    </div>
    @endforeach
    @for ($i = 0; $i < 3; $i++)
        <div class="card dummy"></div>
    @endfor
</div>
@endsection