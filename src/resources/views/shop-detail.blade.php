@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop-detail.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="shop-detail">
        <a class="home__link" href="/"><</a>
        <h2 class="shop-detail-ttl">
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
    <div class="reservation">
        <h2 class="reservation-ttl">予約</h2>
        <form action="/done" method="post">
            @csrf
            <div class="reservation__form">
                <div class="form__group">
                    <div class="form__input">
                        <input id="select_date" type="date" min="{{$tomorrow}}" name="date">
                    </div>
                    <div class="form__error__container">
                        <div class="form__error">
                            @error('date')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__select">
                        <select id="select_time" name="time">
                            <option disabled selected>予約時間</option>
                            <option value="17:00">17:00</option>
                            <option value="17:30">17:30</option>
                            <option value="18:00">18:00</option>
                            <option value="18:30">18:30</option>
                            <option value="19:00">19:00</option>
                            <option value="19:30">19:30</option>
                            <option value="20:00">20:00</option>
                        </select>
                    </div>
                    <div class="form__error__container">
                        <div class="form__error">
                            @error('time')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__select">
                        <select id="select_number" name="number">
                            <option disabled selected>予約人数</option>
                            <option value="1人">1人</option>
                            <option value="2人">2人</option>
                            <option value="3人">3人</option>
                            <option value="4人">4人</option>
                            <option value="5人">5人</option>
                        </select>
                    </div>
                    <div class="form__error__container">
                        <div class="form__error">
                            @error('number')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="confirm-form">
                <table class="confirm__table">
                    <tr class="confirm__row">
                        <th class="confirm__label">Shop</th>
                        <td class="confirm__data">{{ $shop->shop_name }}</td>
                    </tr>
                    <tr class="confirm__row">
                        <th class="confirm__label">Date</th>
                        <td class="confirm__data"><div id="selectValueDate"></div></td>
                    </tr>
                    <tr class="confirm__row">
                        <th class="confirm__label">Time</th>
                        <td class="confirm-form__data"><div id="selectValueTime"></div></td>
                    </tr>
                    <tr class="confirm-form__row">
                        <th class="confirm__label">Number</th>
                        <td class="confirm-form__data"><div id="selectValueNumber"></div></td>
                    </tr>
                </table>
                <div class="form__button">
                    <input id="select_date" type="hidden" name="user_id" value="{{ $user->id }}">
                    <input id="select_date" type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <button class="form__button-submit" type="submit">予約する</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
    <script>
        var select = document.getElementById('select_date');
        select.addEventListener('change', (e) => {
        var selectValue = document.getElementById('selectValueDate');
        selectValue.innerHTML = e.target.value;
        });

        var select = document.getElementById('select_time');
        select.addEventListener('change', (e) => {
        var selectValue = document.getElementById('selectValueTime');
        selectValue.innerHTML = e.target.value;
        });

        var select = document.getElementById('select_number');
        select.addEventListener('change', (e) => {
        var selectValue = document.getElementById('selectValueNumber');
        selectValue.innerHTML = e.target.value;
        });
    </script>
@endsection