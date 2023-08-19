<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <!-- <link rel="stylesheet" href="/CSS/header.css"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @if(session('success'))
    <div class="alert alert-success" id="successAlert">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger" id="errorAlert">
        {{ session('error') }}
    </div>
    @endif

    <script>
        // Automatically hide the success message after 5 seconds
        setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
        }, 5000);

        // Automatically hide the error message after 5 seconds
        setTimeout(function() {
            document.getElementById('errorAlert').style.display = 'none';
        }, 3000);
    </script>
    <!-- pop-up settings -->
    <div id="display">
        <div id="upload-image">
            <div class="rotate" onclick="hide()">
                <span>+</span>
            </div>
            <div class="edit-name">
                <form action="{{ route('upload-image.upload') }}" method="POST" id="image-form"
                    enctype="multipart/form-data">
                    @csrf
                    Name: <input type="text" name="name" id="name" value="{{ $user->user_name }}">
                    Email: <input type="email" name="email" id="email" value="{{ $user->email }}">
                    Contact: <input type="text" name="contact" id="contact" value="{{ $user->contact }}">
                    <input type="file" id="image-input" name="user_image" accept="image/*" />
                    <input type="submit" value="Confirm Change" />
                </form>
                <div id="image-container">
                    <img id="uploaded-image" src="#" alt="Uploaded Image" />
                </div>

                <script>
                    const imageInput = document.getElementById('image-input');
                    const uploadedImage = document.getElementById('uploaded-image');
                
                    imageInput.addEventListener('change', function(event) {
                      const selectedImage = event.target.files[0];
                      if (selectedImage) {
                        uploadedImage.src = URL.createObjectURL(selectedImage);
                        uploadedImage.style.display = 'block';
                      } else {
                        uploadedImage.src = '#';
                        uploadedImage.style.display = 'none';
                      }
                    });
                
                    // const imageForm = document.getElementById('image-form');
                    // imageForm.addEventListener('submit', function(event) {
                    //   event.preventDefault();
                    //   // You can add your image upload logic here
                    //   // For demonstration purposes, you can simply console.log the selected file name
                    //   const selectedImage = imageInput.files[0];
                    //   if (selectedImage) {
                    //     console.log('Uploaded file:', selectedImage.name);
                    //   }
                    // });
                </script>
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
            @if ($user->profileImage)
            <img id="image" class="pp-image" src="{{ asset($user->profileImage->user_image) }}">
            @else
            <img id="image" class="pp-image" src="{{ asset('images/default-pp.png') }}" alt="Profile Image">
            @endif
        </div>
        <div class="mid-section">
            @if($user->id === auth()->user()->id)
            <div class="top">
                <span class="name">{{ $user->user_name }}</span>
                <span class="settings" onclick="editProfile()">Edit profile</span>
            </div>
            @else
            <div class="top">
                <span class="name">{{ $user->user_name }}</span>
            </div>
            @endif


            <script>
                function editProfile() {
                    var element = document.getElementById("display").style.display = "block";
                }
            </script>
            <div class="mid">
                <a class="custom-btn btn-8"><span class="mid-span" onclick="shuffle('main-post')">{{
                        $user->posts->count() }} Posts</span></a>
                <a class="custom-btn btn-8"><span class="mid-span" onclick="shuffle('following')">{{ $totalFollowing }}
                        Following</span></a>
                <a class="custom-btn btn-8"><span class="mid-span" onclick="shuffle('follower')">{{ $totalFollowers }}
                        Followers</span></a>
            </div>
        </div>
    </div>

    <div class="profile-content">

        <div class="following" id="following">
            @foreach ($user->followedUsers as $followedUser)
            <div class="user-details">
                <div class="user-pp">
                    @if ($followedUser->profileImage)
                    <img class="user-pic" src="{{ asset($followedUser->profileImage->user_image) }}">
                    @else
                    <img class="user-pic" src="{{ asset('images/default-pp.png') }}" alt="Profile Image">
                    @endif
                </div>
                <div class="user-name">
                    <a id="connectifyName" href="">{{ $followedUser->user_name }}</a>
                    <a id="userName" href="">{{ $followedUser->email }}</a>
                </div>
                <div class="follow-unfollow">
                    @if($user->id === auth()->user()->id)
                    <form action="/unfollow" method="POST" id="unfollowForm_{{ $followedUser->id }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $followedUser->id }}">
                        <button type="submit" class="custom-btn fu-8"
                            onclick="return confirm('Are you sure you want to unfollow?')">
                            <p class="fu-span">Unfollow</p>
                        </button>
                    </form>
                    @endif

                </div>

            </div>
            @endforeach
        </div>


        <div id="follower" class="follower">
            @foreach ($user->followers as $follower)
            <div class="user-details">
                <div class="user-pp">
                    @if ($follower->profileImage)
                    <img class="user-pic" src="{{ asset($follower->profileImage->user_image) }}">
                    @else
                    <img class="user-pic" src="{{ asset('images/default-pp.png') }}" alt="Profile Image">
                    @endif
                </div>
                <div class="user-name">
                    <a id="connectifyName" href="">{{ $follower->user_name }}</a>
                    <a id="userName" href="">{{ $follower->email }}</a>
                </div>
                <div class="follow-unfollow">
                    @if($user->id === auth()->user()->id)


                    <form action="/follow" method="POST" id="followForm_{{ $follower->id }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $follower->id }}">
                        <button type="submit" class="custom-btn fu-8"
                            onclick="return confirm('Are you sure you want to follow?')">
                            <p class="fu-span">Follow</p>
                        </button>
                    </form>
                    @endif
                </div>


            </div>
            @endforeach
        </div>
        <script>
            function unfollowUser(userId, event) {
                event.preventDefault(); // Prevent default anchor tag behavior
                console.log("Unfollow button clicked for user ID:", userId);
                
                // Send an AJAX request to delete the follow relationship
            //     $.ajax({
            //         type: 'POST',
            //         url: '/unfollow', // Adjust the route URL
            //         data: {
            //             user_id: userId,
            //             _token: '{{ csrf_token() }}',
            //         },
            //         success: function(response) {
            //             // Remove the unfollowed user's div from the DOM
            //             $('#user_' + userId).remove();
            //         },
            //         error: function() {
            //             // Handle error if necessary
            //         }
            //     });
            // }
            }
        </script>


        <script>
            function shuffle(id) {
            var post = document.getElementById("main-container");
            var following = document.getElementById("following");
            var follower = document.getElementById("follower");
            
            // Set the display properties based on the clicked section
            post.style.display = (id === "main-post") ? "block" : "none";
            following.style.display = (id === "following") ? "block" : "none";
            follower.style.display = (id === "follower") ? "block" : "none";
            }
        </script>
    </div>
    <div class="main-container" id="main-container">
        @foreach ($posts as $post)
        <div class="post-container">
            <!-- Display post content here -->
            <div class="profile-content">
                <div id="posts" class="data-container">
                    <div class="posts" id="post-css">
                        <div class="small-pp">
                            @if ($user->profileImage)
                            <img class="small-image" src="{{ asset($user->profileImage->user_image) }}">
                            @else
                            <img class="small-image" src="{{ asset('images/default-pp.png') }}" alt="Profile Image">
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
                            <i id="like-btn"
                                class="fa-solid fa-heart{{ isset($likesData[$post->post_id]) ? ' liked' : '' }}"></i>
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
                            {{-- <img class="user-small-image" src="{{ asset('images/pp.png') }}" alt=""> --}}
                            @if ($user->profileImage)
                            <img class="user-small-image" src="{{ asset($user->profileImage->user_image) }}">
                            @else
                            <img class="user-small-image" src="{{ asset('images/default-pp.png') }}"
                                alt="Profile Image">
                            @endif
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

        </div>
        @endforeach
    </div>

    <script>
        function handleLike(postId, element) {
            var heartIcon = $(element).find('.fa-heart');
            var isLiked = heartIcon.hasClass('active'); // Check for the 'active' class instead of 'liked'

            $.ajax({
                url: '/like/' + postId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    var totalLikes = response.total_likes;
                    if (isLiked) {
                        heartIcon.removeClass('active'); // Remove the 'active' class
                    } else {
                        heartIcon.addClass('active'); // Add the 'active' class
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