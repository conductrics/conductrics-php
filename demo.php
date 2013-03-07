<?php require_once "conductrics.php"; ?>
<?php
	// Give this visitor a php session if they don't already have one.
	session_start();

	// If you are a single user, you can set your identity globally.
	Conductrics::$apiKey = 'api-HFrPvhjnhVufRXtCGOIzejSW';
	Conductrics::$ownerCode = 'owner_HJJnKxAdm';

	// Create a new agent.
	$agent = new ConductricsAgent("php-agent");

	// If you are in a "multi-tenant" scenario (like a WordPress plugin),
	// You can set your identity per Agent instance.
	$agent
		->apiKey('api-HFrPvhjnhVufRXtCGOIzejSW')
		->ownerCode('owner_HJJnKxAdm');

?>

<? if( empty($_GET) ): ?>
	<? // Make a decision about what content to display.
	if( $agent->decide(session_id(), "a","b") == "a" ): ?>
		<div><span>The A content was chosen for session <?= session_id() ?>.</span></div>
	<? else: ?>
		<div><span>The B content was chosen for session <?= session_id() ?>.</span></div>
	<? endif; ?>
	<form action="" method="GET">
		<input type="hidden" name="value" value="1.2" />
		<button>Reward</button>
	</form>
<? else:
	// If the button was clicked, send a reward to the Agent.  ?>
	<?= json_encode($agent->reward(session_id(), "goal-1", $_GET["value"])) ?>
<? endif; ?>

<?php
	// Flip a coin to get a new session.
	if( rand(0,100) < 50 )
		echo "Ending session " . session_regenerate_id(true);
?>

