<?php
// Direct seeder execution via route
$url = 'http://localhost:8000/run-seeder';
$response = file_get_contents($url);
echo $response;
