<?php
return [
    'generator' => [
        'rootNamespace' => 'App\\',
        'modelNamespace' => 'App\\',
        'basePath' => app_path()
    ],
    'pagination' => [
        'perPage' => 25
    ],
    'criteria' => [
        'params' => [
            'filter' => 'filter',
            'orderBy' => 'order',
            'sortBy' => 'sort',
        ],
        'acceptedCondition' => ['=', 'like']
    ]
];
