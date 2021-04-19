<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Page extends Model
{
    use HasFactory, HasSlug;

    const DEFAULTS = ['/'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->preventOverwrite()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function scopeSlug(Builder $scope, string $slug): Builder
    {
        return $scope->where("slug", $slug);
    }

    public static function findBySlug(string $slug, array $columns = ['*'])
    {
        return static::slug($slug)->firstOrFail($columns);
    }
}
