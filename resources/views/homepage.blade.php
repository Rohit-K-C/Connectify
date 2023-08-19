<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connectify</title>
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <script src="{{ asset('js/home.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    @include('nav')

    <div class="post-container">
        <div class="left-recommend">
            <label for="" class="you-may">Post you may like</label>
            @foreach ($recommendedPosts as $recommendedPost)
            <div class="recommend-div">
                <span class="post-inforamtion">{{ $recommendedPost['post']->post_info }}
                    <a
                        class="read-more"
                        href="{{ route('user.profile', ['encodedUsername' => urlencode($recommendedPost['post']->user->getUsernameFromId($recommendedPost['post']->user_id))]) }}">
                        Read
                    </a>


                </span>
            </div>

            @endforeach

        </div>
        <div class="mid-content">
            @foreach ($posts as $post)
            <div class="profile-content">
                <div id="posts" class="data-container" style="width:80%;">
                    <div class="posts" id="post-css">
                        <div class="small-pp">
                            @if ($post->user->profileImage)
                            <img class="small-image" src="{{ $post->user->profileimage->user_image }}"
                                alt="Profile Image">
                            @else

                            <img class="small-image" src="{{ asset('images/default-pp.png') }}"
                                alt="Default Profile Image">
                            @endif

                        </div>
                        <div class="title">
                            <span>{{ $post->user->user_name }}</span>
                            <span id="just-now"> . {{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="post_info">
                        <p>{{ $post->post_info }}</p>
                    </div>
                    <div class="main-image">
                        <img src="{{ asset($post->post_image) }}" alt="Post Image">
                    </div>
                    <div class="footer">
                        <a id="heart-link-{{ $post->post_id }}" onclick="handleLike('{{ $post->post_id }}', this)">
                            <i class="fa-solid fa-heart{{ isset($likesData[$post->post_id]) ? ' liked' : '' }}"></i>
                        </a>
                        <span id="count-{{ $post->post_id }}" class="like-count">
                            {{ $likesData[$post->post_id] ?? 0 }}
                        </span>
                        <a class="comment-btn" onclick="showComments('{{ $post->post_id }}')">
                            <i id="comment-btn" class="fa-solid fa-comment"></i>
                        </a>
                        <span id="count-{{ $post->post_id }}" class="comment-count">
                            {{ count($post->comments) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="comments-container" id="comments-{{ $post->post_id }}" style="display: none;">
                <div class="display-comments">
                    <div class="rotate" onclick="hideComments()"><span>+</span></div>
                    <form action="{{ route('submit-comment.comment', ['postId' => $post->post_id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                        <input type="text" placeholder="Write a comment..." name="comment">
                        <button type="submit">Submit</button>
                    </form>
                    @forelse ($post->comments as $comment)
                    <div class="comment">
                        <div class="cmnt-pp-image">
                            @if ($comment->user->profileImage)
                            <img class="user-small-image" src="{{ $comment->user->profileImage->user_image }}"
                                alt="Profile Image">
                            @else
                            <img class="user-small-image" src="{{ asset('images/default-pp.png') }}"
                                alt="Default Profile Image">
                            @endif
                            {{-- <img class="user-small-image" src="{{ asset('images/pp.png') }}" alt=""> --}}
                        </div>
                        <div class="comment-details">
                            <a href="">{{ $comment->user->user_name }}</a>
                            <span>{{ $comment->comments }}</span>
                        </div>
                    </div>
                    @empty
                    <span>No comments for this post yet.</span>
                    @endforelse
                </div>
            </div>
            @endforeach
        </div>
        <div class="right-recommend">Hello</div>

    </div>
    <script>
        function handleLike(postId, element) {
        var heartIcon = $(element).find('.fa-heart');
        var isLiked = heartIcon.hasClass('liked');

        $.ajax({
            url: '/like/' + postId, // Replace this with the correct route to your like controller
            method: 'POST', // Use the appropriate HTTP method (e.g., POST or DELETE)
            data: {
                _token: '{{ csrf_token() }}', // Add the CSRF token if using Laravel's CSRF protection
            },
            success: function(response) {
                var totalLikes = response.total_likes;
                if (isLiked) {
                    heartIcon.removeClass('liked');
                } else {
                    heartIcon.addClass('liked');
                }

                $('#count-' + postId).text(totalLikes);
            },
            error: function(error) {
                console.error('Error liking/unliking post:', error);
                }
            });
            }

            function showComments(postId) {
                const commentsContainer = document.getElementById(`comments-${postId}`);
                commentsContainer.style.display = 'block';

                // Hide other comment containers if this one is shown
                const allCommentsContainers = document.querySelectorAll('.comments-container');
                allCommentsContainers.forEach(container => {
                    if (container.id !== `comments-${postId}`) {
                        container.style.display = 'none';
                    }
                });
            }
            function hideComments() {
                const allCommentsContainers = document.querySelectorAll('.comments-container');
                allCommentsContainers.forEach(container => {
                    container.style.display = 'none';
                });
            }
    </script>
</body>

</html>