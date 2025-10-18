<?php

namespace App\Livewire\Cms;

use App\Http\Resources\GameRecordResource;
use App\Models\GameRecord;
use App\Models\Giveback;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class LotteryComponent extends Component
{
    public $students = [];
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
    public $timeId = '';
    public $total_persons = 0;
    // 滿意度統計變數
    public $totalCount = 0;          // 總回覆人數
    public $veryGoodCount = 0;       // 非常滿意 人數
    public $goodCount = 0;           // 滿意 人數
    public $normalCount = 0;         // 普通 人數
    public $badCount = 0;            // 不滿意 人數
    public $veryBadCount = 0;        // 非常不滿意 人數
    public $totalScoreCount = 0;
    // 滿意度數值對照
    const SATISFACTION_LEVEL = [
        5 => '非常滿意',     // veryGood
        4 => '滿意',        // good
        3 => '普通',        // normal
        2 => '不滿意',      // bad
        1 => '非常不滿意'   // veryBad
    ];

    // 前端顯示用的顏色對照
    const SATISFACTION_COLORS = [
        5 => 'bg-green-50 text-green-800',     // 非常滿意 - 綠色
        4 => 'bg-blue-50 text-blue-800',       // 滿意 - 藍色
        3 => 'bg-gray-50 text-gray-800',       // 普通 - 灰色
        2 => 'bg-orange-50 text-orange-800',   // 不滿意 - 橘色
        1 => 'bg-red-50 text-red-800'          // 非常不滿意 - 紅色
    ];

    public function mount(){
        $givebacks = DB::table('givebacks')
        ->select(DB::raw('count(*) as total_count,
                        sum(case when score = 5 then 1 else 0 end) as very_good_count,
                        sum(case when score = 4 then 1 else 0 end) as good_count,
                        sum(case when score = 3 then 1 else 0 end) as normal_count,
                        sum(case when score = 2 then 1 else 0 end) as bad_count,
                        sum(case when score = 1 then 1 else 0 end) as very_bad_count'))
        ->first();

        $this->totalCount = $givebacks->total_count;
        $this->veryGoodCount = $givebacks->very_good_count;
        $this->goodCount = $givebacks->good_count;
        $this->normalCount = $givebacks->normal_count;
        $this->badCount = $givebacks->bad_count;
        $this->veryBadCount = $givebacks->very_bad_count;

        $this->totalScoreCount = $this->veryGoodCount + $this->goodCount + $this->normalCount + $this->badCount + $this->veryBadCount;
    }
    public function refreshStuednts(){
        if(empty($this->timeId)){
            $this->students = GameRecordResource::collection(GameRecord::all())->toArray(request());
        }else{
            $start = $this->selectTimes[$this->timeId-1]['start'];
            $end = $this->selectTimes[$this->timeId-1]['end'];
            $this->students = GameRecordResource::collection(GameRecord::whereBetween('created_at', [$start, $end])->get())->toArray(request());
        }
        Log::info($this->students);
        $this->dispatch('refresh-students', ($this->students));
    }
    #[On('getStudents')]
    public function getStudents(){
        $this->refreshStuednts();
    }
    #[Layout('livewire.layouts.cms')]
    public function render()
    {
        return view('livewire.cms.lottery-component');
    }
}
