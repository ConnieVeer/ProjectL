<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyUser extends Model
{
    use HasFactory;

    protected $fillable = [

        'company_id',

        'user_id',

    ];



    public function users(): BelongsToMany

    {

        return $this->belongsToMany(User::class);
    }



    public function user(): HasOne

    {

        return $this->hasOne(User::class, 'id', 'user_id');
    }



    public function companies(): BelongsToMany

    {

        return $this->belongsToMany(Company::class);
    }



    public function company(): HasOne

    {

        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
