<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $fillable = [
        "review",
        "rating",
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    protected static function booted()
    {
        static::updated(fn(Reviews $reviews) => cache()->forget("book:" . $reviews->book_id));
        static::deleted(fn(Reviews $reviews) => cache()->forget("book:" . $reviews->book_id));
        static::created(fn(Reviews $reviews) => cache()->forget("book:" . $reviews->book_id));
    }
}
