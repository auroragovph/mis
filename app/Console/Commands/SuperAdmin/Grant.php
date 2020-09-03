<?php

namespace App\Console\Commands\SuperAdmin;

use Illuminate\Console\Command;
use Modules\System\Entities\SYS_User;

class Grant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sudo:grant {userID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant a user with super admin powers';

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
        $id = $this->argument('userID');

        $user = SYS_User::find($id);

        // checking if user exists
        if(!$user || $user == null){
            $this->error('User not found!');
            return;
        }


        // checking if user already has permission
        if($user->hasPermissionTo('sys.sudo')){
            $this->info('User is already a super admin.');
            return;
        }

        // granting user
        $user->givePermissionTo('sys.sudo');
        $this->info('User has been granted.');
        return 0;
    }
}
