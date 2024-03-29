<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
{{--

<body>
    @foreach($posts as $post)
    <li>{{ $post->post_info }} - {{ $post->post_image }}</li>
    @endforeach
</body> --}}

<body>

    @foreach ($posts as $post)
    <!-- pop-up comment -->
    <div id="pop-comment">
        <div id="display-comments">
            <div class="rotate" onclick="hideComment()">+</div>

            <!-- <div class="edit-name">
                <input type="text" value="Rohit K.C" name="name">

            </div> -->
            <script>
                function applyComment() {
                    var element = document.getElementById("pop-comment").style.display = "block";
                }

                function hideComment() {
                    var displayElement = document.getElementById("pop-comment");
                    displayElement.style.display = "none";
                }
            </script>
        </div>
    </div>
    <!-- pop-up settings -->
    <div id="display">
        <div id="upload-image">
            <div class="rotate" onclick="hide()">
                +
            </div>
            <div class="edit-name">
                <input type="text" value="Rohit K.C" name="name">

            </div>
            <script>
                function hide() {
                    var displayElement = document.getElementById("display");
                    displayElement.style.display = "none";
                }
            </script>
        </div>
    </div>
    <div class="profile-header">
        <div class="profile-picture">
            @if ($post)
            <img id="image" class="pp-image" src="{{ asset($post->post_image) }}">
            @endif
        </div>
        <div class="mid-section">
            <div class="top">
                <span class="name">{{ $post->user->user_name }}</span>
                <span class="settings" onclick="editProfile()">Edit profile</span>
            </div>
            <script>
                function editProfile() {
                    var element = document.getElementById("display").style.display = "block";
                }
            </script>
            <div class="mid">
                <a class="custom-btn btn-8"><span class="mid-span" onclick="shuffle('post')">10 Posts</span></a>
                <a class="custom-btn btn-8"><span class="mid-span" onclick="shuffle('following')">10
                        Following</span></a>
                <a class="custom-btn btn-8"><span class="mid-span" onclick="shuffle('follower')">10 Followers</span></a>
            </div>
        </div>
    </div>
    <div class="profile-content">
        <div id="posts" class="data-container">
            <div class="posts" id="post-css">
                <div class="small-pp">
                    <img class="small-image" src="{{ asset($post->post_image) }}" alt="">
                </div>
                <div class="title">
                    <span>{{ $post->user->user_name }}</span>
                    <span id="just-now">. {{ $post->created_at->diffForHumans() }}</span>
                </div>

            </div>
            <div class="main-image">
                <img src="{{ asset($post->post_image) }}" alt="">
            </div>
            <div class="footer">
                <a id="heart"><i data-post-id="{{ $post->post_id }}" id="heart-link" class="fa-solid fa-heart"></i></a>
                <span id="count" class="like-count">{{ $post->total_likes ? $post->total_likes : 0 }}
                </span>
                <a id="comment" onclick="applyComment()"><i id="comments" class="fa-solid fa-comment"></i></a>
            </div>
        </div>


        <div id="following" class="following">
            <div class="user-details">
                <div class="user-pp">
                    <img class="user-pic" src="{{ asset($post->post_image) }}" alt="">
                </div>
                <div class="user-name">
                    <a id="connectifyName" href="">r_o_h_i_t_k_c</a>
                    <a id="userName" href="">Rohit K.C</a>
                </div>
                <div class="follow-unfollow">
                    <a class="custom-btn fu-8" id="f-u" href="">
                        <p class="fu-span">Unfollow</p>
                    </a>
                </div>


            </div>
        </div>
        <div id="follower" class="follower">
            <div class="user-details">
                <div class="user-pp">
                    <img class="user-pic" src="{{ asset($post->post_image) }}" alt="">
                </div>
                <div class="user-name">
                    <a id="connectifyName" href="">Rohit K.C</a>
                    <a id="userName" href="">NotLevi</a>
                </div>
                <div class="follow-unfollow">
                    <a class="custom-btn fu-8" id="f-u" href="">
                        <p class="fu-span">Follow</p>
                    </a>
                </div>


            </div>
        </div>
        @endforeach
        <script>
            function shuffle(id) {

                var post = document.getElementById("posts");
                var following = document.getElementById("following");
                var follower = document.getElementById("follower");
                post.style.display = "none";
                if (id === "post") {
                    post.style.display = "block";
                    following.style.display = "none";
                    follower.style.display = "none";
                } else if (id === "following") {
                    post.style.display = "none";
                    following.style.display = "block";
                    follower.style.display = "none";
                } else if (id === "follower") {
                    post.style.display = "none";
                    following.style.display = "none";
                    follower.style.display = "block";
                }
            }
        </script>
    </div>

</body>

</html>