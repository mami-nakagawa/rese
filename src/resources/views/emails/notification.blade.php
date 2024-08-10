@component('mail::message')
# Reseからのお知らせ

{{ $text }}

いつもReseをご利用いただきありがとうございます。<br>
{{ config('app.name') }}
@endcomponent
