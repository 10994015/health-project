<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Livewire\Attributes\Layout;
use Livewire\Component;

class GameComponent extends Component
{
    public $type;
    public function mount(Request $request){
        $signedurl = Redis::get('game_signed_url:' . $request->signedurl);
        $this->type = $request->type;
        Log::info($signedurl);
        if (!$signedurl) {
            abort(403, '這個連結已經過期或無效。');
        }
    }
    public function submit(){
        $signedurl = str()->random(30);
        Redis::setex('input_signed_url:' . $signedurl, 10, $signedurl);
        return redirect()->route('input', ['type' => $this->type, 'signedurl' => $signedurl]);
    }
    #[Layout('livewire.layouts.game')]
    public function render()
    {
        return view('livewire.game-component');
    }
}
