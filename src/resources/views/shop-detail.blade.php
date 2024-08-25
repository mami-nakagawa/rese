@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop-detail.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="shop-detail">
        <div class="shop-detail__flex">
            <a class="home__link" href="/">＜</a>
            <h2 class="shop-detail__ttl">
                {{$shop->name}}
            </h2>
        </div>
        <div class="shop-detail__flex">
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
        <div class="shop-detail__img">
            <img src="{{$shop->image}}" alt="shop_image" />
        </div>
        <div class="shop-detail__tag">
            <p class="tag__item">#{{$shop->area->name}}</p>
            <p class="tag__item--last">#{{$shop->genre->name}}</p>
        </div>
        <div class="shop-detail__text">
            <p class="detail__text">{{$shop->summary}}</p>
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
                            @if($review->image)
                            <tr class="modal-review-all__row">
                                <th class="modal-review__label">画像</th>
                                <td class="modal-review__data">
                                    <img class="review__img" src="{{ asset('storage/reviews/'.$review->image) }}" alt="review_image" />
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
    </div>
    <div class="reservation">
        <div class="reservation__content">
        <h2 class="reservation__ttl">予約</h2>
        <form action="/reservation" method="post">
            @csrf
            <div class="reservation__form">
                <div class="form__group">
                    <div class="form__input">
                        <input id="select_date" type="date" min="{{$tomorrow}}" name="date" value="{{ old('date') }}">
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
                            <option value="17:00" @if(old('time')=="17:00") selected @endif>17:00</option>
                            <option value="17:30" @if(old('time')=="17:30") selected @endif>17:30</option>
                            <option value="18:00" @if(old('time')=="18:00") selected @endif>18:00</option>
                            <option value="18:30" @if(old('time')=="18:30") selected @endif>18:30</option>
                            <option value="19:00" @if(old('time')=="19:00") selected @endif>19:00</option>
                            <option value="19:30" @if(old('time')=="19:30") selected @endif>19:30</option>
                            <option value="20:00" @if(old('time')=="20:00") selected @endif>20:00</option>
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
                            <option value="1" @if(old('number')=="1") selected @endif>1人</option>
                            <option value="2" @if(old('number')=="2") selected @endif>2人</option>
                            <option value="3" @if(old('number')=="3") selected @endif>3人</option>
                            <option value="4" @if(old('number')=="4") selected @endif>4人</option>
                            <option value="5" @if(old('number')=="5") selected @endif>5人</option>
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
            <div class="confirm__container">
                <table class="confirm__table">
                    <tr class="confirm__row">
                        <th class="confirm__label">Shop</th>
                        <td class="confirm__data">{{ $shop->name }}</td>
                    </tr>
                    <tr class="confirm__row">
                        <th class="confirm__label">Date</th>
                        <td class="confirm__data"><div id="selectValueDate"></div></td>
                    </tr>
                    <tr class="confirm__row">
                        <th class="confirm__label">Time</th>
                        <td class="confirm__data"><div id="selectValueTime"></div></td>
                    </tr>
                    <tr class="confirm-form__row">
                        <th class="confirm__label">Number</th>
                        <td class="confirm__data"><div id="selectValueNumber"></div>人</td>
                    </tr>
                </table>
            </div>
            </div>
            <div class="form__button">
                @if (Auth::check())
                    <input id="select_date" type="hidden" name="user_id" value="{{ $user->id }}">
                @endif
                <input id="select_date" type="hidden" name="shop_id" value="{{ $shop->id }}">
                <button class="form__button-submit" type="submit">予約する</button>
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