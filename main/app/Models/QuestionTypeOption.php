<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionTypeOption extends Model
{
    use HasFactory;

    protected $table = 'questiontype_option';

    protected $fillable = ['option', 'idQuestion'];

    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(Question::class, 'idQuestion');
    }
}