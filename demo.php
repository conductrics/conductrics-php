<?php require_once "conductrics.php"; ?>
<?php
	Conductrics::$apiKey = 'api-HFrPvhjnhVufRXtCGOIzejSW';
	Conductrics::$ownerCode = 'owner_HJJnKxAdm';

	$agent = new ConductricsAgent("php-agent");

	$session = "12345";

	echo $agent->decide($session,"a","b");

	echo json_encode($agent->reward($session));

?>

