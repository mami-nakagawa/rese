@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="card">
  <div class="card__heading">
    <p>Login</p>
  </div>
  <div class="card__content">
    <form class="form"  action="/login" method="post">
      @csrf
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
          <input class="input__password" type="password" name="password"  placeholder="Password" />
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
        <button class="form__button-submit" type="submit">ログイン</button>
      </div>
    </form>
  </div>
</div>
@endsection