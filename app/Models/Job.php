<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'jobs';
    protected $fillable = [
        'id',
        'title',
        'language',
        'form_salary',
        'to_salary',
        'experience',
        'expire',
        'description',
        'type_of_job',
        'position',
        'view',
        'upto',
        'city_id',
        'category_id',
        'status',
        'company_id'
    ];

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
