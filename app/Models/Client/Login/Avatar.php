<?php

namespace App\Models\Client\Login;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'path_big', 'path_small', 'updated_at', 'deleted_at'
    ];

    public function updateAvatar($square, $circle)
    {
        $this->update([
            'path_big' => $square,
            'path_small' => $circle
        ]);
    }
}
