@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment.css')}}">
@endsection

@section('content')
<div class="payment__inner">
    <p class="payment__text">以下の決済ボタンから決済をお願い致します。</p>
    <div class="payment__btn">
        <form action="/payment/payment" method="POST">
            @csrf
                <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="{{ config('services.stripe.key') }}"
                        data-amount="2000"
                        data-name="{{ $reservation->shop->name }}へお支払い"
                        data-label="決済をする"
                        data-description="決済テスト"
                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                        data-locale="auto"
                        data-currency="JPY">
                </script>
        </form>
    </div>
</div>
@endsection