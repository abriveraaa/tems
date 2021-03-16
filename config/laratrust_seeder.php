<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'administrator' => [
            'borrower' => 'v,c,u,d',
            'college' => 'v,c,u,d',
            'course' => 'v,c,u,d',
            'users' => 'v,c,u,d',
            'room' => 'v,c,u,d',
            'toolcategory' => 'v,c,u,d',
            'toolname' => 'v,c,u,d',
            'source' => 'v,c,u,d',
            'tools' => 'v,c,u,d,p',
            'barcode' => 'v,p',
            'report' => 'v,p',
            'transaction' => 'v,p',
            'manage' => 'ds,re',
        ],
        'assistant' => [
            'manage' => 'ds,re',
        ]
    ],
    
    'permissions_map' => [
        'ds' => 'dashboard',
        're' => 'request',
        'c'  => 'create',
        'v'  => 'view',
        'u'  => 'update',
        'd'  => 'delete',
        'p'  => 'print',
    ]
];
