@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/scan.css')}}">
@endsection

@section('content')
<div class="scan__inner">
    <p>QRコードをカメラにかざして下さい。</p>
    <div id="loading">📱 ブラウザのカメラの使用を許可してください。</div>
    <canvas id="canvas" hidden></canvas>
</div>
@endsection

@section('script')
    <script>
        const video = document.createElement('video');
        const canvasElement = document.getElementById('canvas');
        const canvas = canvasElement.getContext('2d');
        const loading = document.getElementById('loading');
        const output = document.getElementById('output');
        let isReadQR = false;

        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then((stream) => {
            video.srcObject = stream;
            video.setAttribute('playsinline', true);
            video.play();
            requestAnimationFrame(tick);
            });

        function tick() {
            loading.innerText = 'ロード中...';
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
            loading.hidden = true;
            canvasElement.hidden = false;
            canvasElement.height = video.videoHeight;
            canvasElement.width = video.videoWidth;
            canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
            var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
            var code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: 'dontInvert',
            });
            if (code && !isReadQR) {
                location.href = code.data;
                isReadQR = true;
            }
            }
            requestAnimationFrame(tick);
        }
    </script>
@endsection