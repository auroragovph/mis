<?php


return [

    'employee' => [

        'governor' => [
            'fname' => 'Gerardo',
            'mname' => 'A',
            'lname' => 'Noveras',
            'suffix' => 'Hon'
        ],

        'vice-governor' => [
            'fname' => 'Christian',
            'mname' => 'M',
            'lname' => 'Noveras',
            'suffix' => 'Atty'
        ]
    ],

    'office' => [
        'HRMO' => 13,
        'PTO' => 4,
    ],

    'document' => [

        'type' => [

            'afl' => 500,
            
            'cafoa' => 400, 

            'disbursement' => 600, 

            'payroll' => 700,

            'procurement' => [
                'request' => 101,
                'order' => 102
            ],

            'travel' => [
                'order' => 301,
                'itinerary' => 302
            ],

        ],

        'action' => [
            'receive' => 1, 
            'release' => 0
        ],

        'status' => [
            'cancelled' => [ 'id' => 0,'color' => 'danger', 'text' => 'cancelled'],
            'activate' => [ 'id' => 1,'color' => 'warning', 'text' => 'waiting for activation'],
            'process' => [ 'id' => 2,'color' => 'primary', 'text' => 'on process'],
            'approved' => [ 'id' => 3,'color' => 'success', 'text' => 'approved'],
            'disapproved' => [ 'id' => 4,'color' => 'danger', 'text' => 'disapproved'],
            'pending' => [ 'id' => 5,'color' => 'info', 'text' => 'pending'],
        ]

    ]

];