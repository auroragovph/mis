<?php

return [

    'title'         => 'Aurora Management Information System',
    'abbrv'         => 'AURORA MIS',

    'lgu'           => [
        'name'    => 'Provincial Government of Aurora',
        'address' => 'Brgy. Suclayin, Baler, Aurora',
        'slogan'  => 'Aurora, Gobyernong kumakalinga',
    ],

    'circular_year' => 2020,

    'employee'      => [

        'head'      => [
            'name'     => [
                'first'  => 'Gerardo',
                'middle' => 'A',
                'last'   => 'Noveras',
                'suffix' => 'Hon',
            ],

            'position' => 'Governor',
        ],

        'vice-head' => [
            'name'     => [
                'first'  => 'Christian',
                'middle' => 'M',
                'last'   => 'Noveras',
                'suffix' => 'Atty.',
            ],

            'position' => 'Vice Governor',
        ],
    ],

    'office'        => [
        'HUMAN_RESOURCE'  => 13,
        'TREASURY'        => 4,
        'BUDGET'          => 5,
        'ACCOUNTING'      => 7,
        'GENERAL_SERVICE' => 1,
        'AWARD_COMMITTEE' => 1,
    ],

    'document'      => [

        'type'   => [
            'afl'          => 500,
            'cafoa'        => 400,
            'disbursement' => 600,
            'payroll'      => 700,
            'procurement'  => [
                'procurement' => 100,
                'request'     => 101,
                'order'       => 102,
                'cafoa'       => 104,
            ],
            'travel'       => [
                'order'     => 301,
                'itinerary' => 302,
            ],
            'others'       => [
                'liquidation'   => 901,
                'ob-slip'       => 902,
                'pow'           => 903,
                'mission-order' => 904,
            ],

        ],

        'action' => [
            'receive' => 1,
            'release' => 0,
        ],

        'status' => [
            'cancelled'   => ['id' => 0, 'color' => 'danger', 'text' => 'cancelled'],
            'activate'    => ['id' => 1, 'color' => 'warning', 'text' => 'waiting for activation'],
            'process'     => ['id' => 2, 'color' => 'primary', 'text' => 'on process'],
            'approved'    => ['id' => 3, 'color' => 'success', 'text' => 'approved'],
            'disapproved' => ['id' => 4, 'color' => 'danger', 'text' => 'disapproved'],
            'pending'     => ['id' => 5, 'color' => 'info', 'text' => 'pending'],
        ],

    ],

];
