@include('style')
<div class="welcome">

    <a>Welcome to the admin dashboard, {{ Auth::user()->user_name; }}</a>
</div>
<div class="performance">
    <a>Total Users <p>{{ $totalUsers }}</p></a>
    <a>New Users <p>{{ $newUsers }}</p> </a>
    <a>Total Posts <p>{{ $totalPosts }}</p></a>
    <a>New Posts <p>{{ $newPosts }}</p></a>
</div>