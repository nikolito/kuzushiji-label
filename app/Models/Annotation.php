<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Annotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function task() {
        return $this->belongsTo(Task::class, 'task_id'):
    }

    public function workFile() {
        return $this->belongsTo(WorkFile::class, 'work_file_id');
    }

    public function baseRecognitionFile() {
        return $this->belongsTo(BaseRecognitionFile::class, 'base_recognition_file_id');
    }
}
