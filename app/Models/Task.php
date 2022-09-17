<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        'id',
    ];

    public function image() {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function annotation() {
        return $this->hasOne(Annotation::class);
    }
}
