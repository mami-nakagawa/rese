@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('content')
<h2 class="reservation-ttl">{{ $user->name }}さん</h2>

<div class="reservation__container">
    <h3 class="container__ttl">予約状況</h3>
    @foreach($reservations as $reservation)
    <div class="reservation">
        <div class="reservation__content-ttl">
            <h4>予約</h4>
        </div>
        <div class="reservation__content-form">
            <form class="reservation__form" action="/reservation_delete" method="post">
            @method('DELETE')
            @csrf
                <input class="reservation__input" type="hidden" name="id" value="{{$reservation->id}}">
                <button class="reservation__btn" type="submit">×</button>
            </form>
        </div>
        <div class="reservation__content-table">
            <table class="reservation__table">
                <tr class="reservation__row">
                    <th class="reservation__label">Shop</th>
                    <td class="reservation__data">{{ $reservation->shop->shop_name }}</td>
                </tr>
                <tr class="reservation__row">
                    <th class="reservation__label">Date</th>
                    <td class="reservation__data">{{ $reservation->date }}</td>
                </tr>
                <tr class="reservation__row">
                    <th class="reservation__label">Time</th>
                    <td class="reservation-form__data">{{ substr($reservation->time, 0, 5) }}</td>
                </tr>
                <tr class="reservation-form__row">
                    <th class="reservation__label">Number</th>
                    <td class="reservation-form__data">{{ $reservation->number }}</td>
                </tr>
            </table>
        </div>
    </div>
@endforeach
</div>

<div class="favorite__container">
    <h3 class="container-ttl">お気に入り店舗</h3>
    @foreach($favorites as $favorite)
    <div class="card">
        <div class="card__img">
            <img src="{{ $favorite->shop->image }}" alt="shop_image" />
        </div>
        <div class="card__content">
            <h3 class="card__content-ttl">
                {{ $favorite->shop->shop_name }}
            </h3>
            <div class="card__content-tag">
                <p class="card__content-tag-item">#{{ $favorite->shop->area }}</p>
                <p class="card__content-tag-item card__content-tag-item--last">
                    #{{ $favorite->shop->genre }}
                </p>
            </div>
            <div class="card__content-favorite">
                <form class="shop-detail__form" action="/detail/{shop_id}" method="get">
                @csrf
                    <input class="shop-detail__input" type="hidden" name="id" value="{{ $favorite->shop->id }}">
                    <button class="shop-detail__btn" type="submit">詳しくみる</button>
                </form>
                <form class="favorite__form" action="/favorite_delete" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $favorite->shop->id }}">
                    <button class="favorite__btn" type="submit">&#x2764</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection