<?php

namespace App\Livewire;

use App\Models\GameRecord;
use App\Models\Giveback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

class InputComponent extends Component
{
    public $type;
    public $score = 5;
    public $q1;
    public $q2;
    public $q3;
    public $q4;
    public $q5;
    public $q6;
    public $q7;
    public $student_id;
    public $name;
    public $comment = '';
    public $game_seconds;
    public function mount(Request $request)
    {
        $signedurl = Redis::get('input_signed_url:' . $request->signedurl);
        $this->game_seconds = $signedurl;
        $this->type = $request->type;
        Log::info($signedurl);
        if (!$signedurl) {
            abort(419, '這個連結已經過期或無效，請在玩一次遊戲。');
        }
    }
    public function submit()
    {
        $this->validate([
            'student_id' => 'required|size:8',
            'name' => 'required',
            'score' => 'required|numeric',
        ],[
            'student_id.required' => '學號為必填的。',
            'student_id.size' => '學號必須是8位數。',
            'name.required' => '姓名是必填的。',
            'score.required' => '分數是必填的。',
            'score.numeric' => '分數必須是數字。',
        ]);
        DB::transaction(function () {
            $game_record = GameRecord::updateOrCreate(
                ['student_id' => $this->student_id],
                ['name' => $this->name]
            );
            $game_record->id;

            $giveback = new Giveback();
            $giveback->student_id = $this->student_id;
            $giveback->type = $this->type;
            $giveback->question_1 = $this->q1 ?? 0;
            $giveback->question_2 = $this->q2 ?? 0;
            $giveback->question_3 = $this->q3 ?? 0;
            $giveback->question_4 = $this->q4 ?? 0;
            $giveback->question_5 = $this->q5 ?? 0;
            $giveback->question_6 = $this->q6 ?? 0;
            $giveback->question_7 = $this->q7 ?? 0;
            $giveback->comment = $this->comment;
            $giveback->score = $this->score;
            $giveback->game_seconds = $this->game_seconds;
            $giveback->game_record_id = $game_record->id;
            $giveback->save();
        });

        return redirect()->route('finish')->with('from_input', true);    }
    #[Layout('livewire.layouts.app')]
    public function render()
    {
        return view('livewire.input-component');
    }
}
