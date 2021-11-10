<?php
namespace Modules\FileManagement\Traits\Documents;

use Modules\FileManagement\Entities\Document\Form;

trait HasFormable{

    public function formable()
    {
        return $this->morphOne(Form::class, 'formable');
    }
}