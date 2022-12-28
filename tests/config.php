<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Viettqt\JetDB\DB;
use Viettqt\JetDB\Config;

DB::addConnection('main', [
    'host' => 'localhost',
    'port' => '3306',

    'database' => 'test_phpunitest',
    'username' => 'root',
    'password' => '1',

    'charset' => Config::UTF8MB4,
    'collation' => Config::UTF8MB4_UNICODE_CI,
    'fetch' => Config::FETCH_CLASS
]);
