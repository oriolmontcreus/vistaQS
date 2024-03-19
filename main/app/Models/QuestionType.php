<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;

    protected $table = 'questiontype';

    protected $fillable = ['typeName'];

    public $timestamps = false;

    public function questions()
    {
        return $this->hasMany(Question::class, 'idQuestionType');
    }
}