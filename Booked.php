<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booked extends Model
{
    use HasFactory;
    protected $table = "bookeds";
    protected $fillable =[
        'expert_id',
        'user_id',
        'day_id',
        'hour',
    ];

    /*
       FK
       مين عندي id
    */
    public function expert(): BelongsTo
    {return $this->belongsTo('experts');}

    public function user(): BelongsTo
    {return $this->belongsTo('users');}

    public function day(): BelongsTo
    {return $this->belongsTo('days');}


    /*
       PK
       مين اخد ال id تبعي
    */
}
