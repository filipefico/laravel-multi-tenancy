<?php

use Illuminate\Database\Seeder;
use App\Model\Category;
//use Tenant;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Tenant::getTenant();
        factory(Category::class, 10)
            ->make()
            ->each(function($category) use($company){
                $category->name = $category->name . ' ' . $company->prefix;
                $category->save();
            });
    }
}
