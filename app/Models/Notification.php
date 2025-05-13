<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'post_id','actor_id'];

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

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
