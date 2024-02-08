<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    use HasFactory;

    protected $table = "skills";

    protected $fillable = ['name',];


        /*
            FK
            مين عندي id
         */

        /*
           PK
           مين اخد ال id تبعي
        */
    public function expert(): HasMany
    {return $this->hasMany('experts');}
}
