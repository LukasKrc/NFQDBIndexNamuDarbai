<?php

try {
	$db2 = new PDO('mysql:host=localhost;dbname=Akademija2;charset=utf8;', 'lukas', 'pass');
} catch (Exception $e) {
	die('Duomenų bazė nepasiekiama '.$e->getMessage());
}

$fileContents = file_get_contents('data.json');
$data = json_decode($fileContents);

$query = "INSERT INTO JobsRegister (". 
			"contractId,".
			"objectId,".
			"kkTechnicianArrivalDate,".
			"kkTechnicianDepartureDate,".
			"kkTechnicianId,".
			"arrivalDate,".
			"materialSum,".
			"numberOfMaterials".
		") VALUES ";

foreach($data as $item) {
	$query .=
			"({$item->contractId},".
			"{$item->objectId},".
			"'{$item->kkTechnicianArrivalDate}',".
			"'{$item->kkTechnicianDepartureDate}',".
			"{$item->kkTechnicianId},".
			"'{$item->arrivalDate}',".
			"{$item->materialSum},".
			"{$item->numberOfMaterials}".
		"),";
};
$query = rtrim($query, ",");

$timeStart = microtime(true);

$db2->query($query);

$timeFinish = microtime(true);
$time = $timeFinish - $timeStart;
echo "Be index atlikta per {$time} sek.\n";
