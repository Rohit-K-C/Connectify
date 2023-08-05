<!-- resources/views/homepage.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <!-- ... Your other meta tags, stylesheets, and scripts ... -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div class="profile-content">
        @foreach ($posts as $post)
        <div id="posts" class="data-container">
            <div class="posts" id="post-css">
                <div class="small-pp">
                    <img class="small-image" src="{{ asset($post->post_image) }}" alt="">
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
                <a id="comment" onclick="applyComment()"><i id="comments" class="fa-solid fa-comment"></i></a>
            </div>
        </div>
        @endforeach
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
                        // If it has the "liked" class, remove it (unlike the post)
                        heartIcon.removeClass('liked');
                    } else {
                        // If it doesn't have the "liked" class, add it (like the post)
                        heartIcon.addClass('liked');
                    }
    
                    // Update the total likes count on the page dynamically
                    $('#count-' + postId).text(totalLikes);
                },
                error: function(error) {
                    // Handle error if necessary
                    console.error('Error liking/unliking post:', error);
                }
            });
        }
    </script>
    
    
    







</body>

</html>