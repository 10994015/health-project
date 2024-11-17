<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 Not found</title>
    @vite(['resources/css/404.scss'])
</head>
<body>
    <div class="noise"></div>
<div class="overlay"></div>
<div class="terminal">
  <h1>Not found <span class="errorcode">404</span></h1>
  <p class="output">找不到頁面！</p>
  <p class="output">您正在尋找的頁面可能已被刪除、更名或暫時刪除。</p>
  <p class="output">請嘗試 <a href="{{ route('home') }}">回到首頁</a> </p>
  <p class="output">Good luck.</p>
</div>

</body>
</html>
