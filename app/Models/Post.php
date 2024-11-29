<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [ 'user_id', 'body', 'image'];

    public function like($user = null)
    {
        //dd($user);
        $this->likes()->updateOrCreate(
            [
                'user_id' => $user ? $user->id : auth()->user()->id,
            ],
            [
                'liked' => true,
            ]
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
