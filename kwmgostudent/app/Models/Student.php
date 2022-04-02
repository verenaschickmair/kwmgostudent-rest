<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'firstname', 'lastname', 'course_of_studies',
        'studies_type', 'semester', 'phone', 'email'];

    public function isFavorite():bool{
        return $this->rating >= 4;
    }

    public function scopeFavorite($query){
        return $query->where('rating', '>=', '4');
    }

    //hasMany Relation 1:n
    public function subjects() : hasMany{
        return $this->hasMany(Subject::class);
    }

    //belongsTo Relation 1:1
    public function user(): hasOne{
        return $this->hasOne(User::class);
    }
}
