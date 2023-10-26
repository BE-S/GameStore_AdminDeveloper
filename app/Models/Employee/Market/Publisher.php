<?php

namespace App\Models\Employee\Market;

use App\Models\Client\Market\Product\Publisher as clientPublisher;
use Illuminate\Support\Carbon;

class Publisher extends clientPublisher
{
    public function add($name)
    {
        return $this->create([
            'name' => $name,
        ]);
    }

    public function change($name)
    {
        return $this->update([
            'name' => $name,
        ]);
    }

    public function delete()
    {
        return $this->update([
            'deleted_at' => Carbon::now()
        ]);
    }
}
