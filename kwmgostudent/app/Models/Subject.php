<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'lva', 'name', 'description'];

    //Subject: hasMany Relation 1:n
    public function offers(): hasMany
    {
        return $this->hasMany(Offer::class);
    }
}
