<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TaskUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'task_id',
    ];

    public function user(): HasOne {
        return $this->hasOne('App\Models\User', 'id' , 'user_id');
    }

    public function task(): HasOne{
        return $this->hasOne('App\Models\Task');
    }

}

