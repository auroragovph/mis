<?php

namespace App\Console\Commands\SuperAdmin;

use Illuminate\Console\Command;
use Modules\System\Entities\SYS_User;

class Revoke extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sudo:revoke {userID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke the super admin permission';

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
        if(!$user->hasPermissionTo('godmode')){
            $this->info('User has no super admin permission');
            return;
        }

        // granting user
        $user->revokePermissionTo('godmode');
        $this->info('User permission has been revoked.');
        return 0;
    }
}
