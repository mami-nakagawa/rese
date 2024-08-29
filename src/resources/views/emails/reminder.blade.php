<!DOCTYPE html>
<head>
    <title>リマインダーメール</title>
</head>
<body>
    <p>{{ $reservation->user->name }}様</p><br>
    <p>いつもReseをご利用いただきありがとうございます。</p><br>
    <p>ご予約のお時間が近づいて参りました。</p>
    <p>以下の予約内容のご確認をお願い致します。</p><br>
    <p>[店舗名] {{ $reservation->shop->name }}</p>
    <p>[予約日] {{ $reservation->date }}</p>
    <p>[予約時間] {{ substr($reservation->time, 0, 5) }}</p>
    <p>[予約人数] {{ $reservation->number }}人</p><br>
    <p>ご来店の際は、以下URLの店舗提示用QRコードをご提示下さい。</p>
    <p>{{$qrcode_url}}</p><br>
    <p>決済は、以下URLからお願い致します。</p>
    <p>{{$payment_url}}</p><br>
    <p>{{ $reservation->user->name }}様のご来店をお待ちしております。</p>
    <p>Rese</p>
</body>
</html>

