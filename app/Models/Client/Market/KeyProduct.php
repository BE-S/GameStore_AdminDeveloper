<?php

namespace App\Models\Client\Market;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class KeyProduct extends Model
{
    protected $guarded = [];

    public function getReservationProduct($user_id)
    {
        return $this->where("user_id", $user_id)->first();
    }

    public function getProduct($id)
    {
        return $this->where("game_id", $id)->where("deleted_at", null)->first();
    }
}
