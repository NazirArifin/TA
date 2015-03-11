<?php

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: blank
 */
$app->options('/', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/', function() use ($app) { 
	echo crypt('password', 'mdbz0955201579');
	
	
	//echo "<h1>REST WEB SERVICE</h1>";
});

