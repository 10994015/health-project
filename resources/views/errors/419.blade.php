<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>419 Page Expired</title>
    @vite(['resources/css/404.scss'])
</head>
<body>
    <div class="noise"></div>
<div class="overlay"></div>
<div class="terminal">
  <h1>Page Expired <span class="errorcode">419</span></h1>
  <p class="output">連線已過期</p>
  <p class="output">您正在尋找的頁面這個連結已經過期或無效。</p>
  <p class="output">請嘗試 <a href="{{ route('home') }}">回到首頁</a> 重新進入畫面。</p>
</div>

</body>
</html>
