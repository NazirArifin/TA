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
	$tips		= $ctr->FrontModel->get_tips();
	$pdirektori	= $ctr->FrontModel->get_premium_direktori();
	$pproduk	= $ctr->FrontModel->get_direktori_produk();
	$katdir		= $ctr->FrontModel->get_direktori_category();
	
	// pesan error gagal login
	$message 	= '';
	if (isset($_GET['pesan'])) {
		switch ($_GET['pesan']):
			case 1: $message = 'Akun tidak dapat ditemukan.'; break;
		endswitch;
	}
	
	$param		= array(
		'info' 				=> $info,
		'bisnis'			=> $bisnis,
		'berita'			=> true,
		'direktori'			=> $direktori,
		'premium_direktori'	=> $pdirektori,
		'kategori_direktori'=> $katdir,
		'jual'				=> $jual,
		'beli'				=> $beli,
		'produk'			=> $produk,
		'direktori_produk'	=> $pproduk,
		'tips'				=> $tips,
		'at_home'			=> true,
		'message'			=> $message
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
 * Method: GET
 * Verb: ongkir
 */
$app->options('/ongkir', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/ongkir', function() use($app, $ctr) {
	$ctr->load('model', 'front');
	$r = $ctr->FrontModel->get_ongkir();
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
 * Method: GET
 * Verb: konfirmasi/kode/password 
 */
$app->options('/konfirmasi/:kode/:password', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/konfirmasi/:kode/:password', function($kode, $password) use($app, $ctr) {
	$ctr->load('model', 'main');
	if (cek_token($ctr)) redirect_home();
	$r = $ctr->MainModel->member_confirm($kode, $password);
	if ( ! $r) redirect_home();
	$ctr->load('view', 'pendaftaran.html', array(
		'registering'	=> true,
		'konfirmasi' => true,
		'status' => $r
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
 * Method: GET
 * Verb: fpass
 */
$app->options('/fpass', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/fpass', function() use($app, $ctr) {
	$ctr->load('view', 'forget-pass.html', array());
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: fpass
 */
$app->post('/fpass', function() use($app, $ctr) {
	$ctr->load('model', 'main');
	// include phpmailer
	$ctr->load('file', 'lib/PHPMailer/PHPMailerAutoload.php');
	$r = $ctr->MainModel->member_fpass(new PHPMailer);
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
	} else redirect_index(1);
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
 * Verb: katalog/:type
 */
$app->options('/katalog/:type', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/katalog/:type', function($type) use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('model', 'produk');
	if ($type == 'fproduk') {
		$r = $ctr->ProdukModel->get_all_post();
		$produk = $r['produk'];
	} else {
		$ctr->load('model', 'direktori');
		$direktori = $ctr->DirektoriModel->get_name($type);
		$cproduk = $ctr->ProdukModel->get_produk($type);
        $produk = $cproduk['produk'];
	}
	foreach ($produk as $key => $val) {
		$produk[$key]['foto'] = substr($val['foto'], 1, strlen($val['foto']));
	}
	ob_start();
	$ctr->load('view', 'katalog.html', array(
		'produk'	=> $produk,
		'nama'		=> (isset($direktori) ? $direktori : '')
	));
	$content = ob_get_contents();
	ob_end_clean();
	$ctr->load('file', 'lib/html2pdf/html2pdf.class.php');
	$ctr->load('file', 'lib/html2pdf/html2pdf.class.php');
	try {
		$html2pdf 	= new HTML2PDF('L', 'A4', 'en');
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content);
		$html2pdf->Output('katalog.pdf', 'D');
	} catch(HTML2PDF_exception $e) {
		echo $e; exit;
	}
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
	$member['path'] = ' ';
	// data rekening
	$r 		= $ctr->MainModel->get_data_table('rekening');
	$member['rekening'] = $r['rekening'];
	$ctr->load('model', 'front');
	$member['tips'] = $ctr->FrontModel->get_tips();
    $member['page'] = 'home';
	$member['tanggal'] = date('d/m/Y');
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
		case 'direktori': case 'produk':
			// cari data direktori
			$ctr->load('model', 'direktori');
			$r = $ctr->DirektoriModel->get_direktori_list($member['member_kode']);
			if ($r === FALSE) halt403($app);
			$member['direktori'] = $r;
			// apakah ada direktori dalam proses
			$r = $ctr->DirektoriModel->get_inprocess_direktori($member['member_kode']);
			$member['direktori_inprocess'] = $r;
			// cari direktori tanpa pemilik
			$r = $ctr->DirektoriModel->get_direktori_list('', true);
			$member['edirektori'] = $r;
			// kota
			$r = $ctr->MainModel->get_data_table('kota_direktori');
			$member['kota'] = $r['kota_direktori'];
			break;
		case 'invoice':
			// cari data invoice
			$ctr->load('helper', 'date');
			$ctr->load('model', 'produk');
			$r = $ctr->ProdukModel->get_order($member['member_kode']);
			if ($r === FALSE) halt403($app);
			$member['invoice'] = $r;
			break;
		case 'order':
			$r = $ctr->MainModel->get_data_table('rekening');
			$member['rekening'] = $r['rekening'];
			break;
		case 'pesan':
			
			break;
		default: 
			//redirect_index();
			break;
	}
	$member['path'] = $type;
    $member['page'] = 'home';
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
 * Verb: subdomain/:state 
 */
$app->options('/subdomain/:state', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/subdomain/:state', function($state) use($app, $ctr) {
	$ctr->load('model', 'direktori');
	$r = $ctr->DirektoriModel->validate_subdomain($state);
	json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: berita
 */
$app->options('/:type', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/:type', function($type) use($app, $ctr) {
	$ctr->load('helper', 'date');
	$ctr->load('helper', 'string');
	$ctr->load('model', 'front');
	$news = $ctr->FrontModel->news_list($type);
	$news[$type] = true;
	if ($news === FALSE) halt404();
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$news['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$news[$key] = $val;
	}
    $news['page'] = $type;
	$ctr->load('view', 'berita-search.html', $news);
})->conditions(array('type' => '(berita|info)'));

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
    $news['page'] = 'berita';
	$ctr->load('view', 'berita.html', $news);
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
	if ($news === FALSE) halt404($app);
	$news['other'] = $ctr->FrontModel->news_other('info', $news['id']);
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$news['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$news[$key] = $val;
	}
    $news['page'] = 'info';
	$ctr->load('view', 'berita.html', $news);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: direktori/:alpha 
 */
$app->options('/direktori/:alpha', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/direktori/:alpha', function($alpha) use($app, $ctr) {
	if ( ! is_numeric($alpha)) {
		$ctr->load('model', 'direktori');
		if (preg_match('/[A-Z]/', $alpha)) $r = $ctr->DirektoriModel->get_list($alpha);
		json_output($app, $r);
	}
	if (is_numeric($alpha)) {
		if ( ! cek_token($ctr)) halt403($app);
		
		// cari data
		if (isset($_GET['type'])) {
			if ($_GET['type'] == 'data') {
				$ctr->load('model', 'direktori');
				$r = $ctr->DirektoriModel->get_data($alpha);
				json_output($app, $r);
			}
		} else {
			// cari produk
			$ctr->load('helper', 'string');
			$ctr->load('model', 'produk');
			$produk = $ctr->ProdukModel->get_produk($alpha);
			json_output($app, $produk);
		}
	}
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
		$d = $ctr->MainModel->get_data_table('kota_direktori,kategori_direktori');
		$dirlist['kota'] = $d['kota_direktori'];
		$dirlist['kategori'] = $d['kategori_direktori'];
	}
    $dirlist['page'] = 'direktori';
	$ctr->load('view', 'direktori-search.html', $dirlist);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: direktori/:id
 */
$app->options('/direktori/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/direktori/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'direktori');
	$ctr->load('file', 'lib/IOFiles.php');
	$member = $ctr->MainModel->member_me($_COOKIE['token']);
	$r = $ctr->DirektoriModel->save_direktori($id, new IOFiles(), $member['data']['member_kode']);
	if ($r !== FALSE) json_output($app, $r);
})->conditions(array('id' => '[0-9]+'));

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: direktori/news
 */
$app->options('/direktori/new', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/direktori/new', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'direktori');
	$ctr->load('file', 'lib/IOFiles.php');
	$member = $ctr->MainModel->member_me($_COOKIE['token']);
	$r = $ctr->DirektoriModel->new_direktori($member['data'], new IOFiles());
	header('Location: /home/direktori?status=' . ($r === FALSE ? 0 : 1));
	exit;
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
	$cproduk = $ctr->ProdukModel->get_produk($id, false, true);
    $produk = $cproduk['produk'];
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
    $direktori['page'] = 'direktori';
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
 * Method: POST
 * Verb: anggota/:kode 
 */
$app->post('/anggota/:kode', function($kode) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('file', 'IOFiles.php');
	$r 	= $ctr->MainModel->member_profil($_COOKIE['token'], new IOFiles());
	if ($r === FALSE) halt403($app);
	json_output($app, $r);
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
 * Verb: post/:id
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
})->conditions(array('id' => '\d+'));

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: post/aduan
 */
$app->post('/post/aduan', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$member = $ctr->MainModel->member_me($_COOKIE['token']);
	$ctr->load('model', 'post');
	$r = $ctr->PostModel->save_aduan($member['data']);
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
$app->options('/:type', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/:type', function($type) use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('helper', 'date');
	$ctr->load('model', 'post');
	$post = $ctr->PostModel->get_all_post(($type == 'jual' ? 1 : 2));
	$post[$type] = true;
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$post['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$post[$key] = $val;
	}
	$ctr->load('model', 'main');
	$r = $ctr->MainModel->get_data_table('kategori_produk');
	if ($r) $post['kategori'] = $r['kategori_produk'];
    $post['page'] = $type;
	$ctr->load('view', 'kiriman-search.html', $post);
})->conditions(array('type' => '(jual|beli)'));

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
	$produk['kategori'] = $ctr->ProdukModel->get_kategori_fproduk();
    $produk['page'] = 'produk';
	$ctr->load('view', 'fproduk-search.html', $produk);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: produk 
 */
$app->options('/produk', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/produk', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'produk');
	$ctr->load('file', 'lib/IOFiles.php');
	$r = $ctr->ProdukModel->save_produk(0, new IOFiles());
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: order 
 */
$app->options('/order', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/order', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$member = $ctr->MainModel->member_me($_COOKIE['token']);
	$ctr->load('helper', 'date');
	$ctr->load('model', 'produk');
	$r = $ctr->ProdukModel->get_order_list($member['data']['member_kode']);
	if ($r !== FALSE) json_output($app, array('type' => TRUE, 'order' => $r));
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: order 
 */
$app->post('/order', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'produk');
	$member = $ctr->MainModel->member_me($_COOKIE['token']);
	$r = $ctr->ProdukModel->save_order($member['data']['member_kode']);
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: order/:id
 */
$app->options('/order/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/order/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'produk');
	$member = $ctr->MainModel->member_me($_COOKIE['token']);
	if ($id == 'konfirmasi') $r = $ctr->ProdukModel->confirm_order($member['data']['member_kode']);
	if (is_numeric($id)) $r = $ctr->ProdukModel->save_order($member['data']['member_kode'], $id);
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: produk
 */
$app->options('/produk', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/produk', function() use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('model', 'produk');
	$produk = $ctr->ProdukModel->get_all_post2();
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$produk['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$produk[$key] = $val;
	}
	$ctr->load('model', 'main');
	$produk['kategori'] = $ctr->ProdukModel->get_kategori_produk();
    $produk['page'] = 'direktori';
	$ctr->load('view', 'produk-search.html', $produk);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: produk/:id
 */
$app->options('/produk/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/produk/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'produk');
	$produk = $ctr->ProdukModel->get_produk($id, TRUE);
	if ($produk !== FALSE) json_output($app, array(
		'type' 	=> TRUE, 'produk' => $produk
	));
});

// ----------------------------------------------------------------
/**
 * Method: POST
 * Verb: produk/:id
 */
$app->post('/produk/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'produk');
	$ctr->load('file', 'lib/IOFiles.php');
	$r = $ctr->ProdukModel->save_produk($id, new IOFiles());
	if ($r !== FALSE) json_output($app, $r);
});

// ----------------------------------------------------------------
/**
 * Method: DELETE
 * Verb: produk/:id
 */
$app->delete('/produk/:id', function($id) use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('model', 'produk');
	$r = $ctr->ProdukModel->delete($id);
	if ($r !== FALSE) json_output($app, $r);
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
    $produk['page'] = 'direktori';
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
    $produk['page'] = 'produk';
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
    $post['page'] = 'jual';
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
    $post['page'] = 'beli';
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

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: invoice/:id
 */
$app->options('/invoice/:id', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/invoice/:id', function($id) use($app, $ctr) {
	// cari data invoice
	$ctr->load('helper', 'date');
	$ctr->load('model', 'produk');
	$r = $ctr->ProdukModel->get_order_by_id($id);
	$ctr->load('view', 'home-invoice.html', array(
		'invoice' 		=> $r['invoice'],
		'member_nama'	=> $r['member_nama'],
		'member_alamat'	=> $r['member_alamat'],
		'member_telepon'=> $r['member_telepon']
	));
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: tos
 */
$app->options('/tos', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/tos', function() use($app, $ctr) {
	$r = array();
	$r['tos'] = file_get_contents('model/tos.shtml');
	$ctr->load('view', 'tos.html', $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: help
 */
$app->options('/help', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/help', function() use($app, $ctr) {
	$r = array();
	$r['help'] = file_get_contents('model/help.shtml');
	$ctr->load('view', 'help.html', $r);
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: /:nama
 */
$app->options('/:nama', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/:nama', function($nama) use($app, $ctr) {
	$ctr->load('helper', 'string');
	$ctr->load('helper', 'date');
	
    $ctr->load('model', 'anggota');
    $toko   = $ctr->AnggotaModel->get_data($nama);
    if ($toko === FALSE) {
		$ctr->load('view', '404.html', array());
		$app->stop();
    }
    
	// cek token
	if (cek_token($ctr)) {
		$member	= $ctr->MainModel->member_me($_COOKIE['token']);
		$toko['authenticate'] = TRUE;
		foreach ($member['data'] as $key => $val)
			$toko[$key] = $val;
	}
    $ctr->load('view', 'toko.html', $toko);
})->conditions(array('nama' => '[a-z0-9\.]+'));

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: /tos/draft
 */
$app->options('/tos/draft', function() use($app) { $app->status(200); $app->stop(); });
$app->get('/tos/draft', function() use($app, $ctr) {
	$cont = @file_get_contents('model/tos.shtml');
	json_output($app, array(
		'type' => true, 'tos' => $cont
	));
});

// ----------------------------------------------------------------
/**
 * Method: GET
 * Verb: /upgrade
 */
$app->options('/upgrade', function() use($app) { $app->status(200); $app->stop(); });
$app->post('/upgrade', function() use($app, $ctr) {
	if ( ! cek_token($ctr)) halt403($app);
	$ctr->load('helper', 'date');
	$ctr->load('model', 'anggota');
	$member	= $ctr->MainModel->member_me($_COOKIE['token']);
	$r = $ctr->AnggotaModel->upgrade_member($member['data']['member_kode']);
	json_output($app, $r);
});
