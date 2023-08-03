@include('style')
<div class="search-bar">
    <form action="{{ route('manage-user') }}" id="search-form">
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
        <span>Username</span>
        <span>Email</span>
        <span>Contact</span>
        <span>isAdmin</span>
        <span>Action</span>
    </div>
    @if ($search)
    @if ($results->isEmpty())
    <h1 id="not-found">No results found</h1>
    @else
    @foreach ($results as $result)
    <div class="body-details">
        <span>{{ $result->user_name }}</span>
        <span>{{ $result->email }}</span>
        <span>{{ $result->contact }}</span>
        <span>{{ $result->is_admin }}</span>
        <span>Action</span>
    </div>
    @endforeach
    @endif
    @else
    @foreach ($userDetails as $user)
    <div class="body-details">
        <span>{{ $user->user_name }}</span>
        <span>{{ $user->email }}</span>
        <span>{{ $user->contact }}</span>
        <span>{{ $user->is_admin }}</span>
        <span id="action">
            <form>
                <input type="button" name="edit" id="edit" value="Edit" onclick="showPopupForm('{{ $user->id }}')">
            </form>
            <script>
                function showPopupForm(userId) {
                var overlay = document.getElementById('overlay');
                var popupForm = document.getElementById('popupForm-' + userId);

                overlay.style.display = 'block';
                popupForm.style.display = 'block';
                }

                function hidePopupForm(userId) {
                    var overlay = document.getElementById('overlay');
                    var popupForm = document.getElementById('popupForm-' + userId);

                    overlay.style.display = 'none';
                    popupForm.style.display = 'none';
                }

            </script>
            <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" name="delete" id="delete" value="Delete">
            </form>
        </span>

    </div>
    <div class="overlay" id="overlay"></div>
    <div class="pop" id="popupForm-{{ $user->id }}" style="display: none;">
        <button type="button" onclick="hidePopupForm('{{ $user->id }}')">Close</button>
        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
            @csrf
            <label for="user_name">User Name:</label>
            <input type="text" name="user_name" id="user_name" value="{{ $user->user_name }}">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}">

            <label for="contact">Contact:</label>
            <input type="text" name="contact" id="contact" value="{{ $user->contact }}">

            <label for="is_admin">Is Admin (0 or 1):</label>
            <input type="text" name="is_admin" id="is_admin" pattern="[0-1]" value="{{ $user->is_admin }}" required>

            <input type="submit" name="update" id="update" value="Update">
        </form>
    </div>
    @endforeach
    @endif

    <div class=" pagination">
        {{ $userDetails->links('custom_pagination') }}
    </div>
</div>