<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    use HasFactory;
    protected $table = 'seekers';

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_seeker', 'seeker_id', 'job_id');
    }
}
