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
            'college' => 'c,v,u,d',
            'course' => 'c,v,u,d',
            'users' => 'c,v,u,d',
            'room' => 'c,v,u,d',
            'toolcategory' => 'c,v,u,d',
            'toolname' => 'c,v,u,d',
            'tools' => 'c,v,u,d,p',
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
