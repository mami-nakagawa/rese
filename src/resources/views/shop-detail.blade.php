@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop-detail.css')}}">
@endsection

@section('content')
<div class="shop-detail">
    <a class="home__link" href="/"><</a>
    <h2 class="card__content-ttl">
        {{$shop->shop_name}}
    </h2>
    <div class="shop-detail__img">
        <img src="{{$shop->image}}" alt="shop_image" />
    </div>
    <div class="shop-detail-tag">
        <p class="card__content-tag-item">#{{$shop->area}}</p>
        <p class="card__content-tag-item card__content-tag-item--last">
            #{{$shop->genre}}
        </p>
    </div>
    <div class="shop-detail-text">
        <p class="card__content-tag-item">{{$shop->detail}}</p>
    </div>
</div>
@endsection