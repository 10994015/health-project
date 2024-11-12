<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Redis;
use Livewire\Attributes\Layout;
use Livewire\Component;

class HomeComponent extends Component
{
    public $type;
    public function mount(){
        $this->type = rand(1, 4);
    }
    public function gotoGame(){
        $signedurl = str()->random(30);
        Redis::setex('game_signed_url:' . $signedurl, 300, $signedurl);
        return redirect()->route('game', ['type' => $this->type, 'signedurl' => $signedurl]);
    }
    #[Layout('livewire.layouts.app')]
    public function render()
    {
        return view('livewire.home-component');
    }
}
