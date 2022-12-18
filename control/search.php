<?php

require_once __DIR__ . '/../index.php';

$url = 'https://www.fruityvice.com/api/fruit/all';
$json_data = file_get_contents($url);
$data = json_decode($json_data);

$search = $_POST['search'];

$data_new = 0;

foreach ($data as $result) {
    if (str_contains($result->name, $search) !== false) {
        $data_new += 1;
    }
}

echo $data_new;
die();
