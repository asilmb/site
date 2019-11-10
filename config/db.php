<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;port=5432;dbname=postgres',
    'username' => 'postgres',
    'password' => '',
    'schemaMap' => [
        'pgsql' => [
            'class' => 'yii\db\pgsql\Schema::class',
            'defaultSchema' => 'site' //specify your schema here
        ]
    ],
    'on afterOpen' => function ($event) {
        $event->sender->createCommand("SET search_path TO my_schema")->execute();
    },
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
