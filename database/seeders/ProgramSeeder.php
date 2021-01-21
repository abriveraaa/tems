<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Http\Traits\Acronym;

class ProgramSeeder extends Seeder
{
    use Acronym;

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
            
        	$collegeAcronym = $this->generateCollege($key);	
            
            // Create a new college
            $college = \App\Models\College::firstOrCreate([
                'description' => str_replace('_', ' ', $key),
                'code' => $collegeAcronym
            ]);
            $courses = [];

            $this->command->info('Creating College '. strtoupper($key));

            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {

                    $permissionValue = $mapPermission->get($perm);

                    $courseKey = $module . ' ' . $permissionValue;

                    $courseAcronym = $this->generateCourse($courseKey, $collegeAcronym);	

                    $courses[] = \App\Models\Course::firstOrCreate([
                        'description' => ucfirst($module) . ' ' . ucfirst($permissionValue),
                        'code' => $courseAcronym,
                    ])->id;

                    $this->command->info('Creating '.$courseAcronym.' to '. $collegeAcronym);
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
