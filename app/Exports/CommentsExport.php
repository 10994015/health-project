<?php
namespace App\Exports;

use App\Models\Giveback;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommentsExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        $questions = [
            'question1' => '對於永續飲食概念有更進一步瞭解，願意於生活中實踐。',
            'question2' => '瞭解含糖飲料對身體的負面影響及多喝白開水的益處。',
            'question3' => '飲料紅黃綠燈有助於選擇飲品的判斷。',
            'question4' => '我會願意於生活中實踐視力保健及口腔護理。',
            'question5' => '瞭解如何照顧及學會傷口處理，降低紅腫熱痛感染的發生。',
            'question6' => '我願意將今日所學的健康知識傳遞給身邊的同學與親友。',
            'question7' => '我會想主動學習更多相關健康知識。',
        ];

        $results = DB::table('givebacks')
            ->select(DB::raw('sum(case when question_1 = 1 then 1 else 0 end) as question_1,
                              sum(case when question_2 = 1 then 1 else 0 end) as question_2,
                              sum(case when question_3 = 1 then 1 else 0 end) as question_3,
                              sum(case when question_4 = 1 then 1 else 0 end) as question_4,
                              sum(case when question_5 = 1 then 1 else 0 end) as question_5,
                              sum(case when question_6 = 1 then 1 else 0 end) as question_6,
                              sum(case when question_7 = 1 then 1 else 0 end) as question_7'))
            ->first();

        return [
            [$questions['question1'], $results->question_1],
            [$questions['question2'], $results->question_2],
            [$questions['question3'], $results->question_3],
            [$questions['question4'], $results->question_4],
            [$questions['question5'], $results->question_5],
            [$questions['question6'], $results->question_6],
            [$questions['question7'], $results->question_7],
        ];
    }

    public function headings(): array
    {
        return [
            'Question',
            'Count',
        ];
    }
}
