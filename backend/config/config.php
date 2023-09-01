<?php

return [
  'db' => [
    'driver'   => 'pdo_mysql',
    'host' => 'localhost',
    'username' => 'root',
    'password' => 'felicidad',
    'dbname' => 'superwallet'
  ],
  'entity_paths' => [
    __DIR__ . '/../backend/src/Entity',
  ],
];