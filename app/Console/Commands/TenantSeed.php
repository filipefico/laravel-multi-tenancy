<?php

namespace App\Console\Commands;

use App\Model\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tenant;

class TenantSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Schema::hasTable((new Company())->getTable())) {
            $companies = Company::all();
            foreach ($companies as $company) {
                DB::statement("DROP DATABASE IF EXISTS {$company->database};");
            }
            $this->info('Tenant database dropped');
        }

        $this->info('Seeding system');
        $this->call('migrate:fresh', [
            '--database' => 'system',
            '--path' => 'database/migrations/system'
        ]);
        $this->info('Finish Migrate Fresh');

        $this->call('db:seed', [
            '--class' => 'DatabaseSeeder'
        ]);
        $this->info('Seeding system finished');

        Tenant::loadConnections();
        $this->info('Tenant Create Start');

        $companies = Company::all();
        $this->call('tenant:create', [
            '--ids' => implode(",", $companies->pluck('id')->toArray()),
        ]);
        $this->info('Tenant Create Finish');

        foreach ($companies as $company){
            $this->call('db:seed', [
                '--database' => $company->prefix,
                '--class' => 'TenantDatabaseSeeder'
            ]);
        }
    }
}
