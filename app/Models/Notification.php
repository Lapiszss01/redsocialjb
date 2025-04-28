<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'post_id'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('relation_type', 'is_read')
            ->withTimestamps();
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    static function notifyPostLike(User $actor, Post $post)
    {

        if ($actor->id === $post->user_id) return;

        $notification = Notification::create([
            'message' => "{$actor->name} le dio like a tu post",
            'post_id' => $post->id
        ]);

        $notification->users()->attach($post->user_id, [
            'relation_type' => 'like',
            'is_read' => false,
        ]);
    }

    static function notifyPostComment(User $actor, Post $post)
    {

        if ($actor->id === $post->user_id) return;

        $notification = Notification::create([
            'message' => "{$actor->name} comentó en tu post",
            'post_id' => $post->id,
        ]);

        $notification->users()->attach($post->user_id, [
            'relation_type' => 'comment',
            'is_read' => false,
        ]);
    }
}
