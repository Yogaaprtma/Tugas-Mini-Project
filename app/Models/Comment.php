<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'posting_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posting()
    {
        return $this->belongsTo(Posting::class);
    }

    public function replies()
    {
        return $this->hasMany(ReplyComment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

}
