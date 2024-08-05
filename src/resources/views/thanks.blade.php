@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css')}}">
@endsection

@section('content')
<div class="thanks__inner">
  <div class="thanks__card">
    <p class="thanks__message">会員登録ありがとうございます</p>
    <a class="login__btn" href="/login">ログインする</a>
  </div>
</div>
@endsection