<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'featured_image', 'category_id', 'status', 'published_at', 'slug',
    ];

    protected $dates = ['published_at']; // Asegúrate de que Laravel trate este campo como un objeto Carbon

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->generateUniqueSlug();
        });

        static::updating(function ($post) {
            $post->generateUniqueSlug();
        });
    }

    protected function generateUniqueSlug()
    {
        $this->slug = Str::slug($this->title);
        
        $originalSlug = $this->slug;
        $count = 2;

        while (static::where('slug', $this->slug)->where('id', '<>', $this->id)->exists()) {
            $this->slug = "{$originalSlug}-{$count}";
            $count++;
        }
    }

    public static function getYears()
    {
        return static::published()
            ->orderBy('published_at', 'desc')
            ->get()
            ->groupBy(function ($post) {
                return Carbon::parse($post->published_at)->format('Y');
            })->keys();
    }

    public static function getPostsByYear()
    {
        return static::published()
            ->orderBy('published_at', 'desc')
            ->get()
            ->groupBy(function ($post) {
                return Carbon::parse($post->published_at)->format('Y');
            })->map(function ($yearPosts) {
                return $yearPosts->groupBy(function ($post) {
                    return Carbon::parse($post->published_at)->format('m'); 
                })->map(function ($monthPosts, $month) {
                    return [
                        'month' => ucfirst(Carbon::parse($monthPosts->first()->published_at)->translatedFormat('F')),
                        'monthNumber' => $month,
                        'count' => $monthPosts->count(),
                    ];
                });
            });
    }
}
