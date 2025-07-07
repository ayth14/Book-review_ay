<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
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

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder | QueryBuilder
    {
        return $query->withCount([
            'reviews' =>
            fn(Builder $q) =>
            $this->dateRangeFilter($q, $from, $to)
        ])
            ->orderByDesc('reviews_count');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder | QueryBuilder
    {
        return $query->withAvg([
            'reviews' =>
            fn(Builder $q) =>
            $this->dateRangeFilter($q, $from, $to)
        ], 'rating')
            ->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder | QueryBuilder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }
    private function dateRangeFilter(Builder $qry, $from = null, $to = null)
    {
        if ($from && !$to) {
            $qry->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $qry->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $qry->whereBetween('created_at', [$from, $to]);
        }
    }
}
