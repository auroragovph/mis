<?php

namespace Tests;

use App\Models\Account;
use Database\Seeders\TestingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $user; 
    protected $ajax_header = ['X-Requested-With' => 'XMLHttpRequest'];

    protected $seed = true;
    protected $seeder = TestingSeeder::class;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();
        
        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
        $this->user = Account::find(1);
    }

    protected function authorize_test($route)
    {
        $user = $this->user;
        $user->syncPermissions();
        $this->actingAs($user)->get($route)->assertStatus(403);
    }
}
