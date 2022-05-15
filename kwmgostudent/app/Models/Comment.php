<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'description', 'offer_id', 'user_id'
    ];

    //Offer: belongsTo Relation n:1
    public function offer(): belongsTo{
        return $this->belongsTo(Offer::class);
    }

}
