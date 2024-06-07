@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="content">
  <div class="content__heading">
    <h1>Login</h1>
  </div>
  <div class="login__content">
    <form class="form"  action="/login" method="post">
      @csrf
      <div class="form__group">
        <div class="form__input">
          <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" />
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
        <div class="form__input">
          <input type="password" name="password"  placeholder="Password" />
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