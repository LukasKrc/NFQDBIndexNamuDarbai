<?php

try {
	$db1 = new PDO('mysql:host=localhost;dbname=Akademija1;charset=utf8;', 'lukas', 'pass');
} catch (Exception $e) {
	die('Duomenų bazė nepasiekiama '.$e->getMessage());
}

$query = <<<eof
    LOAD DATA INFILE '/home/lukas/akademija/DBInex/data.csv'
		INTO TABLE JobsRegister
		FIELDS TERMINATED BY ','
		LINES TERMINATED BY '\n'
		(
				contractId,
				objectId,
				kkTechnicianArrivalDate,
				kkTechnicianDepartureDate,
				kkTechnicianId,
				arrivalDate,
				materialSum,
				numberOfMaterials
		)
eof;


$timeStart = microtime(true);

$db1->query($query);

$timeFinish = microtime(true);
$time = $timeFinish - $timeStart;
echo "Su index atlikta per {$time} sek.\n";
