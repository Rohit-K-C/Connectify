@include('nav');
<div class="wrapper">
<div class="container">
    <form action="/addQuestion" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" id="post_description" name="post_info" id="post_info">
        <div class="upload-pic">
            <img src="" id="image">
            <input type="file" id="file" name="uploadfile">
            <label for="file" id="uploadBtn">Image</label>

        </div>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="submit" name="submit" value="Submit">
    </form>
</div>
</div>
<script>
    const imgDiv = document.querySelector('.upload-pic');
    const img = document.querySelector('#image');
    const file = document.querySelector('#file');
    const uploadBtn = document.querySelector('#uploadBtn');

    file.addEventListener('change', function(){
	const choosedFile = this.files[0];
    if (choosedFile) {
		const reader = new FileReader();
    reader.addEventListener('load', function(){
        img.setAttribute('src', reader.result);
		});
    reader.readAsDataURL(choosedFile);
	}
});
</script>