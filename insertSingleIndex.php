<?php

try {
	$db1 = new PDO('mysql:host=localhost;dbname=Akademija1;charset=utf8;', 'lukas', 'pass');
} catch (Exception $e) {
	die('Duomenų bazė nepasiekiama '.$e->getMessage());
}

$fileContents = file_get_contents('data.json');
$data = json_decode($fileContents);
$timeStart = microtime(true);

foreach($data as $item) {
	$db1->query(
		"INSERT INTO JobsRegister (". 
			"contractId,".
			"objectId,".
			"kkTechnicianArrivalDate,".
			"kkTechnicianDepartureDate,".
			"kkTechnicianId,".
			"arrivalDate,".
			"materialSum,".
			"numberOfMaterials".
		")".
		"VALUES (".
			"{$item->contractId},".
			"{$item->objectId},".
			"'{$item->kkTechnicianArrivalDate}',".
			"'{$item->kkTechnicianDepartureDate}',".
			"{$item->kkTechnicianId},".
			"'{$item->arrivalDate}',".
			"{$item->materialSum},".
			"{$item->numberOfMaterials}".
		")"
	);
};

$timeFinish = microtime(true);
$time = $timeFinish - $timeStart;
echo "Su index atlikta per {$time} sek.\n";
