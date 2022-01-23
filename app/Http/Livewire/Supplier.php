<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Modules\FileManagement\core\Models\Procurement\Supplier as ProcSupplier;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class Supplier extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('Name')
                ->sortable()
                ->searchable(),
            Column::make('Owner')
                ->sortable()
                ->searchable(),
            Column::make('Address')
                ->sortable(),
        ];
    }

    public function query(): Builder
    {
        return ProcSupplier::query();
    }
}
