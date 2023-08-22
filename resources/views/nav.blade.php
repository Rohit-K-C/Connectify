<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <script src="{{ asset('js/home.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <a href="/">Connectify</a>
        </div>
        <div class="item">
            <a href="/" id="home-link"><i class="fas fa-home"></i></a>
            <a href="#" id="search-link"><i class="fa-solid fa-magnifying-glass"></i></a>
            <div class="search-pop">
                <form id="search-form" action="{{ route('search') }}" method="get">
                    @csrf
                    <input type="search" name="search" id="search-input">
                    <input type="submit" name="Search" value="Search">
                </form>
                <ul id="search-results"></ul>
            </div>

            <script>
                $(document).ready(function () {
                    $("#search-link").on("click", function (event) {
                        event.preventDefault();
                        $(".search-pop").toggle();
                    });
            
                    // Handle form submission and AJAX request
                    $("#search-form").submit(function (event) {
                        event.preventDefault();
                        var searchQuery = $("#search-input").val();
            
                        if (searchQuery.trim() === "") {
                            // If the search input is empty or contains only spaces, clear the search-results ul
                            $("#search-results").empty();
                        } else {
                            // If the search input is not empty, make the AJAX request
                            $.ajax({
                                url: "{{ route('search') }}",
                                type: "GET",
                                data: { search: searchQuery },
                                dataType: "json",
                                success: function (data) {
                                    // Update the search-results ul with the received data
                                    var searchResultsUl = $("#search-results");
                                    searchResultsUl.empty(); // Clear any previous results
            
                                    if (data.length > 0) {
                                        // If there are results, append each username as a clickable link
                                        for (var i = 0; i < data.length; i++) {
                                            var username = data[i];
                                            var profileUrl = "{{ route('user.profile', ':username') }}";
                                            profileUrl = profileUrl.replace(':username', username);
                                            var listItem = $("<li></li>").append($("<a></a>").attr("href", profileUrl).text(username));
                                            searchResultsUl.append(listItem);
                                        }
                                    } else {
                                        // If no results, show a message
                                        searchResultsUl.append($("<li>No results found.</li>"));
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error(error);
                                }
                            });
                        }
                    });
                });
            </script>
            <a href="/viewnotification" id="notification-link"><i class="fa-sharp fa-solid fa-bell"></i></a>
            <a href="/message-box" id="message-link"><i class="fa-solid fa-message"></i></a>
            <a href="/addQuestion" id="addQuestion-link"><i class="fa-regular fa-square-plus"></i></a>
            <a id="profile-link"><i onclick="settings()" class="fa-solid fa-user"></i></a>
            <div class="set" id="set">
                <span><a href="../profile">{{ Auth::user()->user_name }}</a></span>
                <br>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>

            </div>

        </div>

    </div>
    <script>
        if (window.location.pathname === '/') {

            const home = document.querySelector('#home-link i.fas.fa-home');
            home.style.color = '#D8D8D8';
        } else if (window.location.pathname === '/notification') {
            const notification = document.querySelector('#notification-link i.fa-sharp.fa-solid.fa-bell');
            notification.style.color = '#D8D8D8';

        } else if (window.location.pathname === '/message') {
            const message = document.querySelector('#message-link i.fa-solid.fa-message');
            message.style.color = '#D8D8D8';

        } else if (window.location.pathname === '/addQuestion') {
            const addQuestion = document.querySelector('#addQuestion-link i.fa-regular.fa-square-plus');
            addQuestion.style.color = '#D8D8D8';

        }
    </script>

</body>

</html>