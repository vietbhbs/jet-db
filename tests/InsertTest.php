<?php
require_once __DIR__ . '/config.php';

use Viettqt\JetQueryBuilder\DB;

$now = date('Y-m-d H:i:s');

DB::table('users')->truncate();
/*
| Insert
*/
$user_params = [
    ['name' => 'BEN', 'phone' => '0999000001', 'fax' => '', 'created_at' => '2018-05-01 00:00:00'],
    ['name' => 'Jo', 'phone' => '0999000002', 'fax' => '', 'created_at' => $now],
    ['name' => 'Sofi', 'phone' => '0999000003', 'fax' => '', 'created_at' => $now],
    ['name' => 'Tom', 'phone' => '0999000004', 'fax' => '', 'created_at' => $now],
    ['name' => 'Nic', 'phone' => '0999000005', 'fax' => '', 'created_at' => $now],
    ['name' => 'Shakira', 'phone' => '0999000006', 'fax' => '', 'created_at' => $now],
];

foreach ($user_params as $user) {
    DB::table('users')->insert($user);
}