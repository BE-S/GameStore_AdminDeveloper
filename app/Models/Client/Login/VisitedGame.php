<?php

namespace App\Models\Client\Login;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class VisitedGame extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'user_id', 'visit', 'deleted_at'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function getVisit($gameId)
    {
        return $this->where('user_id', auth()->user()->id)->first();
    }

    public function add($gameId)
    {
        $this->create([
            'user_id' => auth()->user()->id,
            'visit' => [
                ['game_id' => $gameId, 'count' => 1]
            ]
        ]);
    }

    public function change($visits)
    {
        $this->update([
            'visit' => $visits
        ]);
    }

    /**
     * Get the visits
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function visit(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
