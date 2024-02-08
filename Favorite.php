<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;
    protected $table = "favorites";
    protected $fillable = [
        'user_id',
        'expert_id',
    ];

    /*
        FK
        مين عندي id
     */
    public function user(): BelongsTo
    {return $this->belongsTo('users');}

    public function expert(): BelongsTo
    {return $this->belongsTo('experts');}

    /*
       PK
       مين اخد ال id تبعي
    */
}
