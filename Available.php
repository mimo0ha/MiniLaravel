<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Available extends Model
{
    use HasFactory;
    protected $table = "availables";
    protected $fillable = [
        'expert_id',
        'day_id',
        'from',
        'to',
        'hour',
        'session',
        'hour',
    ];

    /*
        FK
        مين عندي id
     */
    public function expert(): BelongsTo
    {return $this->belongsTo('experts');}

    public function day(): BelongsTo
    {return $this->belongsTo('days');}


    /*
       PK
       مين اخد ال id تبعي
    */
}
