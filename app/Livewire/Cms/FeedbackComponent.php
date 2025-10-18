<?php

namespace App\Livewire\Cms;

use App\Models\GameRecord;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;
use App\Models\Giveback;
use Elastic\Elasticsearch\ClientBuilder;
use Livewire\Attributes\On;

class FeedbackComponent extends Component
{
    use WithPagination;
    public $limit = 50;
    public $score = '';
    public $search = '';
    public $contents = [
        'question1' => '瞭解運動對身體的好處及重要性，願意培養運動習慣。',
        'question2' => '瞭解含糖飲料對身體的負面影響及多喝白開水的益處。',
        'question3' => '飲料紅黃綠燈有助於選擇飲品的判斷。',
        'question4' => '我會願意於生活中實踐視力保健及口腔護理。',
        'question5' => '瞭解如何照顧及學會傷口處理，降低紅腫熱痛感染的發生。',
        'question6' => '我願意將今日所學的健康知識傳遞給身邊的同學與親友。',
        'question7' => '我會想主動學習更多相關健康知識。',
    ];
    public function mount(){
        $client = ClientBuilder::create()->build();
    }
    #[On('export')]
    public function export()
    {
        $export = Excel::download(new StudentsExport, '使用者回饋.xlsx');
        $this->dispatch('export-success');
        return $export;
    }
    #[Layout('livewire.layouts.cms')]
    public function render()
    {
        $query = Giveback::with(['game_record'=> function($query){
            $query->select('id','student_id', 'name');
        }]);

        if(!empty($this->score)) {
            Log::info($this->score);
            $query->where('score', $this->score);
        }

        if(!empty($this->search)) {
            $query->where(function($query) {
                $query->where('student_id', 'like', '%'.$this->search.'%')
                    ->orWhere('comment', 'like', '%'.$this->search.'%');
            })
            ->orWhereHas('game_record', function($query){
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('student_id', 'like', '%'.$this->search.'%');
            });
        }
        $query->select('id', 'game_record_id', 'student_id',  'score', 'comment', 'question_1', 'question_2', 'question_3', 'question_4', 'question_5', 'question_6', 'question_7');
        Log::info('SQL Query: ' . $query->toSql());
        Log::info('Query Bindings: ', $query->getBindings());
        if(!empty($this->limit)){
            $students = $query->paginate($this->limit);
        }else{
            $students = $query->get();
        }
        Log::info($students->toArray());
        return view('livewire.cms.feedback-component', compact('students'));
    }
}
