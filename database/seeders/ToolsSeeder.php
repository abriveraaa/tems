<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ToolsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateLaratrustTables();

        $config = Config::get('tool_seeder.category_structure');

        if ($config === null) {
            $this->command->error("The configuration has not been published.");
            $this->command->line('');
            return false;
        }

        foreach ($config as $key => $modules) {
                       
            // Create a new category
            $category = \App\Models\Category::firstOrCreate([
                'description' => str_replace('_', ' ', $key),
            ]);
            $name = [];

            $this->command->info('Creating Category '. strtoupper($key));

            foreach ($modules as $module) {

                    $name[] = \App\Models\ToolName::firstOrCreate([
                        'description' => ucfirst($module),
                    ])->id;

                    $this->command->info('Creating '.$module .' to '. $key);
            }

            // Attach all toolname to the category
            $category->items()->sync($name);
        }
    }

    /**
     *
     * @return  void
     */
    public function truncateLaratrustTables()
    {
        $this->command->info('Truncating Category and Toolname tables');
        Schema::disableForeignKeyConstraints();

        DB::table('category_toolnames')->truncate();

        if (Config::get('tool_seeder.truncate_tables')) {
            DB::table('categories')->truncate();
            DB::table('tool_names')->truncate();
        }

        Schema::enableForeignKeyConstraints();
    }
}
