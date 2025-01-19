<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_comment',
        'project_start',
        'project_end',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
