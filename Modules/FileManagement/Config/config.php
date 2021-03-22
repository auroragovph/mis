<?php

return [
    'name' => 'FileManagement',

  
    'menu' => [

        ['header' => 'File Management'],


        [
            'name' => 'Document',
            'icon' => 'fas fa-file-alt',
            'route' => 'fms.documents.index',
            'permissions' => ['fms.document.*', 'fms.document.create', 'fms.document.edit'],
            // 'permissions' => null,
            'sub' => []
        ],

        [
            'name' => 'Track',
            'icon'  => 'fas fa-search',
            'route' => 'fms.documents.track',
            'permissions' => [], 
            'sub' => [],
            // 'icon' => 'fas fa-search'
        ],

        [
            'name' => 'Special Actions',
            'icon' => 'fas fa-gavel',
            'route' => '#',
            'permissions' => [],
            'sub' => [

                [
                    'name' => 'Activation',
                    'route' => 'fms.documents.activation.index',
                    'permissions' => ['fms.sa.activate'],
                    'icon' => 'fas fa-stamp'
                ],

                [
                    'name' => 'Cancellation',
                    'route' => 'fms.documents.cancel.index',
                    'permissions' => ['fms.document.cancel'],
                    'icon' => 'fas fa-ban'
                ],

                [
                    'name' => 'Numbering',
                    'route' => 'fms.documents.number.index',
                    'permissions' => ['fms.sa.number'],
                    'icon' => 'fas fa-sort-numeric-down'
                ],

                [
                    'name' => 'Receive / Release',
                    'route' => 'fms.documents.rr.index',
                    'permissions' => ['fms.sa.rr'],
                    'icon' => 'fas fa-exchange-alt fa-rotate-90'
                ],

            ]
        ],

        [
            'name' => 'Office Actions',
            'route' => '#',
            'permissions' => [],
            'sub' => [

                [
                    'name'          => 'Inspection and Acceptance Report (IAR)',
                    'route'         => 'fms.procurement.iar.index',
                    'permissions'   => ['fms.oa.procurement.inspection'],
                ],

                [
                    'name'          => 'PR Consolidation',
                    'route'         => 'fms.procurement.consolidate.index',
                    'permissions'   => ['fms.oa.procurement.pr.consolidation'],
                ],

                [
                    'name'          => 'Requisition and Issue Slip (RIS)',
                    'route'         => 'fms.procurement.consolidate.index',
                    'permissions'   => ['fms.oa.procurement.inspection'],
                ],

            ]
        ],
    
    ]
];
