<link rel="stylesheet" href="{{ asset('css/recommendation.css') }}">
<h1>Recommended Posts Using User-Based Collaborative Filtering</h1>
<ul>
    @foreach ($recommendedPosts as $post)
        <li>
            <h2>{{ $post->post_info }}</h2>
            <p>{{ $post->post_image }}</p>
        </li>
    @endforeach
</ul>