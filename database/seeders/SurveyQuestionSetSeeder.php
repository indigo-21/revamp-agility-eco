<?php

namespace Database\Seeders;

use App\Models\SurveyQuestionSet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveyQuestionSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = array(
            [
                'question_revision' => 'Agility_V1_2023_02_03',
                'question_set' => 'Agility Standard V1',
            ],
            [
                'question_revision' => 'Agility_V1-1_2023_07_03',
                'question_set' => 'Agility Standard V1-1',
            ],
            [
                'question_revision' => 'GSENZH_V1_2024_08_06',
                'question_set' => 'GSENZH 2024 V1',
            ],
            [
                'question_revision' => 'GSENZH_V1_2024_09_02',
                'question_set' => 'GSENZH 2024 V1.1',
            ],
            [
                'question_revision' => 'GSENZH_V1_2024_09_06',
                'question_set' => 'GSENZH 2024 V1.2',
            ],

        );

        foreach ($values as $value) {
            SurveyQuestionSet::create([
                'question_revision' => $value['question_revision'],
                'question_set' => $value['question_set'],
            ]);
        }
    }
}
