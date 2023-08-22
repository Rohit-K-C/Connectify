@include('style')

<div class="main-container">

    <div class="sidebar">
        <div class="logo">
            <a href=""><img id="logo" src="{{ asset('images/connectify.png') }}" alt="logo"></a>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('dashboard') }}" id="dashboard"><i class="fa-solid fa-grip"></i>Dashboard</a>
            <a href="{{ route('manage-user') }}" id="manage-user"><i class="fa-solid fa-users"></i>Manage User</a>
            <a href="{{ route('manage-post') }}" id="manage-post"><i class="fa-solid fa-book"></i>Manage Post</a>
            <a href="{{ route('notification') }}" id="settings"><i class="fa-regular fa-bell"></i>Notify</a>

        </div>

        <div class="logout-container">
            <a><i class="fa-solid fa-user"></i>{{ Auth::user()->user_name }}</a>
            <a href="{{ url('/logout') }}"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
        </div>
    </div>
    <div class="content">
        <iframe name="iframeTarget" src="/dashboard"></iframe>

        <script>
            const dashboard = document.getElementById('dashboard');
            const manageUser = document.getElementById('manage-user');
            const managePost = document.getElementById('manage-post');
            const analytics = document.getElementById('analytics');
            const settings = document.getElementById('settings');
            const iframe = document.querySelector('iframe[name="iframeTarget"]');

            dashboard.addEventListener('click', function (event) {
                event.preventDefault();
                iframe.src = this.getAttribute('href');
            });

            manageUser.addEventListener('click', function (event) {
                event.preventDefault();
                iframe.src = this.getAttribute('href');
            });

            managePost.addEventListener('click', function (event) {
                event.preventDefault();
                iframe.src = this.getAttribute('href');
            });

            settings.addEventListener('click', function (event) {
                event.preventDefault();
                iframe.src = this.getAttribute('href');
            });
        </script>

    </div>
</div>