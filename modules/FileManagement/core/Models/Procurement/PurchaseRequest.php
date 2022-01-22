<?php

namespace Modules\FileManagement\core\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\core\Enums\Document\Type as Doctype;
use Modules\FileManagement\core\Traits\HasDocument;

class PurchaseRequest extends Model
{
    use HasDocument;

    protected $table   = 'fms_procurement_request';
    protected $guarded = [];

    protected $casts = [
        'lists'       => 'json',
        'signatories' => 'json',
        'properties'  => 'json',
    ];

    public static function doctype()
    {
        return Doctype::PROCUREMENT_PURCHASE_REQUEST->value;
    }

    public function getItemsAttribute()
    {
        return collect($this->lists)->map(function ($item) {

            $cost     = floatval($item['cost'] ?? 0);
            $quantity = intval($item['quantity'] ?? 0);

            return [
                'stock'       => $item['stock'],
                'unit'        => $item['unit'],
                'description' => $item['description'],
                'quantity'    => $quantity,
                'cost'        => $cost,
                'total'       => $quantity * $cost,
            ];
        });
    }

    public function getTotalAmountAttribute()
    {
        return $this->items->sum('total');
    }
}
