<?php

namespace App\Models\Client\Market\Review;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewEmoji extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'user_id', 'review_id', 'emoji_id', 'updated_at', 'deleted_at'
    ];

    public function emoji()
    {
        return $this->belongsTo(Emoji::class, 'emoji_id');
    }

    public function emojiTest()
    {
        return $this->belongsToMany(Emoji::class, 'emoji_id');
    }
}
