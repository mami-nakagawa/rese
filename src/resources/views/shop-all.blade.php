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
                @if(Auth::user())
                    @foreach($favorites as $favorite)
                        @if(in_array("$shop->id", (array)$favorite['shop_id']))
                        <?php $check = "on"; ?>
                        @else
                        <?php $check = "off"; ?>
                        @endif
                        @if($check == "on")
                            <a class="favorite_btn" shop_id="{{ $shop->id }}" favorite="1">
                                <span class="red-heart">&#10084;</span>
                            </a>
                            @endif
                    @endforeach
                        @if($check == "off")
                            <a class="favorite_btn" shop_id="{{ $shop->id }}" favorite="0">
                                <span  class="gray-heart">&#10084;</span>
                            </a>
                        @endif
                @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('script')
<script>
$(function ()
{
    $('.favorite_btn').on('click', function ()
    {
        //表示しているプロダクトのIDと状態、押下したボタンの情報を取得
        shop_id = $(this).attr("shop_id");
        favorite = $(this).attr("favorite");
        click_button = $(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/favorite',
            type: 'POST',
            data: { 'shop_id': shop_id, 'favorite': favorite, },
                })
            //正常にコントローラーの処理が完了した場合
            .done(function (data) //コントローラーからのリターンされた値をdataとして指定
            {
                if ( data == 0 )
                {
                    //クリックしたタグのステータスを変更
                    click_button.attr("favorite", "1");
                    //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
                    click_button.children().attr("class", "red-heart");
                }
                if ( data == 1 )
                {
                    //クリックしたタグのステータスを変更
                    click_button.attr("favorite", "0");
                    //クリックしたタグの子の要素を変更(表示されているハートの模様を書き換える)
                    click_button.children().attr("class", "gray-heart");
                }
            })
            ////正常に処理が完了しなかった場合
            .fail(function (data)
            {
                alert('お気に入り処理失敗');
                alert(JSON.stringify(data));
            });
    });
});
</script>
@endsection