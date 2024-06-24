@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="card">
  <div class="card__heading">
    <p>Registration</p>
  </div>
  <div class="card__content">
    <form class="form" action="/register" method="post">
      @csrf
      <div class="form__group">
          <div class="form__input-username">
            <input class="input__username" type="text" name="name" placeholder="Username" value="{{ old('name') }}" />
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
@endsection