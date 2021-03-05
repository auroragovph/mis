<?php

return [
    'modules' => [

        [
            'office'    => 'Bids and Awards Committe',
            'icon'      =>  'fas fa-award',
            'abbr'      =>  'bac',
            'funcs'     => [
                ['name'  => 'PR Consolidation', 'route' => 'fms.procurement.consolidate.index', 'subs'  =>  null]
            ]
        ],

        [
            'office'    => 'Budget',
            'icon'      =>  'fas fa-coins',
            'abbr'      =>  'budget',
            'funcs'     =>  [
                ['name'  => 'Source of Funds', 'route' => 'budget.source-of-funds.index', 'subs'  =>  null]
            ]
        ],


        [
            'office'    => 'General Service',
            'icon'      =>  'fas fa-tools',
            'abbr'      =>  'gso',
            'funcs'     => []
        ],

        [
            'office'    => 'Human Resource',
            'icon'      =>  'fas fa-users',
            'abbr'      =>  'hrmo',
            'funcs'     =>  [
                ['name'  => 'Employee Management', 'route' =>  'hrm.employee.index', 'subs'  =>  null]
            ]
        ],







    ]
];
