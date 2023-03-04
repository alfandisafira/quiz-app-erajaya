<?php

namespace App\Models;

use App\Models\Answer;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'question_sentence',
        'exercise_id',
        'answer_id',
        'created_at',
        'updated_at'
    ];

    protected $nullable = [
        'created_at',
        'updated_at'
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
