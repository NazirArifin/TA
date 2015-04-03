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
	$param		= array(
		'info' 		=> $info,
		'bisnis'	=> $bisnis,
		'direktori'	=> $direktori,
		'jual'		=> $jual,
		'beli'		=> $beli,
		'produk'	=> $produk
	);
	if (cek_token($ctr)) {
		$member		= $ctr->MainModel->member_me($_COOKIE['token']);
		foreach ($member['data'] as $key => $val)
			$param[$key] = $val;
		$param['authenticate']	= TRUE;
	}
	$ctr->load('view', 'index.html', $param);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: data
 */
$app->options('/data', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/data', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	$r = $ctr->MainModel->get_data_table();
	if ($r === FALSE) return halt401($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: pesan
 */
$app->options('/pesan', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/pesan', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'front');
	$r = $ctr->FrontModel->save_pesan();
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: daftar 
 */
$app->options('/daftar', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/daftar', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	if (cek_token($ctr)) redirect_home();
	$ctr->load('view', 'pendaftaran.html', array(
		'registering'	=> TRUE
	));
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: daftar 
 */
$app->options('/daftar', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/daftar', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	// include phpmailer
	$ctr->load('file', 'lib/PHPMailer/PHPMailerAutoload.php');
	$r = $ctr->MainModel->member_save(new PHPMailer);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: login 
 */
$app->options('/login', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/login', function() use($app, $ctr) {
	$ctr->load('helper', 'controller');
	$ctr->load('file', 'lib/JWT.php');
	$ctr->load('model', 'main');
	$r = $ctr->MainModel->member_authenticate();
	if ($r['type']) {
		save_token($r['data']['token'], $r['data']['expired']);
		redirect_home();
	} else redirect_index();
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: logout 
 */
$app->options('/logout', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/logout', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	delete_token($ctr);
	redirect_index();
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: checkout
 */
$app->options('/checkout', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/checkout', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: home 
 */
$app->options('/home', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/home', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) redirect_index();
	$r 		= $ctr->MainModel->member_me($_COOKIE['token']);
	$member	= $r['data'];
	$member['authenticate'] = TRUE;
	$member['path'] = '';
	$ctr->load('view', 'home.html', $member);
});
// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: home 
 */
$app->options('/home/:type', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/home/:type', function($type) use($app, $ctr) {
	if ( ! cek_token($ctr)) redirect_index();
	$r 		= $ctr->MainModel->member_me($_COOKIE['token']);
	$member	= $r['data'];
	$member['authenticate'] = TRUE;
	switch ($type) {
		case 'post':
			
			break;
		case 'direktori':
			
			break;
		case 'produk':
			
			break;
		case 'order':
			
			break;
		default: 
			redirect_index();
			break;
	}
	$member['path'] = $type;
	$ctr->load('view', 'home-' . $type . '.html', $member);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: email/:state 
 */
$app->options('/email/:state', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/email/:state', function($state) use($app, $ctr) {
	$ctr->load('model', 'main');
	$r = $ctr->MainModel->validate_email($state);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: berita
 */
$app->options('/berita', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/berita', function() use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('helper', 'string');
	$ctr->load('model', 'front');
	$news = $ctr->FrontModel->news_list('berita');
	if ($news === FALSE) halt404();
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$news['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$news[$key] = $val;
	}
	$ctr->load('view', 'berita-search.html', $news);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: berita/:id/:judul
 */
$app->options('/berita/:id/:judul', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/berita/:id/:judul', function($id, $judul) use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('model', 'front');
	$news = $ctr->FrontModel->news_detail('berita', $id, $judul);
	if ($news === FALSE) halt404();
	$news['other'] = $ctr->FrontModel->news_other('berita', $news['id']);
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$news['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$news[$key] = $val;
	}
	$ctr->load('view', 'berita.html', $news);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: info
 */
$app->options('/info', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/info', function() use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('helper', 'string');
	$ctr->load('model', 'front');
	$news = $ctr->FrontModel->news_list('info');
	if ($news === FALSE) halt404();
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$news['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$news[$key] = $val;
	}
	$ctr->load('view', 'berita-search.html', $news);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: info/:id/:judul
 */
$app->options('/info/:id/:judul', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/info/:id/:judul', function($id, $judul) use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('model', 'front');
	$news = $ctr->FrontModel->news_detail('info', $id, $judul);
	if ($news === FALSE) halt404();
	$news['other'] = $ctr->FrontModel->news_other('info', $news['id']);
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$news['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$news[$key] = $val;
	}
	$ctr->load('view', 'berita.html', $news);
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

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: direktori
 */
$app->options('/direktori', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/direktori', function() use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('model', 'direktori');
	$ctr->load('model', 'main');
	$dirlist = $ctr->DirektoriModel->view();
	$ctr->load('model', 'front');
	$list = $ctr->FrontModel->get_direktori_list();
	$dirlist['direktori'] = $list;
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$dirlist['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$dirlist[$key] = $val;
	}
	// jika advance
	if ($dirlist['param']['type'] == 'advanced') {
		$ctr->load('model', 'main');
		$d = $ctr->MainModel->get_data_table('kota,kategori_direktori');
		$dirlist['kota'] = $d['kota'];
		$dirlist['kategori'] = $d['kategori_direktori'];
	}
	$ctr->load('view', 'direktori-search.html', $dirlist);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: direktori/:id/:nama 
 */
$app->options('/direktori/:id/:nama', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/direktori/:id/:nama', function($id, $nama) use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('model', 'direktori');
	$direktori = $ctr->DirektoriModel->get_detail($id, $nama);
	if ($direktori === FALSE) halt404($app);
	$ctr->load('model', 'produk');
	$produk = $ctr->ProdukModel->get_produk($id);
	$direktori['produk'] = $produk;	
	$ctr->load('model', 'front');
	$list = $ctr->FrontModel->get_direktori_list();
	$direktori['direktori'] = $list;
		
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$direktori['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$direktori[$key] = $val;
	}
	$ctr->load('view', 'direktori.html', $direktori);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: anggota/:kode 
 */
$app->options('/anggota/:kode', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/anggota/:kode', function($kode) use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('helper', 'string');
	$ctr->load('model', 'anggota');
	$anggota = $ctr->AnggotaModel->get_detail($kode);
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token'], $kode);
		$anggota['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$anggota[$key] = $val;
	}
	$ctr->load('view', 'anggota.html', $anggota);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: testimoni 
 */
$app->options('/testimoni', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/testimoni', function() use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('model', 'testimoni');
	$r = $ctr->TestimoniModel->get_testi();
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: testimoni 
 */
$app->post('/testimoni', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('helper', 'date');
	$ctr->load('model', 'testimoni');
	$r = $ctr->TestimoniModel->save_testi();
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: post
 * Verb: testimoni/:id
 */
$app->options('/testimoni/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/testimoni/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'testimoni');
	$r = $ctr->TestimoniModel->save_testi($id);
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: delete
 * Verb: testimoni/:id
 */
$app->delete('/testimoni/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'testimoni');
	$r = $ctr->TestimoniModel->delete_testi($id);
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: post 
 */
$app->options('/post', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/post', function() use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('helper', 'string');
	$ctr->load('model', 'post');
	$r = $ctr->PostModel->get_post();
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: post 
 */
$app->options('/post', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/post', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('helper', 'date');
	$ctr->load('model', 'post');
	$ctr->load('file', 'lib/IOFiles.php');
	$member = $ctr->MainModel->member_me($_COOKIE['token']);
	$r = $ctr->PostModel->save_post($member['data'], new IOFiles());
	if ($r === FALSE) halt404($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: post/:id 
 */
$app->options('/post/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/post/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('helper', 'date');
	$ctr->load('model', 'post');
	$member = $ctr->MainModel->member_me($_COOKIE['token']);
	$r = $ctr->PostModel->get_post_detail($id, $member['data']['member_kode']);
	if ($r === FALSE) halt404($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: post 
 */
$app->post('/post/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('helper', 'date');
	$ctr->load('model', 'post');
	$ctr->load('file', 'lib/IOFiles.php');
	$member = $ctr->MainModel->member_me($_COOKIE['token']);
	$r = $ctr->PostModel->save_post($member['data'], new IOFiles(), $id);
	if ($r === FALSE) halt404($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: post 
 */
$app->delete('/post/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'post');
	$ctr->load('file', 'lib/IOFiles.php');
	$member = $ctr->MainModel->member_me($_COOKIE['token']);
	$r = $ctr->PostModel->delete_post($member['data'], new IOFiles(), $id);
	if ($r === FALSE) halt404($app);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: jual 
 */
$app->options('/jual', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/jual', function() use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('helper', 'date');
	$ctr->load('model', 'post');
	$post = $ctr->PostModel->get_all_post(1);
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$post['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$post[$key] = $val;
	}
	$ctr->load('view', 'kiriman-search.html', $post);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: beli 
 */
$app->options('/beli', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/beli', function() use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('helper', 'date');
	$ctr->load('model', 'post');
	$post = $ctr->PostModel->get_all_post(2);
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$post['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$post[$key] = $val;
	}
	$ctr->load('view', 'kiriman-search.html', $post);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: review 
 */
$app->options('/review', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/review', function() use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('helper', 'string');
	$ctr->load('model', 'review');
	$r = $ctr->ReviewModel->get_review();
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: review
 */
$app->post('/review', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('helper', 'date');
	$ctr->load('model', 'review');
	$r = $ctr->ReviewModel->save_review();
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: review/:id
 */
$app->options('/review/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/review/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'review');
	$r = $ctr->ReviewModel->save_review($id);
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: delete
 * Verb: review/:id
 */
$app->delete('/review/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'review');
	$r = $ctr->ReviewModel->delete_review($id);
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: fproduk 
 */
$app->options('/fproduk', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/fproduk', function() use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('model', 'produk');
	$produk = $ctr->ProdukModel->get_all_post();
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$produk['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$produk[$key] = $val;
	}
	$ctr->load('model', 'main');
	$kategori_produk = $ctr->MainModel->get_data_table('kategori_produk');
	$produk['kategori'] = $kategori_produk['kategori_produk'];
	$ctr->load('view', 'produk-search.html', $produk);
});


// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: produk/:id/:nama 
 */
$app->options('/produk/:id/:nama', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/produk/:id/:nama', function($id, $nama) use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('model', 'produk');
	$produk = $ctr->ProdukModel->get_detail($id, $nama);
	// ambil data produk lain
	$produk['other'] = $ctr->ProdukModel->get_other_produk($produk['direktori_id'], $id);
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$produk['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$produk[$key] = $val;
	}
	$ctr->load('view', 'produk.html', $produk);
});
// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: fproduk/:id/:nama 
 */
$app->options('/fproduk/:id/:nama', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/fproduk/:id/:nama', function($id, $nama) use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('model', 'produk');
	$produk = $ctr->ProdukModel->get_detail($id, $nama, TRUE);
	// ambil data produk lain
	$produk['other'] = $ctr->ProdukModel->get_other_produk(0, $id);
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$produk['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$produk[$key] = $val;
	}
	
	$ctr->load('view', 'produk.html', $produk);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: jual/:id/:nama
 */
$app->options('/jual/:id/:nama', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/jual/:id/:nama', function($id, $nama) use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('model', 'post');
	$post = $ctr->PostModel->get_detail(1, $id, $nama);
	$post['other1'] = $ctr->PostModel->get_other(1, $post['poster_kode'], $post['id']);
	$post['other2'] = $ctr->PostModel->get_other(1, '', $post['id']);
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$post['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$post[$key] = $val;
	}
	$ctr->load('view', 'kiriman.html', $post);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: beli/:id/:nama
 */
$app->options('/beli/:id/:nama', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/beli/:id/:nama', function($id, $nama) use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('model', 'post');
	$post = $ctr->PostModel->get_detail(2, $id, $nama);
	$post['other1'] = $ctr->PostModel->get_other(2, $post['poster_kode'], $post['id']);
	$post['other2'] = $ctr->PostModel->get_other(2, '', $post['id']);
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$post['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$post[$key] = $val;
	}
	$ctr->load('view', 'kiriman.html', $post);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: komentar
 */
$app->options('/komentar', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/komentar', function() use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('model', 'post');
	$r = $ctr->PostModel->get_komentar();
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: komentar
 */
$app->post('/komentar', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'post');
	$r = $ctr->PostModel->save_komentar();
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: komentar/:id
 */
$app->options('/komentar/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->delete('/komentar/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'post');
	$r = $ctr->PostModel->delete_komentar($id);
	if ($r !== FALSE) json_output($app, $r);
});
