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
                <option value="東京都">東京都</option>
                <option value="大阪府">大阪府</option>
                <option value="福岡県">福岡県</option>
            </select>
        </div>
        <div class="search-form__select">
            <select class="search-form__genre-select" name="genre">
                <option disabled selected>All genre</option>
                <option value="寿司">寿司</option>
                <option value="焼肉">焼肉</option>
                <option value="居酒屋">居酒屋</option>
                <option value="イタリアン">イタリアン</option>
                <option value="ラーメン">ラーメン</option>
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
            <h3 class="card__content-ttl">
                {{$shop->shop_name}}
            </h3>
            <div class="card__content-review">

            </div>
            <div class="card__content-tag">
                <p class="card__content-tag-item">#{{$shop->area}}</p>
                <p class="card__content-tag-item">#{{$shop->genre}}</p>
            </div>
            <div class="card__content-btn">
                <form class="shop-detail__form" action="/detail/{shop_id}" method="get">
                @csrf
                    <input class="shop-detail__input" type="hidden" name="id" value="{{$shop->id}}">
                    <button class="shop-detail__btn" type="submit">詳しくみる</button>
                </form>
                <div class="favorite">
            <?php $favorite = App\Models\Favorite::where('user_id',$user->id)->where('shop_id',$shop->id)->first();?>
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
    @endforeach
</div>
@endsection