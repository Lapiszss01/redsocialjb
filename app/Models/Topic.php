<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Topic extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = ['name'];

    public function posts(): BelongsToMany {
        return $this->belongsToMany(Post::class, 'post_topic');
    }

    public function scopeTopTopics($query, $limit = 5)
    {
        return $query->select('topics.name', DB::raw('COUNT(post_topic.post_id) as post_count'))
            ->join('post_topic', 'topics.id', '=', 'post_topic.topic_id')
            ->groupBy('topics.name')
            ->orderByDesc('post_count')
            ->limit($limit);
    }

    public function scopeTopTopicsOfToday($query, $limit = 5)
    {
        return $query->select('topics.id', 'topics.name', DB::raw('COUNT(*) as usage_count'))
            ->join('post_topic', 'topics.id', '=', 'post_topic.topic_id')
            ->join('posts', 'posts.id', '=', 'post_topic.post_id')
            ->whereDate('posts.created_at', now()->toDateString())
            ->groupBy('topics.id', 'topics.name')
            ->orderByDesc('usage_count')
            ->limit($limit)
            ;
    }

}
