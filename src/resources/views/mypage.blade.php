@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('content')
<div class="mypage__ttl-container">
    <h2 class="mypage__ttl">{{ $user->name }}さん</h2>
</div>

<div class="mypage__content">
    <div class="reservation__container">
        <h3 class="reservation-container__ttl">予約状況</h3>
        @foreach($reservations as $reservation)
        @if((($reservation->date==$today) && ($reservation->time>$now)) || ($reservation->date>$today))
        <div class="reservation__content">
            <div class="reservation__flex">
                <div class="reservation__content-ttl">
                    <h4>予約{{$loop->iteration}}</h4>
                </div>
                <div class="reservation__delete">
                    <form class="reservation__delete-form" action="/reservation_delete" method="post">
                    @method('DELETE')
                    @csrf
                        <input class="reservation__delete-input" type="hidden" name="id" value="{{$reservation->id}}">
                        <button class="reservation__delete-btn" type="submit"></button>
                    </form>
                </div>
            </div>
            <div class="reservation__content-table">
                <table class="reservation__table">
                    <tr class="reservation__row">
                        <th class="reservation__label">Shop</th>
                        <td class="reservation__data">{{ $reservation->shop->name }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Date</th>
                        <td class="reservation__data">{{ $reservation->date }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Time</th>
                        <td class="reservation__data">{{ substr($reservation->time, 0, 5) }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Number</th>
                        <td class="reservation__data">{{ $reservation->number }}人</td>
                    </tr>
                </table>
            </div>
            <div class="reservation-update">
                <a class="reservation-update__btn" href="#{{$reservation->id}}">予約を変更する</a>
            </div>
            <!--予約変更モーダル-->
            <div class="modal" id="{{$reservation->id}}">
                <a href="#!" class="modal-overlay"></a>
                <div class="modal__inner">
                    <div class="modal__content">
                        <div class="modal__ttl">
                            <h4>予約の変更</h4>
                        </div>
                        <div class="modal-reservation__content-table">
                            <table class="modal-reservation__table">
                                <form class="modal-reservation__update-form" action="/reservation_update" method="POST">
                                @method('PATCH')
                                @csrf
                                    <tr class="modal-reservation__row">
                                        <th class="modal-reservation__label">Shop</th>
                                        <td class="modal-reservation__data">{{ $reservation->shop->name }}</td>
                                    </tr>
                                    <tr class="modal-reservation__row">
                                        <th class="modal-reservation__label">Date</th>
                                        <td class="modal-reservation__data">
                                            <input id="select_date" type="date"  min="{{$tomorrow}}" name="date" value="{{ $reservation->date }}">
                                        </td>
                                        <div class="form__error__container">
                                            <div class="form__error">
                                                @error('date')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </tr>
                                    <tr class="modal-reservation__row">
                                        <th class="modal-reservation__label">Time</th>
                                        <td class="modal-reservation__data-select">
                                            <select id="select_time" name="time">
                                                <option value="17:00" @if(substr($reservation->time, 0, 5)=="17:00") selected @endif>17:00</option>
                                                <option value="17:30" @if(substr($reservation->time, 0, 5)=="17:30") selected @endif>17:30</option>
                                                <option value="18:00" @if(substr($reservation->time, 0, 5)=="18:00") selected @endif>18:00</option>
                                                <option value="18:30" @if(substr($reservation->time, 0, 5)=="18:30") selected @endif>18:30</option>
                                                <option value="19:00" @if(substr($reservation->time, 0, 5)=="19:00") selected @endif>19:00</option>
                                                <option value="19:30" @if(substr($reservation->time, 0, 5)=="19:30") selected @endif>19:30</option>
                                                <option value="20:00" @if(substr($reservation->time, 0, 5)=="20:00") selected @endif>20:00</option>
                                            </select>
                                        </td>
                                        <div class="form__error__container">
                                            <div class="form__error">
                                                @error('time')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </tr>
                                    <tr class="modal-reservation__row">
                                        <th class="modal-reservation__label">Number</th>
                                        <td class="modal-reservation__data-select">
                                            <select id="select_number" name="number">
                                                <option value="1" @if($reservation->number=="1") selected @endif>1人</option>
                                                <option value="2" @if($reservation->number=="2") selected @endif>2人</option>
                                                <option value="3" @if($reservation->number=="3") selected @endif>3人</option>
                                                <option value="4" @if($reservation->number=="4") selected @endif>4人</option>
                                                <option value="5" @if($reservation->number=="5") selected @endif>5人</option>
                                            </select>
                                        </td>
                                        <div class="form__error__container">
                                            <div class="form__error">
                                                @error('number')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </tr>
                                </table>
                                <div class="modal-form__button">
                                    <input type="hidden" name="id" value="{{ $reservation->id }}">
                                    <button class="modal-form__button-submit" type="submit">変更する</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="#" class="modal__close-btn">×</a>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        @foreach($visits as $visit)
        @if((($visit->date==$today) && ($visit->time<=$now)) || ($visit->date<$today))
        <div class="visit__content">
            <div class="visit__content-ttl">
                <h4>来店済み</h4>
            </div>
            <div class="reservation__content-table">
                <table class="reservation__table">
                    <tr class="reservation__row">
                        <th class="reservation__label">Shop</th>
                        <td class="reservation__data">{{ $visit->shop->name }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Date</th>
                        <td class="reservation__data">{{ $visit->date }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Time</th>
                        <td class="reservation__data">{{ substr($visit->time, 0, 5) }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Number</th>
                        <td class="reservation__data">{{ $visit->number }}人</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
    @endforeach
    </div>

    <div class="favorite__container">
        <h3 class="favorite-container__ttl">お気に入り店舗</h3>
        <div class="card__container">
            @foreach($favorites as $favorite)
            <div class="card">
                <div class="card__img">
                    <img src="{{ $favorite->shop->image }}" alt="shop_image" />
                </div>
                <div class="card__content">
                    <div class="card__content-top">
                        <h3 class="card__content-ttl">
                                {{ $favorite->shop->name }}
                            </h3>
                        <div class="card__content-review">
                            @php
                                $star_avg = App\Models\Review::where('shop_id',$favorite->shop_id)->avg('star');
                                $star_avg = substr($star_avg, 0, 4);
                                $review_count = App\Models\Review::where('shop_id',$favorite->shop_id)->count();
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
                                <a class="review__count" href="#{{$favorite->shop->name}}">({{$review_count}}件)</a>
                            @endif
                        </div>
                    </div>
                    <div class="card__content-tag">
                        <p class="card__content-tag-item">#{{ $favorite->shop->area->name }}</p>
                        <p class="card__content-tag-item card__content-tag-item--last">
                            #{{ $favorite->shop->genre->name }}
                        </p>
                    </div>
                    <div class="card__content-btn">
                        <form class="shop-detail__form" action="{{ route('detail', ['shop_id' => $favorite->shop->id]) }}" method="get">
                        @csrf
                            <button class="shop-detail__btn" type="submit">詳しくみる</button>
                        </form>
                        <form class="favorite__form" action="/favorite_delete" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="shop_id" value="{{ $favorite->shop->id }}">
                            <button class="favorite__btn" type="submit"></button>
                        </form>
                    </div>
                </div>
            </div>
            <!--レビュ一覧ーモーダル-->
            <div class="modal" id="{{$favorite->shop->name}}">
                <a href="#!" class="modal-overlay"></a>
                <div class="modal__inner">
                    <div class="modal-review__content">
                        <a href="#" class="modal__close-btn">×</a>
                        <h4 class="modal__ttl">お店のレビュー</h4>
                        @foreach($reviews as $review)
                        @if($review->shop_id == $favorite->shop_id)
                        <div class="review__content">
                            <table class="modal-review-all__table">
                                <tr class="modal-review-all__row">
                                    <th class="modal-review-all__label">投稿者</th>
                                    <td class="modal-review-all__data">{{$review->user->name}}</td>
                                </tr>
                                <tr class="modal-review-all__row">
                                    <th class="modal-review-all__label">評価点</th>
                                    <td class="modal-review-all__data">
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
                                    <th class="modal-review-all__label">コメント</th>
                                    <td class="modal-review-all__data">{{$review->comment}}</td>
                                </tr>
                                @if($review->image)
                                <tr class="modal-review-all__row">
                                    <th class="modal-review-all__label">画像</th>
                                    <td class="modal-review-all__data">
                                        <img class="review__img" src="{{ $review->image }}" alt="review_image" />
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            <div class="card dummy"></div>
        </div>
    </div>
</div>
@endsection