<?php

namespace Modules\FileManagement\core\Models\Procurement;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class PPMP extends Model
{
    use NodeTrait;

    protected $table   = 'fms_procurement_ppmp';
    protected $guarded = [];
    protected $casts   = [
        'schedule' => AsCollection::class,
    ];

    public function getQuantityAttribute(): int
    {
        return $this->schedule->sum();
    }

    public function getBudgetAttribute(): float
    {
        if($this->schedule !== null){
            return $this->schedule->sum() * $this->unit_cost;
        }

        return 0;
    }

    public function getTotalBudgetAttribute(): float
    {
        $total = 0.0;

        $traverse = function ($categories) use (&$traverse, &$total) {
            foreach ($categories as $category) {
                $total += $category->budget;
                $traverse($category->children);
            }
        };

        $traverse($this->children);

        return $total;
    }




}
