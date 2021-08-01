<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = [
        'id',
        'phone',
        'address',
        'description',
        'employees',
        'facebook',
        'map_link',
        'image',
        'user_id',
        'city_id',
        'code',
        'acronym',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'company_id', 'id');
    }
}
