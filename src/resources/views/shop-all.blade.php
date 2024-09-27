@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop-all.css')}}">
@endsection

@section('shop_sort')
@if (Auth::check())
    @role('admin|editor')
    <div></div>
    @else
    <div class="shop__sort">
        <form id="sort__form">
            @csrf
            <div class="sort-form__select">
                <select name="sort" id="sort__select">
                    <option selected hidden>並び替え：評価高/低</option>
                    <option value="1" @if(request('sort')==1) selected @endif>ランダム</option>
                    <option value="2" @if(request('sort')==2) selected @endif>評価が高い順</option>
                    <option value="3" @if(request('sort')==3) selected @endif>評価が低い順</option>
                </select>
            </div>
        </form>
    </div>
    @endrole
@endif
@endsection

@section('shop_search')
<div class="shop__search">
    <form id="search__form" class="search-form">
        @csrf
        <div class="search-form__select">
            <select class="search-form__area-select" name="area" id="area__select">
                <option value="all" selected>All area</option>
                @foreach($areas as $area)
                <option value="{{ $area->id }}" @if(request('area')==$area->id) selected @endif>{{$area->name}}
                </option>
                @endforeach
            </select>
        </div>
        <div class="search-form__select">
            <select class="search-form__genre-select" name="genre" id="genre__select">
                <option value="all" selected>All genre</option>
                @foreach($genres as $genre)
                <option value="{{ $genre->id }}" @if(request('genre')==$genre->id) selected @endif>{{$genre->name}}
                </option>
                @endforeach
            </select>
        </div>
        <div class="search-form__input">
            <input class="search-form__keyword" type="text" name="keyword" id="search-text" placeholder="Search ..." value="{{request('keyword')}}">
        </div>
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
                    {{$shop->name}}
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
                <p class="card__content-tag-item">#{{$shop->area->name}}</p>
                <p class="card__content-tag-item">#{{$shop->genre->name}}</p>
            </div>
            <div class="card__content-btn">
                <form class="shop-detail__form" action="{{ route('detail', ['shop_id' => $shop->id]) }}" method="get">
                @csrf
                    <button class="shop-detail__btn" type="submit">詳しくみる</button>
                </form>
                <div class="favorite">
            @if (Auth::check())
                @php
                    $favorite = App\Models\Favorite::where('user_id',$user->id)->where('shop_id',$shop->id)->first();
                @endphp
            @endif
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
                    @role('admin')
                        <div class="modal-review__delete">
                            <form class="modal-review__delete-form" action="/review/delete" method="post">
                            @method('DELETE')
                            @csrf
                                <input class="modal-review__delete-input" type="hidden" name="id" value="{{$review->id}}">
                                <button class="modal-review-delete__btn" type="submit">口コミを削除</button>
                            </form>
                        </div>
                    @endrole
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
                        @if($review->image)
                        <tr class="modal-review-all__row">
                            <th class="modal-review__label">画像</th>
                            <td class="modal-review__data">
                                <img class="review__img" src="{{ $review->image }}" alt="review_image" />
                            </td>
                        </tr>
                        @endif
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

@section('script')
<!--ソート-->
<script>
    $(function() {
        $('#sort__select').change(function () {
            $('#sort__form').submit();
        });
    });

    $(function() {
        $('#area__select').change(function () {
            $('#search__form').submit();
        });
    });

    $(function() {
        $('#genre__select').change(function () {
            $('#search__form').submit();
        });
    });

    $(function() {
        $('#search-text').change(function () {
            $('#search__form').submit();
        });
    });
</script>
@endsection