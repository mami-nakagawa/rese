@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="admin__ttl-container">
  <h2 class="admin__ttl">{{ $user->name }}さん</h2>
</div>

@if(session('message'))
    <div class="send-mail__message">
        {{ session('message') }}
    </div>
@endif

<div class="admin__content">
  <div class="register__container">
    <div class="card">
      <div class="card__heading">
        <p>店舗代表者の登録</p>
      </div>
      <div class="card__content">
        <form class="form" action="/admin/done" method="post">
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
  </div>
  <div class="shop__container">
      <div class="card">
          <div class="card__heading">
              <p>お知らせメールの作成</p>
          </div>
          <div class="card__content">
              <form class="form" action="/admin/mail" method="post">
              @csrf
                  <div class="form__group">
                      <div class="form__addressee">
                          <div class="form__label">宛先:</div>
                          <p class="addressee">利用者</p>
                      </div>
                  </div>
                  <div class="form__group">
                      <div class="form__text">
                          <div class="form__label">本文:</div>
                          <textarea class="text" name="text" rows="10">{{ old('text') }}</textarea>
                      </div>
                  </div>
                  <div class="form__button">
                      <button class="form__button-submit" type="submit">送信</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
@endsection