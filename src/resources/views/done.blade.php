@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css')}}">
@endsection

@section('content')
<div class="done-page">
  <div class="done-page__inner">
    <p class="done-page__message">ご予約ありがとうございます</p>
    <a class="done-page__btn" href="/">戻る</a>
  </div>
</div>
@endsection