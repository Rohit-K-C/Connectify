@include('style')

<div class="form-container">
    <form action="{{ route('send.notification') }}" method="POST">
        @csrf
        <label class="notify-label" for="">From
            <input type="email" name="from" value="admin@gmail.com" readonly>
        </label>
        <label class="notify-label" for="">To
            <input type="email" name="to">
        </label>
        <textarea name="content" id="" cols="30" rows="10" class="message-content"></textarea>
        <input type="submit" name="submit" value="Send">
    </form>
</div>
