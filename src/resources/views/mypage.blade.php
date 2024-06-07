@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('content')
<h2 class="reservation-ttl">{{$user->name}}さん</h2>

<div class="reservation__container">
    <h2 class="reservation__ttl">予約状況</h2>
    @foreach($reservations as $reservation)
    <div class="reservation">
        <div class="reservation__content">
            <h3 class="reservation__content-ttl">
                {{$reservation->shop->shop_name}}
            </h3>
            <form class="reservation__form" action="/detail/{shop_id}" method="get">
            @csrf
                <input class="reservation__input" type="hidden" name="id" value="{{$reservation->shop->id}}">
                <button class="reservation__btn" type="submit">×</button>
            </form>
            <div class="card__content-tag">
                <p class="card__content-tag-item">#{{$reservation->shop->area}}</p>
                <p class="card__content-tag-item card__content-tag-item--last">
                    #{{$reservation->shop->genre}}
                </p>
            </div>
            <div class="card__content-favorite">&#x2764</div>
        </div>
    </div>
@endforeach
</div>

<div class="favorite__container">
    <h2 class="favorite-ttl">お気に入り店舗</h2>
    @foreach($favorites as $favorite)
    <div class="card">
        <div class="card__img">
            <img src="{{$favorite->shop->image}}" alt="shop_image" />
        </div>
        <div class="card__content">
            <h3 class="card__content-ttl">
                {{$favorite->shop->shop_name}}
            </h3>
            <div class="card__content-tag">
                <p class="card__content-tag-item">#{{$favorite->shop->area}}</p>
                <p class="card__content-tag-item card__content-tag-item--last">
                    #{{$favorite->shop->genre}}
                </p>
            </div>
            <form class="shop-detail__form" action="/detail/{shop_id}" method="get">
            @csrf
                <input class="shop-detail__input" type="hidden" name="id" value="{{$favorite->shop->id}}">
                <button class="shop-detail__btn" type="submit">詳しくみる</button>
            </form>
            <div class="card__content-favorite">&#x2764</div>
        </div>
    </div>
    @endforeach
</div>
@endsection