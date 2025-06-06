<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasFactory , HasApiTokens;

    protected $fillable = [ 'user_id', 'body', 'image_url','parent_id','published_at'];

    public function isLiked($user = null)
    {
        if (!$user) {
            return false;
        }

        return $user->likes->where('post_id', $this->id)->where('liked', true)->count() > 0;
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function scopeWithLikesCount($query)
    {
        return $query->withCount('likes');
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->whereNull('parent_id')
            ->orderByDesc('created_at')->where('published_at', '<=', now());
    }

    public function scopeRecentChilds(Builder $query, $parent_id): Builder
    {
        return $query->where('parent_id', $parent_id)
            ->orderBy('created_at', 'desc')->where('published_at', '<=', now());
    }

    public function scopePublishedMainPostsByUser($query, $userId)
    {
        return $query->where('user_id', $userId)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc');
    }

    public function scopeTopLikedLastDay($query, $limit = 5)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDay())
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->take($limit);
    }

    public function parent()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function topics(): BelongsToMany {
        return $this->belongsToMany(Topic::class, 'post_topic');
    }



}
