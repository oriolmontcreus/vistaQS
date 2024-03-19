<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'survey';

    protected $fillable = ['descr', 'startDate', 'endDate'];

    public $timestamps = false;

    public function surveyors()
    {
        return $this->belongsToMany(User::class, 'survey_surveyor', 'idSurvey', 'idSurveyor');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'survey_question', 'idSurvey', 'idQuestion');
    }
}