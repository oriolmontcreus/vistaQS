<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'question';

    protected $fillable = ['question', 'idQuestionType'];

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class, 'idQuestionType');
    }

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_question', 'idQuestion', 'idSurvey');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'idQuestion');
    }

    public function questionTypeOptions()
    {
        return $this->hasMany(QuestionTypeOption::class, 'idQuestion');
    }
}
