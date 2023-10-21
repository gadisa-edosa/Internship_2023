<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    public $table = "result";

    protected $fillable = [
        'exam_id',
        'student_id',
        'question_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'student_id');
    }

    public function exam()
    {
        return $this->hasOne(Exam::class, 'id', 'exam_id');
    }
    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function answers()
    {
        return $this->hasOne(Answer::class, 'id', 'answer_id');
    }
}
