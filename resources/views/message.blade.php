<link rel="stylesheet" href="{{ asset('css/message.css') }}">
<div class="m-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">
                @if ($otherUserProfileImage)
                <img class="chat-image" src="{{ asset($otherUserProfileImage->user_image) }}" alt="Profile Image">
                @else
                <img class="chat-image" src="{{ asset('images/default-pp.png') }}" alt="Default Profile Image">
                @endif
                <p>{{ $otherUser->user_name }}</p>
            </div>
            <div class="card">

                <div class="card-body">
                    <div class="message-thread">
                        @foreach ($messages as $message)
                        <div class="message @if ($message->sender_id === Auth::id()) sent @else received @endif">
                            <div class="message-content">{{ $message->content }}</div>
                            <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-container">
                    <form action="{{ route('send.message') }}" method="post">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                        <input type="text" name="message_content" class="message-input" placeholder="Type your message here">
                        <input type="submit" name="submit" class="submit-button" value="Send">
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>