<?php
namespace Modules\FileManagement\core\Traits;
use Modules\FileManagement\core\Models\Document\Form;

trait HasFormable{

    public function formable()
    {
        return $this->morphOne(Form::class, 'formable');
    }
}
