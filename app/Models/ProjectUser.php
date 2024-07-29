<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProjectUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'user_id',
    ];

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
    public function user(): HasOne {
        return $this->hasOne('App\Models\User', 'id' , 'user_id');
    }

    public function projects(){
        return $this->belongsToMany('App\Models\Project');
    }
    public function project(): HasOne {
        return $this->hasOne('App\Models\Project', 'id' , 'project_id');
    }

}
