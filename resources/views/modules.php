<?php

return [
    [
        'name'        => 'File Management',
        'description' => 'All Office',
        'image'       => asset('assets/illustrations/undraw_folder_files_nweq.svg'),
        'url'         => route('fms.dashboard'),
    ],

    [
        'name'        => 'Bids and Awards Committee (BAC)',
        'description' => 'For BAC Office',
        'image'       => asset('assets/illustrations/undraw_winners_ao2o.svg'),
        'url'         => route('bac.dashboard'),
    ],

    [
      'name'        => 'System',
      'description' => 'For MIS Development',
      'image'       => asset('assets/illustrations/undraw_server_cluster_jwwq.svg'),
      'url'         => route('sys.admin.dashboard'),
  ],
];
