<?php

namespace Modules\FileManagement\Tests\Feature\Document;

use Tests\TestCase;
use App\Models\Account;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\System\Entities\Office\SYS_Office;

class ActivationTest extends TestCase
{

    /** @test */
    public function test_only_authenticated_user_can_access_the_activation_page()
    {
        $response = $this->get(route('fms.documents.activation.index'));
        $response->assertRedirect(route('login'));

        $response = $this->actingAs($this->user)->get(route('fms.documents.activation.index'));
        $response->assertStatus(200);
    }

    public function test_only_authorized_employee_can_access_activation_page()
    {
        $this->authorize_test(route('fms.documents.activation.index'));
    }

    /** @test
     * @depends test_only_authenticated_user_can_access_the_activation_page
     */
    public function test_all_fields_are_required()
    {
        $user = $this->user;
        $this
            ->actingAs($user)
            ->postJson(route('fms.documents.activation.submit'), $this->form_data(), $this->ajax_header)
            ->assertStatus(422);
    }


    private function form_data()
    {
        return [
            'document'  => '',
            'liaison'   => ''
        ];
    }
    
    
    
}
