<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answer';

    protected $fillable = ['answer', 'idQuestion', 'idSurveyor'];

    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(Question::class, 'idQuestion');
    }

    public function surveyor()
    {
        return $this->belongsTo(User::class, 'idSurveyor');
    }
}