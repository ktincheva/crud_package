<?php

return [

    'url' => env('GITHUB_API_URL'),
    'user-agent' => $_SERVER['HTTP_USER_AGENT'],
    'users' => [
        'model' => '\App\User', //path to the model
        'class' => 'user', //name of the model 
        'rowsPerPage' => 10,
        'title' => "Manage Users",
        'route' => '/users',
        'columns' => [
            [
                'name' => 'name',
                'label' => "Name Lastname"
            ],
            [
                'name' => 'email',
                'label' => "Email"
            ],
        ],
        'create_form' => [
            'fields' => [
                [
                    'name' => 'name',
                    'label' => 'Name Lastname',
                    'type' => 'text'
                ],
                [
                    'name' => 'email',
                    'label' => 'Email',
                    'type' => 'email'
                ],
            ],
            'rules' =>
            ['name' => 'required|min:5', 'email' => 'required|email|unique:users'],
        ],
        'create_form' => [
            'fields' => [
                [
                    'name' => 'name',
                    'label' => 'Name Lastname',
                    'type' => 'text'
                ],
                [
                    'name' => 'email',
                    'label' => 'Email',
                    'type' => 'email'
                ],
            ],
            'rules' =>
            ['name' => 'required|min:5', 'email' => 'required|email|unique:users'],
        ],
        'update_form' => [
            'fields' => [
                [
                    'name' => 'name',
                    'label' => 'Name Lastname',
                    'type' => 'text'
                ],
                [
                    'name' => 'email',
                    'label' => 'Email',
                    'type' => 'email'
                ],
            ],
            'rules' =>
            ['name' => 'required|min:5', 'email' => 'required|email|unique:users'],
        ],
    ],
];
