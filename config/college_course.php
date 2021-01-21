<?php

return [
    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'degree_structure' => [
        'College_of_Business_Administration' => [
            'Bachelor of Science in' => 'ENTREP,OA',
            'Bachelor of Science in Business Administration Major in' => 'HRM,MM',
        ],
        'Institute_of_Technology' => [
            'Diploma in' => 'ICT,CET',
        ],
        'College_of_Computer_and_Information_Sciences' => [
            'Bachelor of Science in' => 'IT,CS',
        ],  
    ],
    
    'course_map' => [
        'ICT' => 'Information Communication Technology',
        'CET' => 'Computer Engineering Technology',
        'IT' => 'Information Technology',
        'CS' => 'Computer Science',
        'HRM' => 'Human Resource Management',
        'MM' => 'Marketing Management',
        'ENTREP' => 'Entrepreneurship',
        'OA' => 'Office Administration',
    ]
];
