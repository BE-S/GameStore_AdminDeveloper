<?php

namespace App\Models\Employee\Client;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
         'user_id', 'updated_at', 'deleted_at'
    ];

    public function banUser($id)
    {
        $this->create([
            'user_id' => $id
        ]);
    }

    public function unbannedUser()
    {
        $this->update([
            'deleted_at' => Carbon::now()
        ]);
    }
}
