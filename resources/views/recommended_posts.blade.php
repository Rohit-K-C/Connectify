<link rel="stylesheet" href="{{ asset('css/recommendation.css') }}">
<h1>Recommended Posts Using Content-Based Filtering</h1>

<ul>
    @foreach ($recommendedPosts as $recommendedPost)
        <li>
            <h3>{{ $recommendedPost['post']->post_info }}</h3>
            <p>Similarity Score: {{ $recommendedPost['similarity'] }}</p>
            <p>{{ $recommendedPost['post']->content }}</p>
        </li>
    @endforeach
</ul>