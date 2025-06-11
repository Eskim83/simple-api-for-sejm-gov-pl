<?php

include_once "Sejm\Client.php";

$client = new Sejm\Client();

// przykładowe informacje o pośle
$result = $client->request('MP/1');

print_r($result);

?>