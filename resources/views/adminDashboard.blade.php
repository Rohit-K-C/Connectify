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
            <a href="{{ route('analytics') }}" id="analytics"><i class="fa-solid fa-chart-line"></i>Analytics and
                Reports</a>
            <a href="{{ route('settings') }}" id="settings"><i class="fa-solid fa-gear"></i>Settings</a>

        </div>

        <div class="logout-container">
            <a><i class="fa-solid fa-user"></i>Rohit</a>
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

            analytics.addEventListener('click', function (event) {
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