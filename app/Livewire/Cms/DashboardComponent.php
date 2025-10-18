<?php

namespace App\Livewire\Cms;

use App\Models\Counter;
use App\Models\GameRecord;
use App\Models\Giveback;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DashboardComponent extends Component
{
    public $scoreData = [];
    public $timeData = [];
    public $dailyData = [];
    public $questionData = [];
    public $totalStudents; //總學生數量
    public $totalGivebacks; //總回饋數量
    public $averageScore; //平均分數
    public $counter; //計數器
    public $mostPopularTime; //最多人數時段
    public $leastPopularTime; //最少人數時段
    public $averagePerTime; //平均每時段人數
    public $lastUpdateTime; //最後更新時間
    public $avgerageGameTimes; //平均遊戲時間
    public $maxGameTimes; //最長遊戲時間
    public $minGameTimes; //最短遊戲時間
    public $finished; //以完成場次
    public $unfinished; //未完成場次
    public $currentSession='無進行中場次'; //目前場次
    public $selectTimes = [
        ['id'=>1, 'start'=>'2025-11-10 08:10:00', 'end'=>'2025-11-10 09:50:00', 'text'=>'11/10 星期一 第一場 08:10-09:50'],
        ['id'=>2, 'start'=>'2025-11-10 10:10:00', 'end'=>'2025-11-10 11:50:00', 'text'=>'11/10 星期一 第二場 10:10-11:50'],
        ['id'=>3, 'start'=>'2025-11-10 13:10:00', 'end'=>'2025-11-10 14:50:00', 'text'=>'11/10 星期一 第三場 13:10-14:50'],
        ['id'=>4, 'start'=>'2025-11-10 15:10:00', 'end'=>'2025-11-10 16:50:00', 'text'=>'11/10 星期一 第四場 15:10-16:50'],
        ['id'=>5, 'start'=>'2025-11-11 08:10:00', 'end'=>'2025-11-11 09:50:00', 'text'=>'11/11 星期二 第一場 08:10-09:50'],
        ['id'=>6, 'start'=>'2025-11-11 10:10:00', 'end'=>'2025-11-11 11:50:00', 'text'=>'11/11 星期二 第二場 10:10-11:50'],
        ['id'=>7, 'start'=>'2025-11-11 13:10:00', 'end'=>'2025-11-11 14:50:00', 'text'=>'11/11 星期二 第三場 13:10-14:50'],
        ['id'=>8, 'start'=>'2025-11-11 15:10:00', 'end'=>'2025-11-11 16:50:00', 'text'=>'11/11 星期二 第四場 15:10-16:50'],
        ['id'=>9, 'start'=>'2025-11-12 08:10:00', 'end'=>'2025-11-12 09:50:00', 'text'=>'11/12 星期三 第一場 08:10-09:50'],
        ['id'=>10, 'start'=>'2025-11-12 13:10:00', 'end'=>'2025-11-12 14:50:00', 'text'=>'11/12 星期三 第二場 13:10-14:50'],
        ['id'=>11, 'start'=>'2025-11-12 15:10:00', 'end'=>'2025-11-12 16:50:00', 'text'=>'11/12 星期三 第三場 15:10-16:50'],
        ['id'=>12, 'start'=>'2025-11-13 08:10:00', 'end'=>'2025-11-13 09:50:00', 'text'=>'11/13 星期四 第一場 08:10-09:50'],
        ['id'=>13, 'start'=>'2025-11-13 10:10:00', 'end'=>'2025-11-13 11:50:00', 'text'=>'11/13 星期四 第二場 10:10-11:50'],
        ['id'=>14, 'start'=>'2025-11-13 13:10:00', 'end'=>'2025-11-13 14:50:00', 'text'=>'11/13 星期四 第三場 13:10-14:50'],
        ['id'=>15, 'start'=>'2025-11-13 15:10:00', 'end'=>'2025-11-13 16:50:00', 'text'=>'11/13 星期四 第四場 15:10-16:50'],
        ['id'=>16, 'start'=>'2025-11-14 08:10:00', 'end'=>'2025-11-14 09:50:00', 'text'=>'11/14 星期五 第一場 08:10-09:50'],
        ['id'=>17, 'start'=>'2025-11-14 10:10:00', 'end'=>'2025-11-14 11:50:00', 'text'=>'11/14 星期五 第二場 10:10-11:50'],
        ['id'=>18, 'start'=>'2025-11-14 13:10:00', 'end'=>'2025-11-14 14:50:00', 'text'=>'11/14 星期五 第三場 13:10-14:50'],
        ['id'=>19, 'start'=>'2025-11-14 15:10:00', 'end'=>'2025-11-14 16:50:00', 'text'=>'11/14 星期五 第四場 15:10-16:50'],
    ];
    public function mount()
    {
        //遊戲次數
        $this->counter = Counter::find(1)->count;
        $this->avgerageGameTimes = ceil(Giveback::avg('game_seconds'));
        $this->maxGameTimes = Giveback::max('game_seconds');
        $this->minGameTimes = Giveback::min('game_seconds');
        // 計算總學生數量
        $this->totalStudents = GameRecord::count();

        // 計算總回饋數量
        $this->totalGivebacks = Giveback::count();

        // 計算評分的平均分數
        $this->averageScore = Giveback::avg('score');
        // 評分分佈數據
        $scores = Giveback::selectRaw('score, COUNT(*) as count')
            ->groupBy('score')
            ->pluck('count', 'score')
            ->toArray();
        $this->scoreData = [
            '非常滿意' => $scores[5] ?? 0,
            '滿意' => $scores[4] ?? 0,
            '普通' => $scores[3] ?? 0,
            '不滿意' => $scores[2] ?? 0,
            '非常不滿意' => $scores[1] ?? 0,
        ];
        Log::info($scores);

        // 初始化時段分佈數據
        $totalCount = 0;
        $maxCount = 0;
        $minCount = PHP_INT_MAX;
        $mostPopularTime = '';
        $leastPopularTime = '';
        $finished = 0;
        $unfinished = 0; //尚未進行
        foreach ($this->selectTimes as $time) {
            $count = Giveback::whereBetween('created_at', [$time['start'], $time['end']])->count();
            if($count===0){
                $unfinished++;
            }else{
                $finished++;
            }
            $this->timeData[$time['text']] = $count;
            $totalCount += $count;

            if ($count > $maxCount) {
                $maxCount = $count;
                $mostPopularTime = $time['text'];
            }

            if ($count < $minCount && $count > 0) {
                $minCount = $count;
                $leastPopularTime = $time['text'];
            }
            $this->finished = $finished;
            $this->unfinished = $unfinished;

            $now = now();
            if($now >= $time['start'] && $now <= $time['end']){
                $this->currentSession = $time['text'];
            }
        }

        $this->mostPopularTime = $mostPopularTime;
        $this->leastPopularTime = $leastPopularTime;
        $this->averagePerTime = $this->finished==0 ? 0 : ceil($totalCount / ($this->finished));

        // 每日資料數量數據
        $dailys = Giveback::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();
        $this->dailyData = [
            '2025-11-10' => $dailys['2025-11-10'] ?? 0,
            '2025-11-11' => $dailys['2025-11-11'] ?? 0,
            '2025-11-12' => $dailys['2025-11-12'] ?? 0,
            '2025-11-13' => $dailys['2025-11-13'] ?? 0,
            '2025-11-14' => $dailys['2025-11-14'] ?? 0,
        ];
        // 每個問題的回答數量數據
        $this->questionData = [
            'question1' => Giveback::where('question_1', 1)->count(),
            'question2' => Giveback::where('question_2', 1)->count(),
            'question3' => Giveback::where('question_3', 1)->count(),
            'question4' => Giveback::where('question_4', 1)->count(),
            'question5' => Giveback::where('question_5', 1)->count(),
            'question6' => Giveback::where('question_6', 1)->count(),
            'question7' => Giveback::where('question_7', 1)->count(),
        ];
        $this->lastUpdateTime = Giveback::max('created_at');
    }
    #[Layout('livewire.layouts.cms')]
    public function render()
    {
        return view('livewire.cms.dashboard-component');
    }
}
