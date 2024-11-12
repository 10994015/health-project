<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
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
    public $comment = '';
    public function mount(Request $request){
        $signedurl = Redis::get('input_signed_url:' . $request->signedurl);
        $this->type = $request->type;
        Log::info($signedurl);
        if (!$signedurl) {
            abort(403, '這個連結已經過期或無效。');
        }
    }
    public function submit(){

        return redirect()->route('game', ['type' => $this->type, 'signedurl' => Redis::get('game_signed_url:' . $this->type)]);
    }
    #[Layout('livewire.layouts.app')]
    public function render()
    {
        return view('livewire.input-component');
    }
}
