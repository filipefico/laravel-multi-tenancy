<?php

use Illuminate\Database\Seeder;
use App\Model\Company;
//use Tenant;
use App\Model\UserTenant;

class UserTenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Tenant::getTenant();
        factory(UserTenant::class)->create([
            'email' => "user1@{$company->prefix}.com"
        ]);
    }
}
