<?php

return [
  'db' => [
    'driver'   => 'pdo_mysql',
    'host' => 'localhost',
    'user' => 'root',
    'password' => 'felicidad',
    'dbname' => 'superwallet'
  ],
  'entity_paths' => [
    __DIR__ . '/../src/Entity',
  ],
  'dev_mode' => TRUE,
];