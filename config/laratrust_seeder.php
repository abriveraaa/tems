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
            'borrower' => 'c,v,u,d',
            'barcode' => 'v,p',
            'report' => 'v,p',
            'college' => 'c,v,u,d',
            'course' => 'c,v,u,d',
            'manage' => 'ds,re',
            'users' => 'c,v,u,d',
            'room' => 'c,v,u,d',
            'transaction' => 'v,p',
            'toolcategory' => 'c,v,u,d',
            'toolname' => 'c,v,u,d',
            'tools' => 'c,v,u,d,p',
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
