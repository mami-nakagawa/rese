@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="shop-card__container">
        <h1 class="review__ttl">
            今回のご利用はいかがでしたか？
        </h1>
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
                <div class="modal__content">
                    <h4 class="modal__ttl">お店のレビュー</h4>
                    @foreach($reviews as $review)
                    @if($review->shop_id == $shop->id)
                    <div class="modal-review__content">
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
                <a href="#" class="modal__close-btn">×</a>
            </div>
        </div>
    </div>
    <div class="review__container">
        @if(!$user_review)
        <form class="review-form__form" action="/review/create" method="POST" enctype='multipart/form-data'>
            @csrf
                <div class="form__group">
                    <div class="form__input">
                        <p class="form__label">体験を評価してください</p>
                        <div class="stars">
                            <span>
                                <input type="radio" name="star" value="5" id="{{$shop->id}}_star1" @if(old('star')==5) checked @endif>
                                    <label for="{{$shop->id}}_star1">★</label>
                                <input type="radio" name="star" value="4" id="{{$shop->id}}_star2" @if(old('star')==4) checked @endif>
                                    <label for="{{$shop->id}}_star2">★</label>
                                <input type="radio" name="star" value="3" id="{{$shop->id}}_star3" @if(old('star')==3) checked @endif>
                                    <label for="{{$shop->id}}_star3">★</label>
                                <input type="radio" name="star" value="2" id="{{$shop->id}}_star4" @if(old('star')==2) checked @endif>
                                    <label for="{{$shop->id}}_star4">★</label>
                                <input type="radio" name="star" value="1" id="{{$shop->id}}_star5" @if(old('star')==1) checked @endif>
                                    <label for="{{$shop->id}}_star5">★</label>
                            </span>
                        </div>
                    </div>
                    <div class="form__error__container">
                        <div class="form__error">
                            @error('star')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__textarea">
                        <p class="form__label">口コミを投稿</p>
                        <textarea name="comment" onkeyup="ShowLength(value);" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ old('comment') }}</textarea>
                    <div id="inputlength">
                        0/400(最高文字数)
                    </div>
                    </div>
                    <div class="form__error__container">
                        <div class="form__error">
                            @error('comment')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <p class="form__label">画像の追加</p>
                    <div id="upFileWrap">
                        <div id="inputFile">
                            <p id="dropArea">クリックして写真を追加<br><span class="dropArea">またはドラッグアンドドロップ</span></p>
                            <div id="inputFileWrap">
                                <input class="file" id="uploadFile" type="file" accept="image/jpeg,image/png" name="image" value="{{ old('image') }}" />
                                <div id="btnInputFile"><span></span></div>
                            </div>
                        </div>
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
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <button class="form__button-submit" type="submit">口コミを投稿</button>
            </div>
        </form>
        @else
        <form class="review-form__form" action="/review/update" method="POST" enctype='multipart/form-data'>
            @method('PATCH')
            @csrf
                <div class="form__group">
                    <div class="form__input">
                        <p class="form__label">体験を評価してください</p>
                        <div class="stars">
                            <span>
                                <input type="radio" name="star" value="5" id="{{$shop->id}}_star1" @if($user_review->star==5) checked @endif>
                                    <label for="{{$shop->id}}_star1">★</label>
                                <input type="radio" name="star" value="4" id="{{$shop->id}}_star2" @if($user_review->star==4) checked @endif>
                                    <label for="{{$shop->id}}_star2">★</label>
                                <input type="radio" name="star" value="3" id="{{$shop->id}}_star3" @if($user_review->star==3) checked @endif>
                                    <label for="{{$shop->id}}_star3">★</label>
                                <input type="radio" name="star" value="2" id="{{$shop->id}}_star4" @if($user_review->star==2) checked @endif>
                                    <label for="{{$shop->id}}_star4">★</label>
                                <input type="radio" name="star" value="1" id="{{$shop->id}}_star5" @if($user_review->star==1) checked @endif>
                                    <label for="{{$shop->id}}_star5">★</label>
                            </span>
                        </div>
                    </div>
                    <div class="form__error__container">
                        <div class="form__error">
                            @error('star')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__textarea">
                        <p class="form__label">口コミを投稿</p>
                        <textarea name="comment" onkeyup="ShowLength(value);" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ $user_review->comment }}</textarea>
                    <div id="inputlength">
                        0/400(最高文字数)
                    </div>
                    </div>
                    <div class="form__error__container">
                        <div class="form__error">
                            @error('comment')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__group">
                    <div class="review__flex">
                        <p class="form__label">画像の追加</p>
                        <p class="old-review-img__ttl">現在の画像</p>
                        <div class="old-review-img__container">
                            <img class="old-review__img" src="{{$user_review->image}}" alt="shop_image" />
                        </div>
                    </div>
                    <div id="upFileWrap">
                        <div id="inputFile">
                            <p id="dropArea">クリックして写真を追加<br><span class="dropArea">またはドラッグアンドドロップ</span></p>
                            <div id="inputFileWrap">
                                <input class="file" id="uploadFile" type="file" accept="image/jpeg,image/png" name="image" value="{{ $user_review->image }}" />
                                <div id="btnInputFile"><span></span></div>
                            </div>
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
                <input type="hidden" name="id" value="{{ $user_review->id }}">
                <button class="form__button-submit" type="submit">口コミを更新</button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection

@section('script')
<script>
    function ShowLength( str ) {
        document.getElementById("inputlength").innerHTML = str.length + "/400(最高文字数)";
    }
</script>

<script>
// ドラッグ&ドロップエリアの取得
var fileArea = document.getElementById('dropArea');

// input[type=file]の取得
var fileInput = document.getElementById('uploadFile');

// ドラッグオーバー時の処理
fileArea.addEventListener('dragover', function(e){
    e.preventDefault();
    fileArea.classList.add('dragover');
});

// ドラッグアウト時の処理
fileArea.addEventListener('dragleave', function(e){
    e.preventDefault();
    fileArea.classList.remove('dragover');
});

// ドロップ時の処理
fileArea.addEventListener('drop', function(e){
    e.preventDefault();
    fileArea.classList.remove('dragover');

    // ドロップしたファイルの取得
    var files = e.dataTransfer.files;

    // 取得したファイルをinput[type=file]へ
    fileInput.files = files;

    if(typeof files[0] !== 'undefined') {
        //ファイルが正常に受け取れた際の処理
    } else {
        //ファイルが受け取れなかった際の処理
    }
});

// input[type=file]に変更があれば実行
fileInput.addEventListener('change', function(e){
    var file = e.target.files[0];

    if(typeof e.target.files[0] !== 'undefined') {
        // ファイルが正常に受け取れた際の処理
    } else {
        // ファイルが受け取れなかった際の処理
    }
}, false);
</script>
@endsection