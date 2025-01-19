<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'created_by'
    ];

    public function projectTime()
    {
        return $this->hasMany(ProjectTime::class);
    }
}
