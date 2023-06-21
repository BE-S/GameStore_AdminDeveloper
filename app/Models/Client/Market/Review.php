<?php

namespace App\Models\Client\Market;

use App\Models\Client\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'user_id', 'game_id', 'review', 'grade', 'updated_at'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewEmoji()
    {
        return $this->hasMany(ReviewEmoji::class, 'review_id');
    }

    public function ultimate($gameId)
    {
        $grade = $this->selectRaw('count(*), grade')->where('game_id', $gameId)->groupBy('grade')->whereNull('deleted_at')->get();

        if ($grade->isEmpty()) {
            return 'Отсутствуют';
        }

        $bads = $grade->where('grade', false)->first();
        $goods = $grade->where('grade', true)->first();

        if (!$bads) {
            return 'положительные';
        }
        if (!$goods) {
            return 'отрицательные';
        }

        $parcentBads = ($bads->count / $goods->count) * 100;
        $parcentGoods = 100 - $parcentBads;

        if ($parcentBads >= 40 && $parcentGoods >= 40 || $bads == $goods) {
            return 'смешанные';
        }
        return $parcentBads > $parcentGoods ? 'отрицательные' : 'положительные';
    }

    public function reviewEmojiCount()
    {
        return $this->hasMany(ReviewEmoji::class, 'review_id')
            ->selectRaw('emoji_id, count(*) as num')
            ->where('review_id', $this->id)
            ->whereNull('deleted_at')
            ->groupBy('emoji_id');
    }

    public function createdReview($data)
    {
        return $this->create([
            'user_id' => $data['user_id'],
            'review' => $data['review'],
            'score' => $data['score'],
        ]);
    }

    public function updateReview()
    {
        return $this->update([
            'review' => $this->review,
            'score' => $this->score,
        ]);
    }
}
