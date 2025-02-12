<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [ 'user_id', 'body', 'image_url','parent_id'];

    public function like($user = null)
    {
        //$bool = $this->isLiked($user);
        //dd($this->isLiked($user));

        if(!$this->isLiked($user)){
            $this->likes()->updateOrCreate(
                [
                    'user_id' => $user ? $user->id : auth()->user()->id,
                ],
                [
                    'liked' => true,
                ]
            );
        }else{
            $this->likes()->updateOrCreate(
                [
                    'user_id' => $user ? $user->id : auth()->user()->id,
                ],
                [
                    'liked' => false,
                ]
            );
        }

    }

    public function isLiked($user = null)
    {
        //dd($user->likes->where('post_id', $this->id));


        $liked = false;
        if($user->likes ->where('post_id', $this->id)->where('liked', true)->count() > 0){
            $liked = true;
        }
        return $liked;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function parent()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->whereNull('parent_id')->orderByDesc('created_at');
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
