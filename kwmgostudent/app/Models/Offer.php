<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'description', 'user_id', 'subject_id'
    ];

    //User: belongsToMany Relation n:1
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    //Subject: belongsToMany Relation n:1
    public function subject(): BelongsTo{
        return $this->belongsTo(Subject::class);
    }

    //Subject: hasMany Relation 1:n
    public function appointments(): hasMany{
        return $this->hasMany(Appointment::class);
    }
}
