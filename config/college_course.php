<?php

return [
    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'degree_structure' => [
        'Institute_of_Technology' => [
            'Diploma in' => 'ICT,CET',
        ],
        'College_of_Computer_and_Information_Sciences' => [
            'Bachelor of Science' => 'IT,CS',
        ]
    ],
    
    'course_map' => [
        'ICT' => 'Information Communication Technology',
        'CET' => 'Computer Engineering Technology',
        'IT' => 'Information Technology',
        'CS' => 'Computer Science',
    ]
];
