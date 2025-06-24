<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// class Task extends Model
// {
//     use HasFactory;
// }

class Task extends Model
{
    protected $fillable = ['title', 'is_done', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
