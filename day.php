<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class day extends Model
{
    use HasFactory;
    protected $table = "days";

    protected $fillable = ['name',];

    /*
        FK
        مين عندي id
     */


    /*
       PK
       مين اخد ال id تبعي
    */
    public function available(): HasMany
    {return $this->hasMany('availables');}

    public function booked(): HasMany
    {return $this->hasMany('bookeds');}
}
