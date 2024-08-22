@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css')}}">
@endsection

@section('content')
<div class="done__inner">
  <div class="done__card">
    <p class="done__message">決済が完了しました。</p>
    <a class="back__btn" href="/">戻る</a>
  </div>
</div>
@endsection