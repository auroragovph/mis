<?php

// use Illuminate\Auth\Access\Gate

return [
    'name' => 'FileManagement',

    'menu' => [

        [
            'name' => 'Document',
            'route' => 'fms.documents.index',
            'permissions' => ['fms.document.*', 'fms.document.create', 'fms.document.edit'],
            // 'permissions' => null,
            'sub' => []
        ],

        [
            'name' => 'Track',
            'route' => 'fms.documents.track',
            'permissions' => [], 
            'sub' => [],
            // 'icon' => 'fas fa-search'
        ],

        [
            'name' => 'Special Actions',
            'route' => '#',
            'permissions' => [],
            'sub' => [

                [
                    'name' => 'Activation',
                    'route' => 'fms.documents.activation.index',
                    'permissions' => ['fms.sa.activate']
                ],

                [
                    'name' => 'Cancellation',
                    'route' => 'fms.documents.cancel.index',
                    'permissions' => ['fms.document.cancel']
                ],

                [
                    'name' => 'Numbering',
                    'route' => 'fms.documents.number.index',
                    'permissions' => ['fms.sa.number']
                ],

                [
                    'name' => 'Receive / Release',
                    'route' => 'fms.documents.rr.index',
                    'permissions' => ['fms.sa.rr']
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
