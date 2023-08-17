@include('nav')
<link rel="stylesheet" href="{{ asset('css/messageBox.css') }}">
<div class="message-box-container">
    <p id="chats">Chats</p>
    <div class="main-message">
        <div class="user-list">
            @if (count($commonUsersWithImages) > 0)
                @foreach($commonUsersWithImages as $commonUserWithImage)
                    <div class="m-content">
                        <a href="{{ route('user.message', ['id' => $commonUserWithImage['user']->id]) }}"
                           class="user-anchor" data-id="{{ $commonUserWithImage['user']->id }}">
                            @if ($commonUserWithImage['profileImage'])
                                <img class="chat-image"
                                     src="{{ asset( $commonUserWithImage['profileImage']->user_image) }}"
                                     alt="">
                            @else
                                <img class="chat-image" src="{{ asset('images/default-pp.png') }}"
                                     alt="">
                            @endif
                            {{ $commonUserWithImage['user']->user_name }}
                        </a>
                    </div>
                @endforeach
            @else
                <p>Follow user to chat with them.</p>
            @endif
        </div>
        <iframe name="iframeTarget" id="iframe-message" src=""></iframe>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const userAnchors = document.querySelectorAll('.user-anchor');
    const iframe = document.querySelector('iframe[name="iframeTarget"]');

    userAnchors.forEach(function(anchor) {
        anchor.addEventListener('click', function(event) {
            event.preventDefault();
            const profileUrl = this.getAttribute('href');
            iframe.src = profileUrl;
            userAnchors.forEach(function(anchor) {
                anchor.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
});

</script>