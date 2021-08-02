<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'jobs';

    public function city() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function seekers()
    {
        return $this->belongsToMany(Seeker::class, 'job_seeker', 'job_id', 'seeker_id');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

}
