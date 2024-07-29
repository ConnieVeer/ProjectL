<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'project_id',
        'hours',
        'user_id'
    ];

    public function owner(): User // komt op het zelfde neer als BelongsTo
    { 
        return User::where('id', '=', $this->user_id)->first();
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'task_users', 'task_id', 'user_id')-> distinct();
        return $this->belongsToMany(User::class);

    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
