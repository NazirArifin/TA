<?php
// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: 
 */
$app->options('/', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/', function() use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('helper', 'date');
	$ctr->load('model', 'front');
	
	$info 		= $ctr->FrontModel->get_berita('info');
	$bisnis 	= $ctr->FrontModel->get_berita('bisnis');
	$direktori 	= $ctr->FrontModel->get_direktori_list();
	$jual 		= $ctr->FrontModel->get_post('jual');
	$beli 		= $ctr->FrontModel->get_post('beli');
	$produk		= $ctr->FrontModel->get_produk();
	
	$ctr->load('view', 'index.html', array(
		'info' 		=> $info,
		'bisnis'	=> $bisnis,
		'direktori'	=> $direktori,
		'jual'		=> $jual,
		'beli'		=> $beli,
		'produk'	=> $produk
	));
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: direktori/:alpha 
 */
$app->options('/direktori/:alpha', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/direktori/:alpha', function($alpha) use($app, $ctr) {
	$ctr->load('model', 'direktori');
	
	if (preg_match('/[A-Z]/', $alpha)) $r = $ctr->DirektoriModel->get_list($alpha);
	
	json_output($app, $r);
}); 
