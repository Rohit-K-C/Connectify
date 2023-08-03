@include('style')
<div class="search-bar">
    <form action="{{ route('manage-post') }}" id="search-form">
        @csrf
        <input type="search" name="search" id="search-user">
        <button id="search-button" type="submit" value="Search" aria-label="Search"> <i
                class="fa-solid fa-magnifying-glass"></i></button>
    </form>

    @if (session('success'))
    <div class="alert alert-success" id="success-message">
        {{ session('success') }}
    </div>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successMessage = document.getElementById('success-message');
    
            if (successMessage) {

                successMessage.style.display = 'block';
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>

</div>
<div class="search-results">
    <div class="heading">
        <span>Author</span>
        <span>Post Info</span>
        <span>Post Image</span>
        <span>User ID</span>
        <span>Action</span>
    </div>
    @if ($search)
    @if (is_null($results))
    <h1 id="not-found">No results found</h1>
    @elseif ($results->isEmpty())
    <h1 id="not-found">No posts found for the user with the provided search term.</h1>
    @else

    @foreach ($results as $result)
    <div class="body-details">
        <span>{{ $result->user->email }}</span>
        <span>{{ $result->post_info }}</span>
        <span>{{ $result->post_image }}</span>
        <span>{{ $result->user_id }}</span>
        <span>Action</span>
    </div>
    @endforeach
    @endif
    @else
    @foreach ($results as $post)
    <div class="body-details">
        <span>{{ $post->user->email }}</span>
        <span>{{ $post->post_info }}</span>
        <span>{{ $post->post_image }}</span>
        <span>{{ $post->user_id }}</span>
        <span id="action">
            <form>
                <input type="button" name="edit" id="edit" value="Edit" onclick="showPopupForm('{{ $post->post_id }}')">
            </form>
            <script>
                function showPopupForm(postId) {
                var overlay = document.getElementById('overlay');
                var popupForm = document.getElementById('popupForm-' + postId);

                overlay.style.display = 'block';
                popupForm.style.display = 'block';
                }

                function hidePopupForm(postId) {
                    var overlay = document.getElementById('overlay');
                    var popupForm = document.getElementById('popupForm-' + postId);

                    overlay.style.display = 'none';
                    popupForm.style.display = 'none';
                }

            </script>
            <form action="{{ route('posts.destroy', ['post' => $post->post_id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" name="delete" id="delete" value="Delete">
            </form>
        </span>

    </div>
    <div class="overlay" id="overlay"></div>
    <div class="pop" id="popupForm-{{ $post->post_id }}" style="display: none;">
        <button type="button" onclick="hidePopupForm('{{ $post->post_id }}')">Close</button>
        <form action="{{ route('posts.update', ['post' => $post->post_id]) }}" method="POST">
            @csrf
            <label for="author">Author</label>
            <input type="text" name="author" id="author" value="{{ $post->user->email }}" readonly>

            <label for="content">Content:</label>
            <input type="text" name="content" id="content" value="{{ $post->post_info }}">

            <label for="image">Post Image:</label>
            <input type="text" name="image" id="image" value="{{ $post->post_image }}">

            <label for="contact">Author ID:</label>
            <input type="text" name="author_id" id="author_id" value="{{ $post->user_id }}" readonly>


            <input type="submit" name="update" id="update" value="Update">
        </form>
    </div>
    @endforeach
    @endif

    <div class="pagination">
        @if (!is_null($results))
            {{ $results->links('custom_pagination') }}
        @endif
    </div>
</div>