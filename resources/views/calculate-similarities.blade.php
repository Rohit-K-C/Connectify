@foreach ($recommendedPosts as $recommendedPost)
<li>
    <h3>{{ $recommendedPost->post_info }}</h3>
    <p>{{ $recommendedPost->post_image }}</p>
</li>
@endforeach