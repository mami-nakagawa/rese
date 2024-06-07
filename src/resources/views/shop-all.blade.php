@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop-all.css')}}">
@endsection

@section('shop_search')

@endsection

@section('content')

@foreach($shops as $shop)
<div class="card">
    <div class="card__img">
        <img src="{{$shop->image}}" alt="shop_image" />
    </div>
    <div class="card__content">
        <h2 class="card__content-ttl">
            {{$shop->shop_name}}
        </h2>
        <div class="card__content-tag">
            <p class="card__content-tag-item">#{{$shop->area}}</p>
            <p class="card__content-tag-item card__content-tag-item--last">
                #{{$shop->genre}}
            </p>
        </div>
        <form class="shop-detail__form" action="/detail/{shop_id}" method="get">
        @csrf
            <input class="shop-detail__input" type="hidden" name="id" value="{{$shop->id}}">
            <button class="shop-detail__btn" type="submit">詳しくみる</button>
        </form>
        <div class="card__content-favorite">&#x2764</div>
    </div>
</div>
@endforeach

@endsection
