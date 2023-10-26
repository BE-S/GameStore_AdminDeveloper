<?php

namespace App\Models\Employee\Market;

use Illuminate\Database\Eloquent\Model;

class AvatarPublisher extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'publisher_id', 'path'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function add($publisher_id, $path)
    {
        return $this->create([
            'publisher_id' => $publisher_id,
            'path' => $path
        ]);
    }

    public function updateAvatar($path)
    {
        $this->update([
            'path' => $path
        ]);
    }
}
