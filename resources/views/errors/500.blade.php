<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>500 Server Error</title>
    @vite(['resources/css/404.scss'])
</head>
<body>
    <div class="site">
        <div class="sketch">
            <div class="bee-sketch red"></div>
            <div class="bee-sketch blue"></div>
        </div>

    <h1>500:
        <small>Server Error</small>
        <a href="{{ route('home') }}">Back to Home</a>
    </h1>
    </div>
</body>
</html>
