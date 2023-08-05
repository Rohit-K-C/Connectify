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
    {{-- <script>
        $(document).ready(function() {
            var postId = parseInt($("i.fa-heart").data("post-id"));
            var isLiked = $("#heart").hasClass("liked");
            console.log(isLiked);
            if (isLiked) {
                $("#heart i.fa-heart").addClass("active");
            } else {
                $("#heart i.fa-heart").removeClass("active");
            }
            
            $("#heart").click(function() {
                var likeCount = parseInt($("#count").text());
                
                if($(this).hasClass("liked")) {
                    $(this).removeClass("liked");
                    $(this).find("i.fa-heart").css("color", "white");
                    likeCount--;
                    $("#count").text(likeCount);
                    
                    // Send a request to remove the like from the table
                    $.ajax({
                        url: "/unlike/" + postId,
                        type: "POST",
                        data: { _token: "{{ csrf_token() }}" },
                        success: function(response) {
                            console.log(response);
                        }
                    });
                } else {
                    $(this).addClass("liked");
                    $(this).find("i.fa-heart").css("color", "red");
                    likeCount++;
                    $("#count").text(likeCount);
                    
                    // Send a request to add the like to the table
                    $.ajax({
                        url: "/like/" + postId,
                        type: "POST",
                        data: { _token: "{{ csrf_token() }}" },
                        success: function(response) {
                            console.log(response);
                        }
                    });
                }
            });
        });
    </script> --}}


</head>

<body>
    
    @include('nav')
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
    <div class="main">
      
        @include('posts')
    </div>
</body>

</html>

