<?php

namespace App\Models\Client\Market\Product;

use App\Models\Employee\Market\AvatarPublisher;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'name', 'updated_at', 'deleted_at'
    ];

    protected $hidden = [
        'updated_at', 'deleted_at'
    ];

    public function avatar()
    {
        return $this->hasOne(AvatarPublisher::class, 'publisher_id');
    }
}
