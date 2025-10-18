<?php
namespace App\Exports;

use App\Models\GameRecord;
use App\Models\Giveback;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return Giveback::with('game_record')
            ->select('id', 'game_record_id', 'score', 'comment', 'question_1', 'question_2', 'question_3', 'question_4', 'question_5', 'question_6', 'question_7', 'created_at', 'student_id');
        // return GameRecord::leftJoin('givebacks', 'game_records.id', '=', 'givebacks.game_record_id')
        //     ->select(
        //         'game_records.student_id',
        //         'game_records.name',
        //         'givebacks.score',
        //         'givebacks.comment',
        //         'givebacks.created_at',
        //         'givebacks.question_1',
        //         'givebacks.question_2',
        //         'givebacks.question_3',
        //         'givebacks.question_4',
        //         'givebacks.question_5',
        //         'givebacks.question_6',
        //         'givebacks.question_7'
        //     );
    }

    public function headings(): array
    {
        return [
            '學號',
            '姓名',
            '評分',
            '想說的話',
            '時間',
            '內容'
        ];
    }

    public function map($row): array
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

        $content = [];
        for ($i = 1; $i <= 7; $i++) {
            if ($row->{'question_' . $i}) {
                $content[] = $questions['question' . $i];
            }
        }

        return [
            $row->student_id,
            $row->game_record->name,
            $row->score,
            $row->comment,
            $row->created_at,
            implode(', ', $content)
        ];
    }
}
