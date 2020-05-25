<?php


namespace App\Tenant;


use App\Model\Company;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class TenantManager
{
    private $tenant;

    public function getTenant(): ?Company
    {
        return $this->tenant;
    }

    public function setTenant(?Company $company): void
    {
        $this->tenant = $company;
        $this->makeTenantConnection();
    }

    private function makeTenantConnection()
    {
        $clone = config('database.connections.system');
        $clone['database'] = $this->tenant->database;

        Config::set('database.connections.tenant', $clone);
        DB::reconnect('tenant');
    }

    public function loadConnections()
    {
        if(Schema::hasTable((new Company())->getTable())){
            $companies = Company::all();

            foreach ($companies as $company) {
                $clone = config('database.connections.system');
                $clone['database'] = $company->database;
                Config::set("database.connections.{$company->prefix}", $clone);
            }
        }
    }

    public function isTenantRequest()
    {
        return Request::is('system/*') == false && Request::route('prefix');
    }
}
