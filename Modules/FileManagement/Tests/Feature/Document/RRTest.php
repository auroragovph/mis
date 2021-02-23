<?php

namespace Modules\FileManagement\Tests\Feature\Document;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RRTest extends TestCase
{
    /** @test */
    public function test_only_authorized_employee_can_receive_or_release_the_document()
    {
        $this->authorize_test(route('fms.documents.rr.index'));
    }

}
