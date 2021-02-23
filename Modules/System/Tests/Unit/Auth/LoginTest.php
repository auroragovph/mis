<?php

namespace Modules\System\Tests\Unit\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /** @test */
    public function test_unauthenticated_users_can_view_login_form()
    {
        $this->get(route('login'))->assertSeeText('Sign In');
    }
    
}
