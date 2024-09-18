@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop-admin.css') }}">
@endsection

@section('content')
<div class="admin__ttl-container">
    <h2 class="admin__ttl">{{ $user->name }}さん</h2>
</div>

@if(session('message'))
    <div class="update__message">
        {{ session('message') }}
    </div>
@endif

@if(empty($shop_representative))
<div class="admin__content">
    <div class="shop__container">
        <div class="card">
            <div class="card__heading">
                <p>店舗情報の登録</p>
            </div>
            <div class="card__content">
                <form class="form" action="/editor/create" method="post" enctype='multipart/form-data'>
                @csrf
                    <div class="form__group">
                        <div class="form__input">
                            <div class="form__label">店舗名:</div>
                            <input class="input" type="text" name="name" value="{{ old('name') }}" />
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__select">
                            <div class="form__label">地域:</div>
                            <select class="select" name="area_id">
                                <option disabled selected>選択して下さい</option>
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}" @if(old('area_id')==$area->id) selected @endif>{{$area->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('area_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__select">
                            <div class="form__label">ジャンル:</div>
                            <select class="select" name="genre_id">
                                <option disabled selected>選択して下さい</option>
                                @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" @if(old('genre_id')==$genre->id) selected @endif>{{$genre->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('genre_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__text">
                            <div class="form__label">店舗概要:</div>
                            <textarea class="text__summary" name="summary" cols="30" rows="6">{{ old('summary') }}</textarea>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('summary')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__input">
                            <div class="form__label">画像:</div>
                            <input class="input file" type="file" name="image" value="{{ old('image') }}" />
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('image')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__button">
                        <button class="form__button-submit" type="submit">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="check-reservation__container">
        <div class="check-reservation__ttl">
            <p>予約情報の確認</p>
        </div>
        <div class="check-reservation__content">
            <p>店舗情報を登録して下さい</p>
        </div>
    </div>
</div>
@else
<div class="admin__content">
    <div class="shop__container">
        <div class="card">
            <div class="card__heading">
                <p>店舗情報の更新</p>
            </div>
            <div class="card__content">
                <form class="form" action="/editor/update" method="post" enctype='multipart/form-data'>
                @csrf
                    <div class="form__group">
                        <div class="form__input">
                            <div class="form__label">店舗名:</div>
                            <input class="input" type="text" name="name" value="{{ $shop_representative->shop->name }}" />
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__select">
                            <div class="form__label">地域:</div>
                            <select class="select" name="area_id">
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}" @if(($shop_representative->shop->area_id)==$area->id) selected @endif>{{$area->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('area_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__select">
                            <div class="form__label">ジャンル:</div>
                            <select class="select" name="genre_id">
                                @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" @if(($shop_representative->shop->genre_id)==$genre->id) selected @endif>{{$genre->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('genre_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__text">
                            <div class="form__label">店舗概要:</div>
                            <textarea class="text__summary" name="summary" cols="30" rows="6">{{ $shop_representative->shop->summary }}</textarea>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('summary')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__input--file">
                            <div class="form__label--file">画像:</div>
                            <div class="shop-img__container">
                                <p>現在の画像</p>
                                <img class="shop__img" src="{{$shop_representative->shop->image}}" alt="shop_image" />
                            </div>
                            <div class="new-file__container">
                                <p>画像を変更する</p>
                                <input class="input new__file" type="file" name="image"/>
                            </div>
                        </div>
                    </div>
                    <div class="form__button">
                        <input type="hidden" name="id" value="{{ $shop_representative->shop->id }}">
                        <button class="form__button-submit" type="submit">更新</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="check-reservation__container">
        <div class="check-reservation__flex">
            <div class="check-reservation__ttl">
                <p>予約情報の確認</p>
            </div>
            <a class="scan__btn" href="/editor/scan">QRコード読み取り</a>
        </div>
        <table class="reservation__table">
            <tr class="reservation__row">
                <th class="reservation__label">予約ID</th>
                <th class="reservation__label">お名前</th>
                <th class="reservation__label">日付</th>
                <th class="reservation__label">時間</th>
                <th class="reservation__label">人数</th>
            </tr>
            @foreach($reservations as $reservation)
            <tr class="reservation__row">
                <td class="reservation__data">{{$reservation->id}}</td>
                <td class="reservation__data">{{$reservation->user->name}}</td>
                <td class="reservation__data">{{$reservation->date}}</td>
                <td class="reservation__data">{{substr($reservation->time, 0, 5)}}</td>
                <td class="reservation__data">{{$reservation->number}}人</td>
            </tr>
            @endforeach
        </table>
        {{ $reservations->links('vendor.pagination.custom') }}
    </div>
</div>
@endif
@endsection