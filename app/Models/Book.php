<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "author",
    ];

    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }

    public function scopeTitle(Builder $query, $title)
    {
        return $query->where("title", "like", "%" . $title . "%");
    }
}
