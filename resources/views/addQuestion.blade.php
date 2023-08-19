<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
@include('nav');

<div class="wrapper">
    <div class="container">
        <form action="/addQuestion" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" id="post_description" name="post_info" id="post_info" placeholder="Write something.....">
            <div class="upload-pic">
                <img src="" id="image">
                <input type="file" id="file" name="uploadfile">
                <div class="icon-container">
                    <label for="file" id="uploadBtn"><i class="fa-solid fa-image white-icon"></i></label>
                </div>

            </div>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="submit" name="submit" value="Submit" class="submit-image">
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