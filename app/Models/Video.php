<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'video_url',
        'featured_image',
        'category_id',
        'status',
        'published_at',
    ];

    /**
     * Get the category that owns the video.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include published videos.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    
    public function getEmbedUrlAttribute()
    {
        return generateEmbedLink($this->video_url);
    }


}
