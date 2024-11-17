<div class="game-component" wire:ignore>

    <div class="randomBtn" id="randomBtn1">
        <a href="javascript:;" class="clickBtn" id="clickBtn"> <img src="{{ asset('images/click.png')  }}"></a>
    </div>
    <div class="all">

    <div class="main">
        <div id="hiddenLayer">
           <h1 id="touchH1" wire:click='startCalcTimer()'>輕觸螢幕開始遊戲{{ $type }}</h1>
        </div>
        <img src="{{ asset('images/head.png') }}" class="head">
        <p class="hp">HP</p>
            <div class="progressBar" id="progressBar">

                <!-- <div class="progressBarItem"></div> -->

            </div>
            <div id="progressBarNum">100/100</div>
            <img src="{{ asset('images/boss.png') }}" alt="" id="squid">
            <img src="{{ asset('images/arms'.$type.'.png') }}" id="arms">
            <img src="{{ asset('images/player'.$typeToEinglish[$type].'1.png') }}" id="player">
            <p id="addscore">-4%</p>
    </div>

    <div class="qaAll">
            <h1 class="error">答錯了!再答一次!<br><i class="fas fa-times-circle"></i></h1>
            <div class="qa">
                <p>(1).<span id="question1"></span></p>
                <label for="q1-a"><input type="radio" name="q1" id="q1-a" class="option1"><span id="q1a"></span></label>
                <label for="q1-b"><input type="radio" name="q1" id="q1-b" class="option1"><span id="q1b"></span></label>
                <label for="q1-c"><input type="radio" name="q1" id="q1-c" class="option1"><span id="q1c"></span></label>
                <!-- <strong id="hint1"></strong> -->
                <button class="send">送出</button>
            </div>
    </div>

    <div class="qaAll">
        <h1 class="error">答錯了!再答一次!<br><i class="fas fa-times-circle"></i></h1>
            <div class="qa">
                    <p>(2).<span id="question2"></span></p>
                    <label for="q2-a"><input type="radio" name="q2" id="q2-a" class="option2"><span id="q2a"></span></label>
                    <label for="q2-b"><input type="radio" name="q2" id="q2-b" class="option2"><span id="q2b"></span></label>
                    <label for="q2-c"><input type="radio" name="q2" id="q2-c" class="option2"><span id="q2c"></span></label>
                    <!-- <strong id="hint2"></strong> -->
                    <button class="send">送出</button>
                </div>
    </div>

    <div class="qaAll">
        <h1 class="error">答錯了!再答一次!<br><i class="fas fa-times-circle"></i></h1>
        <div class="qa">
                <p>(3).<span id="question3"></span></p>
                <label for="q3-a"><input type="radio" name="q3" id="q3-a" class="option3"><span id="q3a"></span></label>
                <label for="q3-b"><input type="radio" name="q3" id="q3-b" class="option3"><span id="q3b"></span></label>
                <label for="q3-c"><input type="radio" name="q3" id="q3-c" class="option3"><span id="q3c"></span></label>
                <!-- <strong id="hint3"></strong> -->
                <button class="send">送出</button>
            </div>
    </div>

    <div class="qaAll">
        <h1 class="error">答錯了!再答一次!<br><i class="fas fa-times-circle"></i></h1>
        <div class="qa">
                <p>(4).<span id="question4"></span></p>
                <label for="q4-a"><input type="radio" name="q4" id="q4-a" class="option4"><span id="q4a"></span></label>
                <label for="q4-b"><input type="radio" name="q4" id="q4-b" class="option4"><span id="q4b"></span></label>
                <label for="q4-c"><input type="radio" name="q4" id="q4-c" class="option4"><span id="q4c"></span></label>
                <!-- <strong id="hint4"></strong> -->
                <button class="send">送出</button>
            </div>
    </div>

    <div class="qaAll">
        <h1 class="error">答錯了!再答一次!<br><i class="fas fa-times-circle"></i></h1>
        <div class="qa">
                <p>(5).<span id="question5"></span></p>
                <label for="q5-a"><input type="radio" name="q5" id="q5-a" class="option5"><span id="q5a"></span></label>
                <label for="q5-b"><input type="radio" name="q5" id="q5-b" class="option5"><span id="q5b"></span></label>
                <label for="q5-c"><input type="radio" name="q5" id="q5-c" class="option5"><span id="q5c"></span></label>
                <!-- <strong id="hint5"></strong> -->
                <button class="send">送出</button>
            </div>
    </div>
    <div class="qaAll">
        <h1 class="error">答錯了!再答一次!<br><i class="fas fa-times-circle"></i></h1>
        <div class="qa">
                <p>(6).<span id="question6"></span></p>
                <label for="q6-a"><input type="radio" name="q6" id="q6-a" class="option6"><span id="q6a"></span></label>
                <label for="q6-b"><input type="radio" name="q6" id="q6-b" class="option6"><span id="q6b"></span></label>
                <label for="q6-c"><input type="radio" name="q6" id="q6-c" class="option6"><span id="q6c"></span></label>
                <!-- <strong id="hint6"></strong> -->
                <button class="send">送出</button>
            </div>
    </div>

    <div class="bingo">
        <strong id="hint1"></strong>
        <h1>答對了!點擊繼續</h1>
    </div>
    <div class="bingo">
        <strong id="hint2"></strong>
        <h1>答對了!點擊繼續</h1>
    </div>
    <div class="bingo">
        <strong id="hint3"></strong>
        <h1>答對了!點擊繼續</h1>
    </div>
    <div class="bingo">
        <strong id="hint4"></strong>
        <h1>答對了!點擊繼續</h1>
    </div>
    <div class="bingo">
        <strong id="hint5"></strong>
        <h1>答對了!點擊繼續</h1>
    </div>
    <form class="bingo" wire:submit.prevent="submit">
        @csrf
        <strong id="hint6"></strong>
        <h1>闖關成功!點擊繼續</h1>
        <input type="hidden" name="hidden" value="correct">
        <input type="submit">
    </form>

    <div class="loading">
        <div class="loader"></div>
    </div>

    <div id="pass">
        <h1>闖關成功</h1>
        <h1 id="second">0</h1>
        <!-- <img src="images/LOGO.png"> -->
        <p>本活動為衛生保健組宣導各式健康促進議題</p>
        <p>結合時事以平易近人、生活化方式作為傳遞</p>
        <p>感謝您的參加</p>
        <p>請截圖完成畫面+學生證/教職員證</p>
        <p>至活動現場兌換神秘小禮物 1 份</p>
        <p>1人1份，名額有限，送完為止</p>
        <p>衛生保健組 關心您</p>
    </div>

    @push('scripts')
    <script src="{{ asset('js/quest' .$type .'.js') }}"></script>
    <script src="{{ asset('js/script' .$type .'.js') }}"></script>
    @endpush

</div>
