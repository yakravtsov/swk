<?php
return [
    'login' => [
        'type' => 2,
    ],
    'logout' => [
        'type' => 2,
    ],
    'error' => [
        'type' => 2,
    ],
    'sign-up' => [
        'type' => 2,
    ],
    'index' => [
        'type' => 2,
    ],
    'view' => [
        'type' => 2,
    ],
    'update' => [
        'type' => 2,
    ],
    'delete' => [
        'type' => 2,
    ],
    'structure' => [
        'type' => 2,
    ],
    'ownStructure' => [
        'type' => 2,
        'ruleName' => 'userStructureAccess',
    ],
    'university' => [
        'type' => 2,
    ],
    'users' => [
        'type' => 2,
    ],
    'ownUser' => [
        'type' => 2,
        'ruleName' => 'ownUser',
    ],
    'downloadImportResult' => [
        'type' => 2,
    ],
    'crudUsers' => [
        'type' => 2,
    ],
    'switchIdentity' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'login',
            'logout',
            'error',
            'sign-up',
            'index',
            'view',
        ],
    ],
    'student' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'update',
            'guest',
            'ownUser',
        ],
    ],
    'teacher' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'student',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'delete',
            'ownStructure',
            'users',
            'downloadImportResult',
            'crudUsers',
            'teacher',
            'student',
            'switchIdentity',
        ],
    ],
    'god' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'structure',
            'university',
            'users',
            'switchIdentity',
            'downloadImportResult',
            'admin',
            'teacher',
            'student',
        ],
    ],
];
