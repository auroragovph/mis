<?php

return [
    [
        'name'       => 'Provincial Government of Aurora',
        'alias'      => 'PGA',
        'is_visible' => true,

        'children'   => [

            [
                'name'     => 'Office of the Provincial Governor',
                'alias'    => 'PGO',
                'children' => [
                    [
                        'name'  => 'Office of the Provincial Internal Audit Services Officer',
                        'alias' => 'IAS',
                    ],
                    [
                        'name'  => 'Provincial Population Office',
                        'alias' => 'PPO',
                    ],
                    [
                        'name'  => 'APGEA',
                        'alias' => 'APGEA',
                    ],
                ],
            ],

            [
                'name'  => 'Office of the Provincial General Service Officer',
                'alias' => 'PGSO',
            ],

            [
                'name'  => 'Office of the Provincial Treasurer',
                'alias' => 'PTO',
            ],

            [
                'name'  => 'Office of the Provincial Budget Officer',
                'alias' => 'BUDGET',
            ],

            [
                'name'  => 'Bids and Awards Committee',
                'alias' => 'BAC',
            ],

            [
                'name'  => 'Office of the Provincial Accountant',
                'alias' => 'ACCOUNTING',
            ],

            [
                'name'  => 'Office of the Provincial Administrator',
                'alias' => 'PADMIN',
            ],

            [
                'name'  => 'Office of the Provincial Social Welfare and Development Officer',
                'alias' => 'PSWDO',
            ],

            [
                'name'  => 'Office of the Provincial Legal Officer',
                'alias' => '',
            ],

            [
                'name'  => 'Office of the Vice Governor',
                'alias' => 'VGO',
            ],

            [
                'name'     => 'Sanguniang Panlalawigan',
                'alias'    => 'SP',
                'children' => [
                    [
                        'name'  => 'Secretariat',
                        'alias' => '',
                    ],
                    [
                        'name'  => 'Mariano Calderon Tangson',
                        'alias' => '',
                    ],
                    [
                        'name'  => 'Isidro Pimentel Galban',
                        'alias' => '',
                    ],
                    [
                        'name'  => 'Jesus Valencia Palmero',
                        'alias' => '',
                    ],
                    [
                        'name'  => 'Phillip Butch Molina Bautista',
                        'alias' => '',
                    ],
                    [
                        'name'  => 'Jennifer Aliangan Arana',
                        'alias' => '',
                    ],
                    [
                        'name'  => 'Eugene Bernas Calugtong',
                        'alias' => '',
                    ],
                    [
                        'name'  => 'Lordan Brigansia Roxas',
                        'alias' => '',
                    ],
                    [
                        'name'  => 'Nicasio Marcelo Salamera',
                        'alias' => '',
                    ],
                ],
            ],

            [
                'name' => 'Office of the Provincial Human Resource Management Officer',
                'alias' => 'HRMO',
            ],

            [
                'name' => 'Office of the Provincial Agriculturist',
                'alias' => 'OPAG',
            ],

            [
                'name' => 'Office of the Provincial Assessor',
                'alias' => 'ASSESSOR',
            ],

            [
                'name' => 'Office of the Provincial Cooperative Officer',
                'alias' => 'PCO',
            ],

            [
                'name' => 'Office of the Provincial Engineer',
                'alias' => 'PEO',
            ],

            [
                'name' => 'Office of the Provincial Environment and Natural Resources',
                'alias' => 'ENRO',
            ],

            [
                'name' => 'Office of the Provincial Equipment Pool Officer',
                'alias' => 'PEPO',
            ],

            [
                'name' => 'Office of the Provincial Planning and Development Coordinator',
                'alias' => '',
            ],

            [
                'name' => 'Office of the Provincial Tourism Officer',
                'alias' => '',
            ],

            [
                'name' => 'Office of the Provincial Veterinarian',
                'alias' => '',
            ],

            [
                'name' => 'Office of the Provincial Employment, Sports & Culture & Arts for Youth Development Officer',
                'alias' => 'PESCAYDO',
            ],

            [
                'name' => 'Office of the Provincial Health Officer',
                'alias' => 'PHO',
            ],

            [
                'name' => 'Office of the Provincial Nutrition Action',
                'alias' => '',
            ],

            [
                'name' => 'Office of the Provincial Disaster Risk Reduction Management Officer',
                'alias' => 'PDRRMO',
            ]

        ],
    ],
    [
        'name'       => 'National Government',
        'alias'      => 'NG',
        'is_visible' => false,
        'children'   => [
            [
                'name'  => 'Development Bank of the Philippines - Forest Project',
                'alias' => 'DBP - Forest',
            ],
            [
                'name'  => 'Department of Education',
                'alias' => 'DEPED',
            ],
            [
                'name'  => 'Commision on Audit',
                'alias' => 'COA',
            ],
            [
                'name'  => 'Department of the Interior and Local Government',
                'alias' => 'DILG',
            ],
            [
                'name'  => 'Bureau of Fire Protection',
                'alias' => 'BFP',
            ],
            [
                'name'  => 'Arm Forces of the Philippines',
                'alias' => 'AFP',
            ],
            [
                'name'  => 'Philippine Drug Enforcement Agency',
                'alias' => 'PDEA',
            ],
        ],
    ],
    [
        'name'       => 'Local Government Unit',
        'alias'      => 'LGU',
        'is_visible' => false,

        'children'   => [
            [
                'name'  => 'Municipality of Baler',
                'alias' => '',
            ],

            [
                'name'  => 'Municipality of Casiguran',
                'alias' => '',
            ],
            [
                'name'  => 'Municipality of Dilasag',
                'alias' => '',
            ],
            [
                'name'  => 'Municipality of Dinalungan',
                'alias' => '',
            ],
            [
                'name'  => 'Municipality of Dingalan',
                'alias' => '',
            ],
            [
                'name'  => 'Municipality of Dipaculao',
                'alias' => '',
            ],
            [
                'name'  => 'Municipality of Maria Aurora',
                'alias' => '',
            ],
            [
                'name'  => 'Municipality of San Luis',
                'alias' => '',
            ],
        ],

    ],
];
