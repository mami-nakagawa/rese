@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin__ttl-container">
  <h2 class="admin__ttl">{{ $user->name }}さん</h2>
</div>

<div class="admin__content">
  <div class="register__container">
    <div class="register__card">
      <div class="card__heading">
        <p>店舗代表者の登録</p>
      </div>
      <div class="card__content">
        <form class="register__form" action="/admin/register" method="post">
          @csrf
          <div class="form__group">
              <div class="form__input-username">
                <input class="input__username" type="text" name="name" placeholder="ShopRepresentativeName" value="{{ old('name') }}" />
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
              <div class="form__input-email">
                <input class="input__email" type="email" name="email" placeholder="Email" value="{{ old('email') }}" />
              </div>
              <div class="form__error__container">
                <div class="form__error">
                  @error('email')
                  {{ $message }}
                  @enderror
                </div>
              </div>
          </div>
          <div class="form__group">
              <div class="form__input-password">
                <input class="input__password" type="password" name="password" placeholder="Password" />
              </div>
              <div class="form__error__container">
                <div class="form__error">
                  @error('password')
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
    <div class="csv__import">
      @if(session('shop_create_message'))
          <div class="shop_create__message">
              {{ session('shop_create_message') }}
          </div>
      @endif
      <div class="shop-create__card">
        <div class="card__heading">
          <p>新規店舗情報の登録</p>
        </div>
        <div class="card__content">
          <p class="csv-import__detail">CSVファイルのインポートにより、新規店舗情報の登録ができます。</p>
          <p class="csv-import__condition">
          ・項目は全て入力必須<br>
          ・店舗名: 50文字以内<br>
          ・地域:「東京都」「大阪府」「福岡県」のいずれか<br>
          ・ジャンル:「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれか<br>
          ・店舗概要: 400文字以内<br>
          ・画像URL: jpeg、pngのみアップロード可能</p>
          <form class="csv-import__form" action="/admin/csv_import" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="csv-import__input">
                <input type="file" accept=".csv" name="csvFile" class="" id="csvFile">
              </div>
              <div class="csv-form__error__container">
              @foreach ($errors->get('upload_errors') as $message)
                  <span class="csv-form__error">{{ $message }}</span>
                  @if (!$loop->last)
                      <br>
                  @endif
              @endforeach
              </div>
              <div class="form__button">
                <button class="form__button-submit">インポート</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="mail__container">
    @if(session('message'))
        <div class="mail__message">
            {{ session('message') }}
        </div>
    @endif
      <div class="mail__card">
          <div class="card__heading">
              <p>お知らせメールの作成</p>
          </div>
          <div class="card__content">
              <form class="mail__form" action="/admin/mail" method="post">
              @csrf
                  <div class="mail-form__group">
                      <div class="mail-form__label">宛先:</div>
                      <p class="addressee">利用者</p>
                  </div>
                  <div class="mail-form__group">
                      <div class="mail-form__label">件名:</div>
                      <p class="subject">Reseからのお知らせ</p>
                  </div>
                  <div class="mail-form__group">
                      <div class="mail-form__label">本文:</div>
                      <textarea class="text" name="text" cols ="70" rows="12">{{ old('text') }}</textarea>
                  </div>
                  <div class="form__button">
                      <button class="mail-form__button-submit" type="submit">送信</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
@endsection