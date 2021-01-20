<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateLaratrustTables();

        $config = Config::get('college_course.degree_structure');

        if ($config === null) {
            $this->command->error("The configuration has not been published.");
            $this->command->line('');
            return false;
        }

        $mapPermission = collect(config('college_course.course_map'));

        foreach ($config as $key => $modules) {
            
            $acronym = $this->generate($key);	
            
            // Create a new college
            $college = \App\Models\College::firstOrCreate([
                'description' => str_replace('_', ' ', $key),
                'code' => $key
            ]);
            $courses = [];

            $this->command->info('Creating College '. strtoupper($key));

            // Reading role permission modules
            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {

                    $permissionValue = $mapPermission->get($perm);

                    $courses[] = \App\Models\Course::firstOrCreate([
                        'description' => ucfirst($module) . ' ' . ucfirst($permissionValue),
                        'code' => $module . '-' . $permissionValue,
                    ])->id;

                    $this->command->info('Creating Permission to '.$permissionValue.' for '. $module);
                }
            }

            // Attach all courses to the college
            $college->courses()->sync($courses);
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return  void
     */
    public function truncateLaratrustTables()
    {
        $this->command->info('Truncating College and Course tables');
        Schema::disableForeignKeyConstraints();

        DB::table('college_courses')->truncate();

        if (Config::get('college_course.truncate_tables')) {
            DB::table('colleges')->truncate();
            DB::table('courses')->truncate();
        }

        Schema::enableForeignKeyConstraints();
    }
}
