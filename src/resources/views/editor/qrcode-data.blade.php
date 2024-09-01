@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/qrcode-data.css')}}">
@endsection

@section('content')
<div class="qrcode-data__inner">
        <h2 class="qrcode-data__ttl">予約情報</h2>
        <div class="qrcode-data__content">
            <p>店舗名: {{ $reservation->shop->name }}</p><br>
            <p>予約ID: {{ $reservation->id }}</p>
            <p>予約名: {{ $reservation->user->name }}様</p>
            <p>予約日: {{ $reservation->date }}</p>
            <p>予約時間: {{ substr($reservation->time, 0, 5) }}</p>
            <p>予約人数: {{ $reservation->number }}人</p>
        </div>
</div>
@endsection
