<?php

namespace App\Models\Client\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emoji extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'name', 'path', 'updated_at'
    ];

    public function reviewEmoji()
    {
        return $this->hasOne(ReviewEmoji::class, 'emoji_id');
    }
}
