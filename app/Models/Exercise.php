<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exercise extends Model
{
    use HasFactory;

    protected $table = 'exercises';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'description',
        'question_amount',
        'working_time',
        'created_at',
        'updated_at'
    ];

    protected $nullable = [
        'created_at',
        'updated_at'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
