<?php

namespace Database\Seeders;

use App\Models\Client\Payment\SystemPayment;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemPaymentsSeeder extends Seeder
{
    private $systems = [
        ["name" => "Мир", "path_image" => "storage/assets/payment/Мир.png", "system_id" => "2"],
        ["name" => "Mastercard", "path_image" => "storage/assets/payment/Mastercard.png", "system_id" => "5"],
        ["name" => "Visa", "path_image" => "storage/assets/payment/Visa.png", "system_id" => "4"]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->systems as $system) {
            SystemPayment::create([
                "name" => $system["name"],
                "path_image" => $system["path_image"],
                "system_id" => $system["system_id"],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }
}
