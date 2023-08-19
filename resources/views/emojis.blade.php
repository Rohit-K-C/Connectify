<!DOCTYPE html>
<html>

<head>
    <title>Emojis</title>
    <style>
        .emoji-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 5px;
            padding: 20px;
            width: 200px;
            height: 300px;
            overflow-y: scroll;
            border: 1px solid black;
            background: whitesmoke;
        }



        .emoji-item>p {
            /* background: red; */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
            width: 20px;

            text-align: center;

            border-radius: 50%;
        }

        .emoji-grid::-webkit-scrollbar {
            width: 15px;
        }

        .emoji-grid::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <h1>Emojis</h1>

    <div class="emoji-grid">
        @foreach($emojis as $emoji)
        <div class="emoji-item">
            <p>{!! html_entity_decode($emoji['character']) !!}</p>
        </div>
        @endforeach
    </div>
</body>

</html>