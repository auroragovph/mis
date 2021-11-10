<?php

namespace Modules\FileManagement\Entities\Document;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
   protected $guarded = [];
   protected $table = 'fms_documents_form';

   public function formable()
   {
      return $this->morphTo();
   }
}
