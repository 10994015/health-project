<?php

namespace App\Livewire\Cms;

use App\Exports\CommentsExport;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class CommentComponent extends Component
{
    public $comments;
    public function mount(){
        $this->comments = DB::table('givebacks')
        ->select(DB::raw('sum(case when question_1 = 1 then 1 else 0 end) as question_1,
                        sum(case when question_2 = 1 then 1 else 0 end) as question_2,
                        sum(case when question_3 = 1 then 1 else 0 end) as question_3,
                        sum(case when question_4 = 1 then 1 else 0 end) as question_4,
                        sum(case when question_5 = 1 then 1 else 0 end) as question_5,
                        sum(case when question_6 = 1 then 1 else 0 end) as question_6,
                        sum(case when question_7 = 1 then 1 else 0 end) as question_7'))
        ->first();
    }
    public function export()
    {
        return Excel::download(new CommentsExport, 'comments.xlsx');
    }
    #[Layout('livewire.layouts.cms')]
    public function render()
    {
        return view('livewire.cms.comment-component');
    }
}
