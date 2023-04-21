<div class="profile-content">
    @foreach ($posts as $post)
    <div id="posts" class="data-container">
        <div class="posts" id="post-css">
            <div class="small-pp">
                <img class="small-image" src="{{ asset($post->post_image) }}" alt="">
            </div>
            <div class="title">
                <span>{{ $post->user->user_name }}</span>
                <span id="just-now"> . {{ $post->created_at->diffForHumans() }}
                </span>
            </div>

        </div>
        <div class="post_info">
            <p>{{ $post->post_info }}</p>
        </div>
        <div class="main-image">
            <img src="{{ asset($post->post_image) }}" alt="Post Image">
        </div>
        <div class="footer">
            <a id="heart"><i id="heart-link" class="fa-solid fa-heart"></i></a>
            <span id="count" class="like-count">{{ $post->total_likes }}</span>
            <a id="comment" onclick="applyComment()"><i id="comments" class="fa-solid fa-comment"></i></a>
        </div>
    </div>
    @endforeach
</div>