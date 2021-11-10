<?php

namespace Modules\AwardCommittee\Entities\Procurement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'bac_supplier';
    
    protected static function newFactory()
    {
        return \Modules\AwardCommittee\Database\factories\Procurement\SupplierFactory::new();
    }
}
