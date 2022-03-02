<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property array $options
 * @property string $url
 */
class Page extends Model
{
    use HasFactory, HasSlug;

    public const DEFAULTS = ['/'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->preventOverwrite()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getUrlAttribute(): string
    {
        return url($this->slug);
    }

    public function scopeSlug(Builder $scope, string $slug): Builder
    {
        return $scope->where('slug', $slug);
    }

    public static function findBySlug(string $slug, array $columns = ['*']): self
    {
        return static::slug($slug)->firstOrFail($columns);
    }
}
