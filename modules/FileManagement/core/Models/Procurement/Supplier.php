<?php

namespace Modules\FileManagement\core\Models\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\database\factories\Procurement\SupplierFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'fms_procurement_supplier';
    protected $guarded = [];

    protected static function newFactory()
    {
        return SupplierFactory::new();
    }
}
