<?php

namespace Modules\FileManagement\Tests\Unit\Document;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentTest extends TestCase
{
    /** @test */
    public function test_document_can_be_view()
    {
        $this->actingAs($this->user)->get(route('fms.documents.index'))->assertSeeTextInOrder([
            'Document Types',
            'Select document type'
        ]);
    }

    /** @test */
    public function test_only_authorized_employee_can_access_the_document_types()
    {
        $this->authorize_test(route('fms.documents.index'));
    }
    
    
}
