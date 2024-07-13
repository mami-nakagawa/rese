@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css')}}">
@endsection

@section('content')
<div class="done__inner">
  <div class="done__card">
    <p class="done__message">ご予約ありがとうございます</p>
    <a class="back__btn" href="/">戻る</a>
  </div>
</div>
@endsection