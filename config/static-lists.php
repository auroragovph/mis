<?php 

return [

    'statusOfAppointment' => [
        'Job Order',
        'Casual',
        'Permanent'
    ],

    'civilStatus' => ['Single', 'Married', 'Widowed', 'Annulled', 'Separated'],


    'documentStatusFTS' => [
        0 => 'Cancelled',
        2 => 'On Process',
        3 => 'Approved',
        4 => 'Disapproved',
        5 => 'Pending',
        6 => 'Return',
        7 => 'For Withdrawal',
        8 => 'Paid',
    ],


    'documentStatus' => [
        0 => 'Cancelled',
        1 => 'Waiting for Activation',
        2 => 'On Process',
        3 => 'Approved',
        4 => 'Disapproved',
        5 => 'Pending',
        6 => 'Return',
        7 => 'For Withdrawal',
        8 => 'Paid',
    ],


    'status' => [
        ['name' => 'Cancelled',                 'color' => 'danger'],
        ['name' => 'Waiting for Activation',    'color' => 'warning'],
        ['name' => 'On Process',                'color' => 'primary'],
        ['name' => 'Approved',                  'color' => 'success'],
        ['name' => 'Disapproved',               'color' => 'danger'],
        ['name' => 'Pending',                   'color' => 'warning'],
        ['name' => 'Return',                    'color' => 'danger'],
        ['name' => 'For Withdrawal',            'color' => 'success'],
        ['name' => 'Paid',                      'color' => 'primary'],
    ]

];