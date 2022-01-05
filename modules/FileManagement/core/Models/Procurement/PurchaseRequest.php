<?php

namespace Modules\FileManagement\core\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\core\Traits\HasFormable;
use Modules\FileManagement\core\Traits\HasSeries;

class PurchaseRequest extends Model
{
    use HasSeries, HasFormable;

    protected $table   = 'fms_procurement_request';
    protected $guarded = [];

    protected $casts = [
        'lists'       => 'json',
        'signatories' => 'json',
        'properties'  => 'json',
    ];

    public function getItemsAttribute()
    {
        return collect($this->lists)->map(function ($item, $key) {

            $amount   = floatval($item['amount'] ?? 0);
            $quantity = intval($item['quantity'] ?? 0);

            return [
                'stock'       => $item['stock'],
                'unit'        => $item['unit'],
                'description' => $item['description'],
                'quantity'    => $quantity,
                'amount'      => $amount,
                'cost'        => $quantity * $amount,
            ];
        });
    }

    public function getTotalAmountAttribute()
    {
        return $this->items->sum('cost');
    }
}
