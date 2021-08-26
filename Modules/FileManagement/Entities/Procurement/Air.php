<?php

namespace Modules\FileManagement\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\Traits\Documents\HasDocument;
use Modules\FileManagement\Traits\Documents\HasFormable;

class Air extends Model
{
    use HasFormable, HasDocument;

    protected $guarded = [];
    protected $table = 'fms_form_air';
    
    protected $casts = [
        'invoice' => 'json',
        'lists' => 'json',
    ];

}
