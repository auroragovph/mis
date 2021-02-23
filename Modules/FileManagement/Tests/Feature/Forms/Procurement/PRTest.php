<?php

namespace Modules\FileManagement\Tests\Feature\Forms\Procurement;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PRTest extends TestCase
{
    /** @test */
    public function test_only_authorized_employee_can_create_the_document()
    {
        $this->authorize_test(route('fms.procurement.request.create'));
    }

    public function test_display_purchase_request_table_page()
    {
        $this
            ->actingAs($this->user)
            ->get(route('fms.procurement.request.index'))
            ->assertSeeInOrder([
                'Purchase Request (PR)',
                'Provincial Government of Aurora'
            ]);
    }




    
}
