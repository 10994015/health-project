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
    public $game_seconds = 0;
    public $signedurl;
    public function mount(Request $request)
    {
        $this->signedurl = $request->signedurl;
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
        if (strlen($this->student_id) < 8) {
            $this->dispatch('error-alert', ['message' => '學號必須是8位數。']);
        }
        $this->validate([
            'student_id' => 'required|size:8',
            'name' => 'required',
            'score' => 'required|numeric',
        ], [
            'student_id.required' => '學號為必填的。',
            'student_id.size' => '學號必須是8位數。',
            'name.required' => '姓名是必填的。',
            'score.required' => '分數是必填的。',
            'score.numeric' => '分數必須是數字。',
        ]);
        DB::beginTransaction();
        try {
            if (Giveback::where('signed_url', $this->signedurl)->exists()) {
                $this->dispatch('error-alert-commited', ['message' => '該局已經提交過，若要重複提交，請返回首頁並重新開始遊戲。']);
                DB::rollBack();
                return;
            }
            $game_record = GameRecord::where('student_id', $this->student_id)
                ->first();

            if (!$game_record) {
                $game_record = GameRecord::create([
                    'student_id' => $this->student_id,
                    'name' => $this->name
                ]);
            } else {
                $game_record->update(['name' => $this->name]);
            }

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
            $giveback->signed_url = $this->signedurl;
            $giveback->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return;
        }


        return redirect()->route('finish')->with('from_input', true);
    }
    #[Layout('livewire.layouts.app')]
    public function render()
    {
        return view('livewire.input-component');
    }
}
