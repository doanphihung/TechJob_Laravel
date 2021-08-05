<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'cities';
    protected $fillable = ['name'];

    public function seekers()
    {
        return $this->hasMany(Seeker::class, 'city_id', 'id');
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'city_id', 'id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'city_id', 'id');
    }
}
