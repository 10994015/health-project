<?php

namespace App\Livewire;

use App\Models\Counter;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

class FinishComponent extends Component
{
    public $visitorCount;
    public $fromInput;
    public function mount(){
        $this->fromInput = Session::get('from_input', false);

        if (!Session::has('visited')) {
            // 如果沒有，增加訪客計數
            $counter = Counter::first();
            if (!$counter) {
                $counter = new Counter();
                $counter->count = 1;
                $counter->save();
            } else {
                $counter->increment('count');
            }

            // 設置 session 標記
            Session::put('visited', true);
        }

        // 獲取當前訪客計數
        $this->visitorCount = Counter::first()->count ?? 0;
    }
    #[Layout('livewire.layouts.app')]
    public function render()
    {
        return view('livewire.finish-component');
    }
}
