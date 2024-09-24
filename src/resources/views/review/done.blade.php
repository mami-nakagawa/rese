@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css')}}">
@endsection

@section('content')
<div class="done__inner">
  <div class="done__card">
    @if(isset($create))
    <p class="done__message">口コミ投稿ありがとうございます</p>
    @else
    <p class="done__message">口コミを更新しました</p>
    @endif
    <a class="back__btn" href="/">戻る</a>
  </div>
</div>
@endsection
