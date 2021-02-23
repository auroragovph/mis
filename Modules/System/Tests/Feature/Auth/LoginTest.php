<?php

namespace Modules\System\Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertTrue;

class LoginTest extends TestCase
{
    /** @test */
    public function test_authenticated_users_must_redirect_to_dashboard()
    {
        $this->actingAs($this->user)->get(route('login'))->assertRedirect(route('dashboard'));
    }
    

    /** @test */
    public function test_unauthenticated_user_can_authenicated_with_correct_credentials()
    {
        $this
            ->postJson(route('login'), [
                'username' => 'xijeixhan',
                'password' => 'user123'
            ], $this->ajax_header)->assertJsonFragment(['message' => 'Authentication success']);
    }

    /** @test */
    public function test_unauthenticated_user_cannot_authenticated_with_wrong_password()
    {
        $this
            ->postJson(route('login'), [
                'username' => 'xijeixhan',
                'password' => 'user1234'
            ], $this->ajax_header)->assertJsonFragment(['message' => 'The given data was invalid.']);
    }

    /** @test */
    public function test_authenticated_user_cannot_post_login_credentials()
    {
        $this
            ->actingAs($this->user)
            ->postJson(route('login'), [
                'username' => 'xijeixhan',
                'password' => 'user1234'
            ], $this->ajax_header)
            ->assertStatus(302);
    }
    
    
        
}
