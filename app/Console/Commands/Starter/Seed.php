<?php

namespace App\Console\Commands\Starter;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\System\Entities\SYS_User;

class Seed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'starter:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds all must information for startup.';

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
     * @return int
     */
    public function handle()
    {
        // Resseting all the database
        $this->line('Rolling back all migrations');
            Artisan::call('migrate:fresh');
            $this->line(Artisan::output());
        $this->info('Migaration has been refresh');


        // Calling the seeders
        $this->line('Seeding permissions');
            Artisan::call('module:seed System --class=PermissionTableSeeder');
        $this->info('Permissions has been seed.');

        $this->line('Seeding offices');
            Artisan::call('module:seed System --class=OfficeTableSeeder');
        $this->info('Offices has been seed.');

        $this->line('Seeding salary grade');
            Artisan::call('module:seed HumanResource --class=SalaryGradeTableSeeder');
        $this->info('Salary grade has been seed.');

        $this->line('Seeding plantilla position');
            Artisan::call('module:seed HumanResource --class=PositionTableSeeder');
        $this->info('Positions has been seed.');

        $this->line('Creating new user');

            $employee = factory(HR_Employee::class, 1)->create();
            $user = SYS_User::create([
                'employee_id' => 1,
                'username' => 'sUp3r@DMiN',
                'password' => bcrypt('@l03e1t3'),
                'status' => true
            ]);
            $user->givePermissionTo('godmode');

        $this->info('User has been created.');

        $this->info('Started seeds has been finished.');

    }
}
