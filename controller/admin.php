<?php
// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: authenticate
 */
$app->options('/admin/authenticate', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/admin/authenticate', function() use($app, $ctr) {
	$ctr->load('file', 'lib/JWT.php');
	$ctr->load('model', 'main');
	$r = $ctr->MainModel->admin_authenticate();
	if ($r === FALSE) 
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: signout
 */
$app->options('/admin/signout/:token', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/signout/:token', function($token) use($app, $ctr) {
	$ctr->load('file', 'lib/JWT.php');
	$ctr->load('model', 'main');
	$r = $ctr->MainModel->admin_signout($token);
	if ($r === FALSE) 
		return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: me
 */
$app->options('/admin/me', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/me', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$r = $ctr->MainModel->admin_me($token);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: me
 */
$app->post('/admin/me', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('file', 'lib/IOFiles.php');
	$r = $ctr->MainModel->admin_profil($token, new IOFiles());
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: admin
 */
$app->options('/admin/admin', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/admin', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminmain');
	$r = $ctr->AdminmainModel->show_admin($token);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: admin
 */
$app->post('/admin/admin', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$r = $ctr->MainModel->admin_save($token);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: admin/:id
 */
$app->options('/admin/admin/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/admin/admin/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$r = $ctr->MainModel->admin_save($token, $id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: produk/:Id
 */
$app->delete('/admin/admin/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminmain');
	$r = $ctr->AdminmainModel->delete_admin($id, $token);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: pesan
 */
$app->options('/admin/pesan', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/pesan', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminmain');
	$ctr->load('helper', 'date');
	$r = $ctr->AdminmainModel->show_message($token);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: pesan
 */
$app->post('/admin/pesan', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) {
		if (isset($_COOKIE['token'])) {
			$token = validate_token($ctr, $_COOKIE['token']);
			if ($token === FALSE) halt403($app);
		} else halt403($app);
	}
	$ctr->load('model', 'adminmain');
	$r = $ctr->AdminmainModel->save_message($token);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: pesan
 */
$app->options('/admin/pesan/daftar', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/pesan/daftar', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) {
		if (isset($_COOKIE['token'])) {
			$token = validate_token($ctr, $_COOKIE['token']);
			if ($token === FALSE) halt403($app);
		} else halt403($app);
	}
	$ctr->load('model', 'adminmain');
	$ctr->load('helper', 'date');
	$r = $ctr->AdminmainModel->show_message_list($token);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: pesan
 */
$app->options('/admin/pesan/data', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/pesan/data', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) {
		if (isset($_COOKIE['token'])) {
			$token = validate_token($ctr, $_COOKIE['token']);
			if ($token === FALSE) halt403($app);
		} else halt403($app);
	}
	$ctr->load('model', 'adminmain');
	$ctr->load('helper', 'date');
	$r = $ctr->AdminmainModel->show_message_data($token);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: data
 */
$app->options('/admin/data', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/data', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$r = $ctr->MainModel->get_data_table();
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: data
 */
$app->post('/admin/data', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$r = $ctr->MainModel->set_data_table();
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: data
 */
$app->delete('/admin/data', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$r = $ctr->MainModel->delete_data_table();
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: kota
 */
$app->options('/admin/kota', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/kota', function() use($app, $ctr) {
	$ctr->load('model', 'adminmain');
	$r = $ctr->AdminmainModel->get_data_table('kota');
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: ongkir
 */
$app->options('/admin/ongkir', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/ongkir', function() use($app, $ctr) {
	$ctr->load('model', 'adminmain');
	$r = $ctr->AdminmainModel->get_data_table('ongkir');
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: produk
 */
$app->options('/admin/produk', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/produk', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('helper', 'string');
	$ctr->load('model', 'adminproduk');
	$r = $ctr->AdminprodukModel->show();
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: produk
 */
$app->post('/admin/produk', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('file', 'lib/IOFiles.php');
	$ctr->load('model', 'adminproduk');
	$r = $ctr->AdminprodukModel->add(0, new IOFiles());
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: produk/:Id
 */
$app->options('/admin/produk/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/produk/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'adminproduk');
	$r = $ctr->AdminprodukModel->detail($id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: produk/:Id
 */
$app->post('/admin/produk/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('file', 'lib/IOFiles.php');
	$ctr->load('model', 'adminproduk');
	$r = $ctr->AdminprodukModel->add($id, new IOFiles());
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: produk/:Id
 */
$app->delete('/admin/produk/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminproduk');
	$r = $ctr->AdminprodukModel->delete($id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: direktori
 */
$app->options('/admin/direktori', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/direktori', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'admindirektori');
	$r = $ctr->AdmindirektoriModel->show();
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: direktori
 */
$app->post('/admin/direktori', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('file', 'lib/IOFiles.php');
	$ctr->load('model', 'admindirektori');
	$r = $ctr->AdmindirektoriModel->add(0, new IOFiles());
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: direktori/:Id
 */
$app->options('/admin/direktori/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/direktori/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'admindirektori');
	$r = $ctr->AdmindirektoriModel->detail($id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: direktori/:Id
 */
$app->post('/admin/direktori/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('file', 'lib/IOFiles.php');
	$ctr->load('model', 'admindirektori');
	$r = $ctr->AdmindirektoriModel->add($id, new IOFiles());
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: direktori/:Id
 */
$app->delete('/admin/direktori/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'admindirektori');
	$r = $ctr->AdmindirektoriModel->delete($id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: anggota
 */
$app->options('/admin/anggota', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/anggota', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('helper', 'date');
	$ctr->load('model', 'adminanggota');
	$r = $ctr->AdminanggotaModel->show();
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: anggota/:kode
 */
$app->options('/admin/anggota/:kode', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/anggota/:kode', function($kode) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminanggota');
	$r = $ctr->AdminanggotaModel->detail($kode);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: anggota/:Id
 */
$app->post('/admin/anggota/:kode', function($kode) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminanggota');
	$r = $ctr->AdminanggotaModel->update($kode);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: anggota/:Id
 */
$app->delete('/admin/anggota/:kode', function($kode) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminanggota');
	$r = $ctr->AdminanggotaModel->delete($kode);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: emarket/:type
 */
$app->options('/admin/emarket/:type', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/emarket/:type', function($type) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('helper', 'date');
	$ctr->load('helper', 'string');
	$ctr->load('model', 'adminemarket');
	switch ($type) {
		case 'jual': case 'beli':
			$r = $ctr->AdminemarketModel->show($type); break;
		default: return halt401($app);
	}
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: emarket/:type/:id
 */
$app->options('/admin/emarket/:type/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->delete('/admin/emarket/:type/:id', function($type, $id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminemarket');
	switch ($type) {
		case 'jual': case 'beli':
			$r = $ctr->AdminemarketModel->delete($id); break;
		default: return halt401($app);
	}
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: transaksi/:type
 */
$app->options('/admin/transaksi/:type', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/transaksi/:type', function($type) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('helper', 'date');
	$ctr->load('model', 'admintransaksi');
	$r = array();
	if ($type == 'jual') $r = $ctr->AdmintransaksiModel->show_jual();
	if ($type == 'beli') $r = $ctr->AdmintransaksiModel->show_beli();
	if (empty($r)) return halt401($app);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: transaksi/:type/:id
 */
$app->options('/admin/transaksi/:type/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/admin/transaksi/:type/:id', function($type, $id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'admintransaksi');
	$r = $ctr->AdmintransaksiModel->update($type, $id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: berita/:type
 */
$app->options('/admin/berita/:type', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/berita/:type', function($type) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('helper', 'date');
	$ctr->load('helper', 'string');
	$ctr->load('model', 'adminberita');
	$r = array();
	$r = $ctr->AdminberitaModel->show($type);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: berita/:type
 */
$app->post('/admin/berita/:type', function($type) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('helper', 'date');
	$ctr->load('model', 'adminberita');
	$ctr->load('file', 'lib/IOFiles.php');
	
	$r = $ctr->AdminberitaModel->add($type, 0, $token, new IOFiles());
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

/**
 * Method: GET
 * Verb: transaksi/:type
 */
$app->options('/admin/berita/:type/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/berita/:type/:id', function($type, $id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('helper', 'date');
	$ctr->load('helper', 'string');
	$ctr->load('model', 'adminberita');
	$r = $ctr->AdminberitaModel->detail($type, $id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

/**
 * Method: POST
 * Verb: transaksi/:type
 */
$app->post('/admin/berita/:type/:id', function($type, $id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('helper', 'date');
	$ctr->load('helper', 'string');
	$ctr->load('model', 'adminberita');
	$ctr->load('file', 'IOFiles.php');
	$r = $ctr->AdminberitaModel->add($type, $id, $token, new IOFiles());
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

/**
 * Method: DELETE
 * Verb: transaksi/:type
 */
$app->delete('/admin/berita/:type/:id', function($type, $id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminberita');
	$r = $ctr->AdminberitaModel->delete($type, $id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: report/total
 */
$app->options('/admin/report/total', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/report/total', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminmain');
	$r = $ctr->AdminmainModel->report('total');
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: admin/tips
 */
$app->options('/admin/tips', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/tips', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminberita');
	$r = $ctr->AdminberitaModel->get_tips();
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: admin/tips
 */
$app->post('/admin/tips', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminberita');
	$r = $ctr->AdminberitaModel->save_tips();
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: admin/tips
 */
$app->options('/admin/tips/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/admin/tips/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminberita');
	$r = $ctr->AdminberitaModel->get_tips_detail($id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: admin/tips
 */
$app->post('/admin/tips/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminberita');
	$r = $ctr->AdminberitaModel->save_tips($id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: admin/tips
 */
$app->delete('/admin/tips/:id', function($id) use($app, $ctr) {
	$ctr->load('model', 'main');
	$token = validate_token($ctr);
	if ($token === FALSE) return halt403($app);
	
	$ctr->load('model', 'adminberita');
	$r = $ctr->AdminberitaModel->delete_tips($id);
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});