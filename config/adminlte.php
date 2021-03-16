<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'TEMS',
    'title_prefix' => '',
    'title_postfix' => ' | TEMS',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => true,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => '<b>ITECH</b> Laboratory',
    'logo_img' => 'img/pup_logo.png',
    'logo_img_class' => 'brand-image-xs mr-2 ml-3 pr-1',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'ITECH Laboratory',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-danger',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#661-authentication-views-classes
    |
    */

    'classes_auth_card' => '',
    'classes_auth_header' => '',
    'classes_auth_body' => 'login-card-body',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-outline-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#662-admin-panel-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => 'navbar-light',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-danger elevation-1',
    'classes_sidebar_nav' => 'nav-child-indent',
    'classes_topnav' => 'navbar navbar-light shadow-sm',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => true,

    'dashboard_url' => 'dashboard',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => false,
    
    'socialite_url' => false,

    'password_reset_url' => 'password.request',

    'password_email_url' => 'password.email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        [
            'text'        => 'Dashboard',
            'url'         => 'dashboard',
            'permission'  => 'manage-dashboard',
            'icon'        => 'fas fa-fw fa-chart-line',
        ],
        [
            'text'        => 'Request',
            'url'         => 'request',
            'permission'  => 'manage-request',
            'icon'        => 'fas fa-fw fa-hand-holding',
        ],
        [
            'header' => 'SYSTEM MANAGEMENT',
            'permission' => ['users-create', 'users-view', 'users-update', 'users-delete', 'borrower-create', 'borrower-view', 'borrower-update', 'borrower-delete','toolname-create', 'toolname-view', 'toolname-delete', 'toolname-update', 'toolcategory-create', 'toolcategory-view', 'toolcategory-delete', 'toolcategory-update', 'tools-create', 'tools-view', 'tools-update', 'tools-delete', 'college-create', 'college-view', 'college-update', 'college-delete', 'course-create', 'course-view', 'course-update', 'course-delete', 'room-create', 'room-view', 'room-update', 'room-delete'],
        ],
        [
            'text' => 'User Management',
            'icon' => 'fas fa-fw fa-user-cog',
            'permission' => ['users-create', 'users-view', 'users-update', 'users-delete', 'borrower-create', 'borrower-view', 'borrower-update'],  
            'submenu' => [
                [
                    'text' => 'Administrator',
                    'icon' => 'fas fa-fw fa-user',
                    'permission' => ['users-create', 'users-view', 'users-update', 'users-delete'],
                    'submenu' => [
                        [
                            'text' => 'Manage Administrator',
                            'url'  => '/admin',
                            'permission' => ['users-create', 'users-view', 'users-update', 'users-delete'],
                            'icon' => 'fas fa-fw fa-tools'
                        ],
                        [
                            'text' => 'Roles and Permissions',
                            'url'  => 'roles-permission',
                            'active' => ['roles-permission', 'roles-permission*', 'regex:@^roles-permission/[0-9]+$@'],
                            'permission' => ['users-create', 'users-view', 'users-update', 'users-delete'],
                            'icon' => 'fas fa-fw fa-tools'
                        ],
                    ],
                ],
                [
                    'text' => 'Borrower',
                    'url'  => '/borrower',
                    'permission' => ['borrower-create', 'borrower-view', 'borrower-update', 'borrower-delete'],
                    'icon' => 'fas fa-fw fa-user'
                ],
            ],
        ],
        [
            'text' => 'Tools Management',
            'icon' => 'fas fa-fw fa-cogs',
            'permission' => ['toolname-create', 'toolname-view', 'toolname-delete', 'toolname-update', 'toolcategory-create', 'toolcategory-view', 'toolcategory-delete', 'toolcategory-update', 'tools-create', 'tools-view', 'tools-update', 'tools-delete'],  
            'submenu' => [
                [
                    'text' => 'All Tools and Equipment',
                    'url'  => '/tool',
                    'permission' => ['tools-create', 'tools-view', 'tools-update', 'tools-delete'],
                    'icon' => 'fas fa-fw fa-tools'
                ],
                [
                    'text' => 'Add Tools Categories',
                    'url'  => '/toolcategory',
                    'permission' => ['toolcategory-create', 'toolcategory-view', 'toolcategory-delete', 'toolcategory-update'],
                ],
                [
                    'text' => 'Add Tools Name',
                    'url'  => '/toolname',
                    'permission' => ['toolname-create', 'toolname-view', 'toolname-delete', 'toolname-update'],
                ],
            ],
        ],
        [
            'text' => 'Data Categories',
            'icon' => 'fas fa-fw fa-user-alt',
            'permission' => ['college-create', 'college-view', 'college-update', 'college-delete', 'course-create', 'course-view', 'course-update', 'course-delete', 'room-create', 'room-view', 'room-update', 'room-delete'], 
            'submenu' => [
                [
                    'text' => 'College',
                    'url'  => '/college',
                    'icon' => 'fas fa-fw fa-university',
                    'permission' => ['college-create', 'college-view', 'college-update', 'college-delete'],
                ],
                [
                    'text' => 'Course',
                    'url'  => '/course',
                    'icon' => 'fas fa-fw fa-graduation-cap',
                    'permission' => ['course-create', 'course-view', 'course-update', 'course-delete'],
                ],
                [
                    'text' => 'Room',
                    'icon' => 'fas fa-fw fa-door-closed',
                    'url'  => '/room',
                    'permission' => ['room-create', 'room-view', 'room-update', 'room-delete'],
                ],
                [
                    'text' => 'Source',
                    'icon' => 'fas fa-fw fa-door-closed',
                    'url'  => '/source',
                    'permission' => ['source-create', 'source-view', 'source-update', 'source-delete'],
                ],
            ], 
        ], 
        [
            'header' => 'REPORTS',
            'permission' => ['barcode-view', 'barcode-print', 'report-view', 'report-print', 'transaction-view', 'transaction-print'],
        ],  
        [
            'text'    => 'Barcodes',
            'icon'    => 'fas fa-fw fa-barcode',
            'url'     => '/barcodes',
            'permission' => ['barcode-view','barcode-print'],  
        ],  
        [
            'text'    => 'All Reports',
            'icon'    => 'fas fa-fw fa-file',
            'url'     => '/report',
            'permission' => ['report-view', 'report-print'],  
        ],
        [
            'text'    => 'Transactions',
            'icon'    => 'fas fa-fw fa-history',
            'url'     => '/transaction',
            'permission' => ['transaction-view', 'transaction-print'],  
        ],  
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
        App\MyConfiguration\Permission::class,
        // App\MyConfiguration\Role::class,
        // JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true, 
                    'location' => 'https://code.jquery.com/jquery-3.5.1.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true, 
                    'location' => 'vendor/DataTables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true, 
                    'location' => 'vendor/DataTables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/DataTables/DataTables-1.10.20/css/bootstrap.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/DataTables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css',
                ],
                
                
                
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/chartjs/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@10',
                ],
            ],
        ],
        'Toastr' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'Materialize' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js',
                ],
            ]
        ]
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Developer's Information
    |--------------------------------------------------------------------------
    |
    | Here we can modify the developer's information that will display in the admin panel.
    |
    */
    
    'name' => 'Team Drawing',
    'facebook' => 'img/facebook.png',
    'twitter' => null,
    'gmail' => null,
    'linkedin' => null,
    'github' => null,
];
