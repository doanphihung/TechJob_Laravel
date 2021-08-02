<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $table = 'languages';
    public function jobs()
    {
        return $this->belongsToMany(Language::class, 'job_language', 'language_id', 'job_id');
    }
}
