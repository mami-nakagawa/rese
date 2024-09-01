@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/qrcode.css')}}">
@endsection

@section('content')
<div class="qrcode__inner">
    <p class="text">店舗提示用QRコード</p>
    <div class="qrcode">
    @php
        $url = route('editor.confirm', [
            'id' => $reservation->id
        ]);
    @endphp
    {!! QrCode::generate($url) !!}
    </div>
</div>
@endsection