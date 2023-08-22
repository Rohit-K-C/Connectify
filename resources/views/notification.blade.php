<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
@include('nav');
<div class="noti-container">
    @foreach ($data as $noti)

    <div class="dis-noti">
        <span class="upper">
            <p>From: {{ $noti->from }}</p>
            <p>To: {{ $noti->to }}</p>
        </span>
        <span class="lower">{{ $noti->content }}</span>
    </div>
    @endforeach
</div>