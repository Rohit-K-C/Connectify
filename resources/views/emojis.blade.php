<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .emoji-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 5px;
            padding: 20px;
            width: 200px;
            height: 300px;
            z-index: 20;
            overflow-y: scroll;
            border: 1px solid black;
            background: whitesmoke;
            position: absolute;
            right: 120px;
            top: 140px;
        }

        .emoji-item>p {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
            width: 20px;

            text-align: center;

            border-radius: 50%;
        }

        .emoji-grid::-webkit-scrollbar {
            width: 8px;
        }

        .emoji-grid::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 4px;
        }

        .emoji-item>p:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>

    {{-- <input type="text" id="emoji-input"> --}}

    {{-- <a href="#" id="toggle-emoji-grid"><i class="fa-regular fa-face-smile"></i></a> --}}

    <div class="emoji-grid" style="display: none;">
        @foreach($emojis as $emoji)
        <div class="emoji-item" data-emoji="{!! html_entity_decode($emoji['character']) !!}">
            <p>{!! html_entity_decode($emoji['character']) !!}</p>
        </div>

        @endforeach
    </div>
    <script>
        const emojiItems = document.querySelectorAll('.emoji-item');
        const emojiInput = document.getElementById('emoji-input');
        const toggleEmojiGrid = document.getElementById('toggle-emoji-grid');
        const emojiGrid = document.querySelector('.emoji-grid');
    
        emojiItems.forEach(emojiItem => {
            emojiItem.addEventListener('click', () => {
                const selectedEmoji = emojiItem.getAttribute('data-emoji');
                emojiInput.value += selectedEmoji;
            });
        });
    
        toggleEmojiGrid.addEventListener('click', () => {
            emojiGrid.style.display = emojiGrid.style.display === 'none' ? 'grid' : 'none';
        });
    </script>


</body>

</html>