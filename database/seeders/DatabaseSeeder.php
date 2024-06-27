<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\BillUser;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $companies = Company::factory(1000)->create();
        $users = User::factory(10000)->recycle($companies)->create();

        $bills = Bill::factory(10000)->state(function (array $attributes) use ($users) {
            return ['company_id' => $users->random()->company_id];
        })->create();

        $usedPairs = [];
        BillUser::factory(20000)->state(function (array $attributes) use ($users, $bills, &$usedPairs) {
            do {
                $userId = $users->random()->id;
                $billId = $bills->random()->id;
            } while (in_array("$userId:$billId", $usedPairs, true));

            $usedPairs[] = "$userId:$billId";

            return [
                'bill_id' => $billId,
                'user_id' => $userId,
            ];
        })->create();
    }
}
