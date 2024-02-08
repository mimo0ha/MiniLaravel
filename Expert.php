<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Expert extends Authenticatable
{
    use  HasApiTokens, HasFactory;
    protected $table = "experts";
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'skill_id',
        'description',
        'pocket',
        'price',
        'photo',
    ];
    protected $hidden =[
        'remember_token',];

    /*
        FK
        مين عندي id
     */
    public function skill(): BelongsTo
    {return $this->belongsTo('skills');}
    /*
       PK
       مين اخد ال id تبعي
    */
    public function available(): HasMany
    {return $this->hasMany('availables');}

    public function booked(): HasMany
    {return $this->hasMany('bookeds');}

    public function favorite(): HasMany
    {return $this->hasMany('favorites');}
}
