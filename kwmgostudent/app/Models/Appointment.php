<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'time_from', 'time_to', 'user_id'
    ];

    //Offer: belongsTo Relation n:1
    public function offer(): belongsTo{
        return $this->belongsTo(Offer::class);
    }
}
