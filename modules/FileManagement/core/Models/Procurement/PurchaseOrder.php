<?php

namespace Modules\FileManagement\core\Models\Procurement;

use Illuminate\Database\Eloquent\Model;
use Modules\FileManagement\core\Traits\HasDocument;
use Modules\FileManagement\core\Traits\HasFormable;

class PurchaseOrder extends Model
{
    use HasDocument;

    protected $guarded = [];
    protected $table   = 'fms_procurement_order';
    protected $casts   = [
        'lists'       => 'json',
        'supplier'    => 'json',
        'delivery'    => 'json',
        'pr_number'   => 'json',
        'signatories' => 'json',
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

    public function getPrsAttribute()
    {
        return collect($this->pr_number);
    }
}
