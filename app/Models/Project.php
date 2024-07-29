<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'company_id',
        'user_id',
        'days',
    ];

    public function owner(): User // komt op het zelfde neer als BelongsTo
    { 
        return User::where('id', '=', $this->user_id)->first();
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'project_users', 'project_id', 'user_id')-> distinct();
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function comments(): MorphMany
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    
}
