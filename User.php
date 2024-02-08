<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "users";
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'pocket',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    //  وقفتا لانو موقفة باليوزر تيبل المقابل الها
    /*protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/

    /*
        FK
        مين عندي id
     */

    /*
      PK
      مين اخد ال id تبعي
   */
    public function booked(): HasMany
    {return $this->hasMany('bookeds');}

    public function favorite(): HasMany
    {return $this->hasMany('favorites');}
}
