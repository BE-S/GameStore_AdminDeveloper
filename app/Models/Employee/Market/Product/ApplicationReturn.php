<?php

namespace App\Models\Employee\Market\Product;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ApplicationReturn extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'key_id', 'employee_id', 'user_id', 'purchase_id', 'application_date', 'status', 'updated_at', 'deleted_at'
    ];

    protected $hidden = [
        'id', 'key_id', 'employee_id', 'user_id', 'purchase_id', 'updated_at', 'deleted_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function keyProduct()
    {
        return KeyProduct::whereIn('id', $this->key_id)->get();
    }

    public function findtValueStatus()
    {
        return $this->whereIn('status', ['Ожидание', 'Выполнено'])->get();
    }

    public function createApplication($keyId, $userId, $purchaseId, $applicationDate)
    {
        return $this->create([
            'key_id' => $keyId,
            'employee_id' => Auth::user()->id,
            'user_id' => $userId,
            'purchase_id' => $purchaseId,
            'application_date' => $applicationDate,
        ]);
    }

    public function checkApplicationGame($purchaseId, $returnGame)
    {
        $applications = $this->where('purchase_id', $purchaseId)->where('status', 'Выполнено')->get();

        foreach ($applications as $application) {
            if (array_intersect($returnGame, $application->game_id)) {
                return true;
            }
        }

		return false;
    }

    protected function keyId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
