<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_posts';

    protected $fillable = [
        'user_id',
        'title',
        'company',
        'location',
        'type',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
