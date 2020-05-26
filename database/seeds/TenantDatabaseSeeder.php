<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Model\Company;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * db:seed --database=company1
     *
     * @return void
     */
    public function run()
    {
        $connection = DB::getDefaultConnection();
        $company = Company::where('prefix', $connection)->first();
        Tenant::setTenant($company);
        $this->call(UserTenantsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
    }
}
