<?php

namespace App\Imports;

use App\Models\SurveyQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class surveyQuestionImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $surveyQuestionSetId;

    public function __construct($surveyQuestionSetId)
    {
        $this->surveyQuestionSetId = $surveyQuestionSetId;
    }
    public function model(array $row)
    {

        // dd($row);
        return new SurveyQuestion([
            'survey_question_set_id'         => $this->surveyQuestionSetId,
            'measure_cat'                   => $row['sq_measure_cat'] ,
            'inspection_stage'              => $row['sq_inspection_stage'],
            'question_number'               => $row['sq_question_number'],
            'question'                      => $row['sq_question'],
            'can_have_photo'                => $row['sq_can_have_photo']=='true' ? '1' : '0',
            'na_allowed'                    => $row['sq_na_allowed']=='true' ? '1' : '0',
            'unable_to_validate_allowed'    => $row['sq_unable_to_validate_allowed']=='true' ? '1' : '0',
            'remote_reinspection_allowed'   => $row['sq_remote_reinspection_allowed']=='true' ? '1' : '0',
            'score_monitoring'              => $row['sq_score_monitoring']=='true' ? '1' : '0',
            'nc_severity'                   => $row['sq_nc_severity'],
            'uses_dropdown'                 => $row['sq_uses_dropdown']=='true' ? '1' : '0',
            'dropdown_list'                 => $row['sq_dropdown_list'],
            'innovation_measure'            => $row['sq_innovation_measure'],
            'innovation_question_list'      => $row['sq_innovation_question_list']=='true' ? '1' : '0',
            'measure_type'                  => $row['sq_measure_type'],
            'innovation_product'            => $row['sq_innovation_product'],
        ]);
    }
}
