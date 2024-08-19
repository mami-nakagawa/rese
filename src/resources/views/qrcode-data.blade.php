<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/qrcode-data.css') }}">
</head>

<body>
    <main>
        <div class="qrcode-data__container">
            <div class="qrcode-data">
                <p>店舗名: {{ $reservation->shop->name }}</p><br>
                <p>予約ID: {{ $reservation->id }}</p>
                <p>予約名: {{ $reservation->user->name }}様</p>
                <p>予約日: {{ $reservation->date }}</p>
                <p>予約時間: {{ substr($reservation->time, 0, 5) }}</p>
                <p>予約人数: {{ $reservation->number }}人</p>
            </div>
        </div>
    </main>
</body>

</html>