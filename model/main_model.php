<?php
/**
 * Main Model
 */
namespace Model;

class MainModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Salt untuk password dan token
	 */
	private $salt = 'mdbz0955201579';
	
	/**
	 * Validasi email
	 */
	public function validate_email($type) {
		extract($this->prepare_get(array('email')));
		$email	= $this->db->escape_str($email);
		$valid	= TRUE;
		if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
			// validate email
			$valid = FALSE;
		} else {
			// apakah sudah digunakan
			if ($type == 'used') {
				$run 	= $this->db->query("SELECT COUNT(ID_ANGGOTA) AS HASIL FROM anggota WHERE EMAIL_ANGGOTA = '$email'", TRUE);
				if ($run->HASIL > 0) $valid = FALSE;
				$run	= $this->db->query("SELECT COUNT(ID_ADMIN) AS HASIL FROM admin WHERE EMAIL_ADMIN = '$email'", TRUE);
				if ($run->HASIL > 0) $valid = FALSE;
			}
		}
		return array(
			'type'	=> TRUE,
			'valid'	=> $valid
		);
	}
	
	/**
	 * Validate token
	 * Periksa adakah token, jika ada dan tidak expired = perpanjang, 
	 * jika tidak ada = invalid, jika ada tapi expired = invalid
	 */
	public function validate_token($token = '') {
		// token dari header
		if (empty($token)) {
			if ( ! function_exists('apache_request_headers')) {
                if ( ! isset($_SERVER['Authorization'])) return FALSE;		
                list($a, $token) = explode(' ', $_SERVER['Authorization']);
			} else {
                $header		= apache_request_headers();
                if ( ! isset($header['Authorization'])) return FALSE;		
                list($a, $token) = explode(' ', $header['Authorization']);
			}
		}
		$token 		= (array) \JWT::decode($token, $this->salt);
		$data 		= array('id', 'email', 'tokenid', 'user', 'level', 'source');
		foreach ($data as $v) {
			if ( ! isset($token[$v])) return FALSE;
		}
		extract($token);
		
		// cek apakah status anggota atau admin valid atau tidak
		if ($user == 'admin') {
			$cek	= $this->db->query("SELECT a.STATUS_ADMIN FROM admin a, token b WHERE a.EMAIL_ADMIN = b.EMAIL_TOKEN AND a.EMAIL_ADMIN = '$email'", TRUE);
			if (empty($cek)) return FALSE;
			if ($cek->STATUS_ADMIN != '1') return FALSE;
		}
		if ($user == 'member') {
			$cek 	= $this->db->query("SELECT a.STATUS_ANGGOTA FROM anggota a, token b WHERE a.EMAIL_ANGGOTA = b.EMAIL_TOKEN AND a.EMAIL_ANGGOTA = '$email'", TRUE);
			if (empty($cek)) return FALSE;
			if ($cek->STATUS_ANGGOTA != '1') return FALSE;
		}
		
		// periksa di database tabel token
		$tokenid 	= floatval($tokenid);
		$cari 		= $this->db->query("SELECT * FROM token WHERE ID_TOKEN = '$tokenid' AND SOURCE_TOKEN = '$source'", TRUE);
		// hapus semua jika tidak valid
		if (empty($cari)) {
			$del 	= $this->db->query("DELETE FROM token WHERE EMAIL_TOKEN = '$email'");
			return FALSE;
		}
		
		// cek apakah expired
		$tgldb 		= datedb_to_tanggal($cari->EXPIRED_TOKEN, 'U');
		if (time() > $tgldb) {
			$del 	= $this->db->query("DELETE FROM token WHERE ID_TOKEN = '" . $cari->ID_TOKEN . "'");
			return FALSE;
		}
		
		// perbarui token
		$exp 		= ($cari->INGAT_TOKEN == '1' ? time() + (5 * 24 * 3600) : time() + 600);
		$upd 		= $this->db->query("UPDATE token SET EXPIRED_TOKEN = '" . date('Y-m-d H:i:s', $exp) . "' WHERE ID_TOKEN = '" . $cari->ID_TOKEN . "'");
		
		return $token;
	}
	
	
	/**
	 * Admin login
	 * Generate token baru, hapus yang lama jika ada
	 */
	public function admin_authenticate() {
		extract($this->prepare_post(array('email', 'password', 'remember', 'source')));
		
		$password 	= crypt($password, $this->salt);
		$email 		= $this->db->escape_str($email);
		$remember 	= ($remember == 'true' ? TRUE : FALSE);
		switch (strtolower($source)) {
			case 'web': case 'phone': case 'desktop': break;
			default: $source = 'web';
		}
		$r 			= array( 'type' => FALSE, 'data' => 'Email / Password Invalid!' );
		
		// cari di tabel admin
		$cari 		= $this->db->query("SELECT ID_ADMIN, LEVEL_ADMIN FROM admin WHERE EMAIL_ADMIN = '$email' AND PASSWORD_ADMIN = '$password' AND STATUS_ADMIN = '1'", TRUE);
		if ( ! empty($cari)) {
			$iduser = $cari->ID_ADMIN;
			$lvuser = $cari->LEVEL_ADMIN;
			
			// cari token
			$cari 	= $this->db->query("SELECT ID_TOKEN FROM token WHERE EMAIL_TOKEN = '$email' AND SOURCE_TOKEN = '$source'", TRUE);
			if ( ! empty($cari)) $hapus = $this->db->query("DELETE FROM token WHERE ID_TOKEN = '" . $cari->ID_TOKEN . "'");
			
			// insert
			$exp 	= ($remember ? time() + (5 * 24 * 3600) : time() + 600);
			$ins 	= $this->db->query("INSERT INTO token VALUES(0, '$email', '', '" . date('Y-m-d H:i:s', $exp) . "', '" . ($remember ? 1 : 0) . "', '$source')");
			$tokenid 		= $this->db->get_insert_id();
			$token 			= array(
				'id' 		=> $iduser,
				'email' 	=> $email,
				'tokenid' 	=> $tokenid,
				'user' 		=> 'admin',
				'level' 	=> $lvuser,
				'source' 	=> $source
			);
			$token 	= \JWT::encode($token, $this->salt);
			$upd 	= $this->db->query("UPDATE token SET DATA_TOKEN = '$token' WHERE ID_TOKEN = '$tokenid'");
			
			$r['type'] 		= TRUE;
			$r['data'] 		= array( 'token' => $token );
			return $r;
		}
		
		// jika tidak ada
		return $r;
	}
	
	/**
	 * Signout
	 */
	public function admin_signout($token) {
		$token 		= (array) \JWT::decode($token, $this->salt);
		$data 		= array('id', 'email', 'tokenid', 'user', 'level', 'source');
		foreach ($data as $v) {
			if ( ! isset($token[$v])) return FALSE;
		}
		extract($token);
		
		// periksa di database tabel token
		$tokenid 	= floatval($tokenid);
		$del 		= $this->db->query("DELETE FROM token WHERE ID_TOKEN = '$tokenid'");
		return array( 'type' => TRUE );
	}
	
	/**
	 * Mendapatkan data user
	 */
	public function admin_me($token) {
		$r 			= array(
			'type' 	=> TRUE,
			'data' 	=> array()
		);
		$cari 		= $this->db->query("SELECT NAMA_ADMIN, FOTO_ADMIN, LEVEL_ADMIN FROM admin WHERE ID_ADMIN = '{$token['id']}'", TRUE);
		$r['data']['nama'] 	= $cari->NAMA_ADMIN;
		$r['data']['foto'] 	= 'upload/member/' . (empty($cari->FOTO_ADMIN) ? 'default.png' : $cari->FOTO_ADMIN);
		$r['data']['level'] = $cari->LEVEL_ADMIN;
		return $r;
	}
	
	/**
	 * Menyimpan data user
	 */
	public function admin_profil($token, $iofiles) {
		extract($token);
		extract($this->prepare_post(array('nama', 'pass', 'pass2')));
		$run	= $this->db->query("SELECT NAMA_ADMIN FROM admin WHERE ID_ADMIN = '$id'", TRUE);
		if (empty($run)) return FALSE;
		$upd 	= array();
		if (strlen($nama) > 3 AND $nama != $run->NAMA_ADMIN) $upd[] = "NAMA_ADMIN = '$nama'";
		if (strlen($pass) > 6 AND $pass == $pass2) $upd[] = "PASSWORD_ADMIN = '" . crypt($pass, $this->salt) . "'";
		if ( ! empty($upd))
			$run = $this->db->query("UPDATE admin SET " . implode(", ", $upd) . " WHERE ID_ADMIN = '$id'");
		
		if (isset($_FILES['file'])) {
			// foto
			$run = $this->db->query("SELECT FOTO_ADMIN FROM admin WHERE ID_ADMIN = '$id'", TRUE);
			if ( ! empty($run)) {
				@unlink('upload/member/' . $run->FOTO_ADMIN);
				@unlink('upload/member/' . str_replace('.', '_thumb.', $run->FOTO_ADMIN));
			}
			$config['upload_path']		= 'upload/member/';
			$config['allowed_types']	= 'jpeg|jpg|png';
			$config['encrypt_name']		= TRUE;
			$config['overwrite']		= TRUE;
			$iofiles->upload_config($config);
			$iofiles->upload('file');
			$filename 					= $iofiles->upload_get_param('file_name');
			// buat thumbnail
			$config						= array();
			$config['source_image']		= 'upload/member/' . $filename;
			$config['new_image']		= 'upload/member/' . str_replace('.', '_thumb.', $filename);
			$config['maintain_ratio']	= TRUE;
			$config['width']			= 200;
			$config['height']			= 200;
			$iofiles->image_config($config);
			$iofiles->image_resize();
			// update tabel
			$upd = $this->db->query("UPDATE admin SET FOTO_ADMIN = '$filename' WHERE ID_ADMIN = '$id'");
		}
		
		return array( 'type' => TRUE );
	}
	
	/**
	 * Tambah admin
	 */
	public function admin_save($token, $kode = '') {
		extract($token);
		extract($this->prepare_post(array('email', 'nama', 'pass', 'pass2', 'status')));
		$email	= $this->db->escape_str($email);
		$nama	= $this->db->escape_str($nama);
		
		// hanya jika superadmin
		if ($level != '1') return FALSE;
		if ( ! empty($status)) {
			if ($status != '1' AND $status != '2') $status = '1';
			$upd	= $this->db->query("UPDATE admin SET STATUS_ADMIN = '$status' WHERE ID_ADMIN = '$kode'");
		} else {
			$ins	= $this->db->query("INSERT INTO admin VALUES(0, '$email', '" . crypt($pass, $this->salt) . "', '$nama', '', '2', '1')");
		}
		return array( 'type' => TRUE );
	}
	
	/**
	 * Mendapatkan data dari tabel
	 */
	public function get_data_table($t = '') {
		if (empty($t)) extract($this->prepare_get(array('t')));
		$tabel 	= explode(',', $t);
		$stabel	= array();
		foreach ($tabel as $val) {
			switch ($val) {
				case 'kota': case 'kota_direktori':
					$stabel[]	= array('kota', 'kota'); break;
				case 'kategori_direktori': 
					$stabel[] 	= array('katdir', 'kategori_direktori'); break;
				case 'kategori_produk':	
					$stabel[] 	= array('katproduk', 'kategori_produk'); break;
				case 'anggota':
					$stabel[]	= array('anggota', 'anggota'); break;
				case 'kurir':
					$stabel[]	= array('kurir', 'kurir'); break;
				default: continue;
			}
		}
		$r 		= array();
		
		$this->db->query("START TRANSACTION");
		
		// fproduk
		if (in_array('fproduk', $tabel)) {
			$run 	= $this->db->query("SELECT ID_PRODUKUTAMA, NAMA_PRODUKUTAMA, HARGA_PRODUKUTAMA, BERAT_PRODUKUTAMA FROM produkutama WHERE STATUS_PRODUKUTAMA = '1' ORDER BY NAMA_PRODUKUTAMA");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					$r['fproduk'][] = array(
						'id'	=> $val->ID_PRODUKUTAMA,
						'nama'	=> $val->NAMA_PRODUKUTAMA,
						'harga'	=> $val->HARGA_PRODUKUTAMA,
						'berat'	=> floatval($val->BERAT_PRODUKUTAMA)
					);
				}
			}
		}
		
		// rekening
		if (in_array('rekening', $tabel)) {
			$run	= $this->db->query("SELECT * FROM rekening WHERE STATUS_REKENING = '1' ORDER BY BANK_REKENING");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					$r['rekening'][] = array(
						'id'	=> $val->ID_REKENING,
						'bank'	=> $val->BANK_REKENING,
						'nomor'	=> $val->NOMOR_REKENING,
						'an'	=> $val->AN_REKENING
					);
				}
			}
		}
		
		// biaya kurir
		if (in_array('ongkir', $tabel)) {
			$run 	= $this->db->query("SELECT a.ID_BIAYAKURIR, a.BIAYA_BIAYAKURIR, b.ID_KOTA, b.NAMA_KOTA, c.ID_KURIR, c.NAMA_KURIR FROM biayakurir a, kota b, kurir c WHERE a.ID_KOTA = b.ID_KOTA AND a.ID_KURIR = c.ID_KURIR ORDER BY c.NAMA_KURIR, b.NAMA_KOTA");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					$r['ongkir'][] = array(
						'i'	=> $val->ID_BIAYAKURIR,
						'o'	=> $val->NAMA_KOTA,
						'oi'=> $val->ID_KOTA,
						'b'	=> number_format($val->BIAYA_BIAYAKURIR, 0, ',', '.'),
						'k'	=> $val->NAMA_KURIR,
						'ki'=> $val->ID_KURIR
					);
				}
			}
		}
		
		// kota tapi hanya direktori saja
		if (in_array('kota_direktori', $tabel)) {
			$run	= $this->db->query("SELECT ID_KOTA, NAMA_KOTA FROM kota WHERE KODE_KOTA = 'DIR'");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					$r['kota_direktori'][] = array(
						'id'	=> $val->ID_KOTA,
						'nama'	=> $val->NAMA_KOTA
					);
				}
			}
		}
		
		// kota, kategori_direktori, kategori_produk, anggota
		if ( ! empty($stabel)) {
			foreach ($stabel as $val) {
				$t 		= $val[0];
				$tu		= strtoupper($t);
				$l 		= $val[1];
				$where	= array("STATUS_$tu != '0'");
				if ($t == 'anggota') $where[]	= "JENIS_ANGGOTA = '2'";
				
				$run 	= $this->db->query("SELECT * FROM $t WHERE " . implode(' AND ', $where) . " ORDER  BY NAMA_$tu", FALSE, FALSE);
				if ( ! empty($run)) {
					foreach ($run as $v) {
						$r[$l][]	= array(
							'id'	=> $v['ID_' . $tu],
							'nama'	=> $v['NAMA_' . $tu]
						);
					}
				}
			}
		}
		
		$this->db->query("COMMIT");
		return $r;
	}
	
	/**
	 * Memasukkan atau mengubah data dari tabel
	 */
	public function set_data_table() {
		extract($this->prepare_get(array('t', 'id')));
		switch ($t) {
			case 'kota': $tabel = 'kota'; break;
			case 'kategori_direktori': $tabel = 'katdir'; break;
			case 'kategori_produk':	$tabel = 'katproduk'; break;
			case 'kurir': $tabel = 'kurir'; break;
			case 'rekening': $tabel = 'rekening'; break;
			case 'ongkir': $tabel = 'ongkir'; break;
			default: return FALSE;
		}
		$id = intval($id);
		switch ($tabel) {
			case 'rekening':
				extract($this->prepare_post(array('id', 'bank', 'nomor', 'an')));
				$an 	= $this->db->escape_str($an);
				$bank 	= $this->db->escape_str($bank);
				$nomor 	= $this->db->escape_str($nomor);
				if (empty($id))
					$ins = $this->db->query("INSERT INTO rekening VALUES(0, '$bank', '$nomor', '$an', '1')");
				else {
					$run = $this->db->query("SELECT * FROM rekening WHERE ID_REKENING = '$id'", TRUE);
					if (empty($run)) return FALSE;
					$upd = array();
					if ($run->BANK_REKENING != $bank) 	$upd[] = "BANK_REKENING = '$bank'";
					if ($run->NOMOR_REKENING != $nomor)	$upd[] = "NOMOR_REKENING = '$nomor'";
					if ($run->AN_REKENING != $an) 		$upd[] = "AN_REKENING = '$an'";
					if ( ! empty($upd))
						$run = $this->db->query("UPDATE rekening SET " . implode(", ", $upd) . " WHERE ID_REKENING = '$id'");
				}
				break;
			case 'ongkir':
				extract($this->prepare_post(array('i', 'oi', 'ki', 'b', 'l')));
				$kota	= filter_var($oi, FILTER_SANITIZE_NUMBER_INT);
				$kurir	= filter_var($ki, FILTER_SANITIZE_NUMBER_INT);
				$biaya	= preg_replace('/[^0-9]/', '', $b);
				$lanjut	= preg_replace('/[^0-9]/', '', $l);
				if (empty($id)) {
					$ins = $this->db->query("INSERT INTO biayakurir VALUES(0, '$kurir', '$kota', '$biaya', '$lanjut')");
				} else {
					$run = $this->db->query("SELECT * FROM biayakurir WHERE ID_BIAYAKURIR = '$id'", TRUE);
					if (empty($run)) return FALSE;
					$upd = array();
					if ($run->ID_KURIR != $kurir)		$upd[] = "ID_KURIR = '$kurir'";
					if ($run->ID_KOTA != $kota)			$upd[] = "ID_KOTA = '$kota'";
					if ($run->BIAYA_BIAYAKURIR != $biaya)		$upd[] = "BIAYA_BIAYAKURIR = '$biaya'";
					if ($run->LANJUTAN_BIAYAKURIR != $lanjut)	$upd[] = "LANJUTAN_BIAYAKURIR_BIAYAKURIR = '$lanjut'";
					if ( ! empty($upd)) {
						$run = $this->db->query("UPDATE biayakurir SET " . implode(", ", $upd) . " WHERE ID_BIAYAKURIR = '$id'");
					}
				}
				break;
			default:
				extract($this->prepare_post(array('nama')));
				$nama = $this->db->escape_str(ucwords($nama));
				if (empty($id)) {
					if ($tabel == 'kota')
						$ins = $this->db->query("INSERT INTO $tabel VALUES(0, '', '$nama', '1')");
					else
						$ins = $this->db->query("INSERT INTO $tabel VALUES(0, '$nama', '1')");
				} else {
					$upd = $this->db->query("UPDATE $tabel SET NAMA_" . strtoupper($tabel) . " = '$nama' WHERE ID_" . strtoupper($tabel) . " = '$id'");
				}
		}
		return array('type' => TRUE);
	}
	
	/**
	 * hapus data tabel
	 */
	public function delete_data_table() {
		extract($this->prepare_get(array('t', 'id')));
		switch ($t) {
			case 'kota': $tabel = 'kota'; break;
			case 'kategori_direktori': $tabel = 'katdir'; break;
			case 'kategori_produk':	$tabel = 'katproduk'; break;
			case 'kurir': $tabel = 'kurir'; break;
			case 'rekening': $tabel = 'rekening'; break;
			case 'ongkir': $tabel = 'ongkir'; break;
			default: return FALSE;
		}
		$id 	= intval($id);
		if ($tabel == 'ongkir')
			$del 	= $this->db->query("DELETE FROM biayakurir WHERE ID_BIAYAKURIR = '$id'");
		else
			$del 	= $this->db->query("UPDATE $tabel SET STATUS_" . strtoupper($tabel) . " = '0' WHERE ID_" . strtoupper($tabel) . " = '$id'");
		return array('type' => TRUE);
	}

	
	/**
	 * simpan anggota
	 */
	private function member_password( $length = 8 ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&?";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	public function member_save($mail) {
		extract($this->prepare_post(array('email', 'nama', 'telepon', 'alamat')));
		$email	= $this->db->escape_str($email);
		$nama	= $this->db->escape_str($nama);
		$telp	= $this->db->escape_str($telepon);
        if ( ! empty($alamat)) $valid = FALSE;
		if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) $valid = FALSE;
		if (strlen($nama) < 3) $valid = FALSE;
		if ( ! preg_match('/\+62\-[0-9]{4,20}/', $telp)) $valid = FALSE;
		
		// periksa email
		$run	= $this->db->query("SELECT COUNT(ID_ANGGOTA) AS HASIL FROM anggota WHERE EMAIL_ANGGOTA = '$email'", TRUE);
		if ($run->HASIL > 0) return array('type' => FALSE);
		// generate kode
		$kode 	= preg_replace('/[^a-z0-9]/', '', uniqid('mdbz'));
		// generate password
		$pass	= $this->member_password(10);
		$ins	= $this->db->query("INSERT INTO anggota VALUES(0, '$kode', '$email', '" . crypt($pass, $this->salt) . "', '$nama', '', '$telepon', '', '', '0', NOW(), '1', '1')");
		
		// kirim email
		$pesanHTML 			= 'Selamat datang di situs MADURA.BZ, situs direktori bisnis dan jual beli di Madura. Mulai saat ini Anda dapat menggunakan fasilitas yang ada di situs kami menggunakan akun:<br><strong>Email: ' . $email . '<br>Password: ' . $pass . '</strong><br>Kami sangat mengharapkan keaktifan Anda dalam menggunakan situs kami. Terima kasih<br><br>Administrator';
		$pesanPlain 		= 'Selamat datang di situs MADURA.BZ, situs direktori bisnis dan jual beli di Madura. Mulai saat ini Anda dapat menggunakan fasilitas yang ada di situs kami menggunakan akun:
		Email: ' . $email . '
		Password: ' . $pass . '
		Kami sangat mengharapkan keaktifan Anda dalam menggunakan situs kami. Terima kasih
		
		Administrator';
		$subject			= 'Selamat. Anda terdaftar di MADURA.BZ';
		$mail->isSMTP();
		$mail->From 		= 'admin@madura.bz';
		$mail->FromName		= 'MADURA.BZ';
		$mail->Subject		= $subject;
		$mail->Body			= $pesanHTML;
		$mail->AltBody		= wordwrap($pesanPlain, 70);
		$mail->addAddress($email, $nama);
		$mail->addReplyTo('noreply@madura.bz', 'Jangan dibalas');
		$mail->isHTML(true);
		if ( ! @$mail->send()) {
			$headers		= 'From: admin@madura.bz' . "\r\n" .
				'Reply-To: noreply@madura.bz' . "\r\n" . 
				'X-Mailer: PHP/' . phpversion();
			@mail($email, $subject, wordwrap($pesanPlain, 70), $headers);
		}
		return array(
			'type'		=> TRUE,
			'password'	=> $pass
		);
	}
	
	/**
	 * Login anggota
	 */
	public function member_authenticate() {
		extract($this->prepare_post(array('email', 'password')));
		$password	= crypt($password, $this->salt);
		$email		= $this->db->escape_str($email);
		$remember	= TRUE;
		$source		= 'web';
		$r			= array('type' => FALSE, 'data' => 'Email / Password Invalid!');
		// cari di tabel admin
		$cari		= $this->db->query("SELECT ID_ANGGOTA, JENIS_ANGGOTA FROM anggota WHERE EMAIL_ANGGOTA = '$email' AND PASSWORD_ANGGOTA = '$password' AND STATUS_ANGGOTA = '1'", TRUE);
		if ( ! empty($cari)) {
			$iduser	= $cari->ID_ANGGOTA;
			$jnuser	= $cari->JENIS_ANGGOTA;
			// cari token
			$cari	= $this->db->query("SELECT ID_TOKEN FROM token WHERE EMAIL_TOKEN = '$email' AND SOURCE_TOKEN = '$source'", TRUE);
			if ( ! empty($cari)) $hapus = $this->db->query("DELETE FROM token WHERE ID_TOKEN = '" . $cari->ID_TOKEN . "'");
			// insert new token
			$exp	= time() + (5 * 24 * 3600);
			$ins	= $this->db->query("INSERT INTO token VALUES(0, '$email', '', '" . date('Y-m-d H:i:s', $exp) . "', '1', 'web')");
			$tokenid= $this->db->get_insert_id();
			$token	= array(
				'id'		=> $iduser,
				'email'		=> $email,
				'tokenid'	=> $tokenid,
				'user'		=> 'member',
				'level'		=> $jnuser,
				'source'	=> $source
			);
			$token	= \JWT::encode($token, $this->salt);
			$upd	= $this->db->query("UPDATE token SET DATA_TOKEN = '$token' WHERE ID_TOKEN = '$tokenid'");
			
			$r['type']	= TRUE;
			$r['data']	= array('token' => $token, 'expired' => $exp);
			return $r;
		}
		
		return $r;
	}
	
	/**
	 * Member signout
	 */
	public function member_signout($token) {
		// hapus token
		$token 		= (array) \JWT::decode($token, $this->salt);
		$data 		= array('id', 'email', 'tokenid', 'user', 'level', 'source');
		foreach ($data as $v) {
			if ( ! isset($token[$v])) return FALSE;
		}
		extract($token);
		
		// periksa di database tabel token
		$tokenid 	= floatval($tokenid);
		$del 		= $this->db->query("DELETE FROM token WHERE ID_TOKEN = '$tokenid'");
		return array( 'type' => TRUE );
	}
	
	/**
	 * Dapatkan detail member
	 */
	public function member_me($token, $kode = '') {
		$token 		= (array) \JWT::decode($token, $this->salt);
		$r			= array(
			'type'	=> TRUE,
			'data'	=> array()
		);
		$cari		= $this->db->query("SELECT KODE_ANGGOTA, NAMA_ANGGOTA, ALAMAT_ANGGOTA, TELEPON_ANGGOTA, FOTO_ANGGOTA, INFO_ANGGOTA, VALID_ANGGOTA, JENIS_ANGGOTA FROM anggota WHERE ID_ANGGOTA = '{$token['id']}'", TRUE);
		$r['data']['member_kode']	= $cari->KODE_ANGGOTA;
		$r['data']['member_nama']	= $cari->NAMA_ANGGOTA;
		$r['data']['member_alamat']	= $cari->ALAMAT_ANGGOTA;
		$r['data']['member_telepon']= $cari->TELEPON_ANGGOTA;
		$r['data']['member_foto']	= '/upload/member/' . (empty($cari->FOTO_ANGGOTA) ? 'default.png' : str_replace('.', '_thumb.', $cari->FOTO_ANGGOTA));
		$r['data']['member_info']	= $cari->INFO_ANGGOTA;
		$r['data']['member_valid'] 	= ($cari->VALID_ANGGOTA == '1' ? TRUE : FALSE);
		$r['data']['member_jenis']	= ($cari->JENIS_ANGGOTA == '1' ? 'Reguler' : 'Premium');
		$r['data']['member_me']		= ($kode == $cari->KODE_ANGGOTA);
		
		// apakah memiliki direktori
		$cari		= $this->db->query("SELECT ID_DIREKTORI FROM direktori WHERE PEMILIK_DIREKTORI = '{$token['id']}'");
        if ( ! empty($cari)) {
            $dirs = array();
            foreach ($cari as $val) { $dirs[] = floatval($val->ID_DIREKTORI); }
        }
		$r['data']['member_direktori'] 	= ( ! isset($dirs) ? FALSE : $dirs);
		// apakah memiliki order
		$cari 		= $this->db->query("SELECT COUNT(ID_PENJUALAN) AS HASIL FROM penjualan WHERE ID_ANGGOTA = '{$token['id']}' AND STATUS_PENJUALAN NOT IN('2', '3')", TRUE);
		$r['data']['member_order']		= $cari->HASIL > 0;
		// apakah memiliki pesan tak terbaca
		$cari		= $this->db->query("SELECT COUNT(ID_PESAN) AS HASIL FROM pesan WHERE PENERIMA_PESAN = '{$token['id']}' AND STATUS_PESAN = '1' AND JENIS_PESAN IN('2', '4')", TRUE);
		$r['data']['member_pesan']		= $cari->HASIL > 0;
		return $r;
	}
	
	/**
	 * Simpan profil anggota
	 */
	public function member_profil($token, $iofiles) {
		extract($this->prepare_post(array('nama', 'alamat', 'telepon', 'info', 'pass', 'pass2')));
		$nama	= $this->db->escape_str($nama);
		$alamat	= $this->db->escape_str($alamat);
		$telepon= $this->db->escape_str($telepon);
        $info   = $this->db->escape_str(strip_tags($info));
		// validasi
		if (strlen($nama) < 3) return FALSE;
		if (strlen($alamat) < 5) return FALSE;
		if ($pass != $pass2) return FALSE;
		$token 	= (array) \JWT::decode($token, $this->salt);
		$cari	= $this->db->query("SELECT * FROM anggota WHERE ID_ANGGOTA = '{$token['id']}'", TRUE);
		$upd 	= array();
		if ($cari->NAMA_ANGGOTA != $nama) 		$upd[] = "NAMA_ANGGOTA = '$nama'";
		if ($cari->ALAMAT_ANGGOTA != $alamat) 	$upd[] = "ALAMAT_ANGGOTA = '$alamat'";
		if ($cari->TELEPON_ANGGOTA != $telepon)	$upd[] = "TELEPON_ANGGOTA = '$telepon'";
		if ($cari->INFO_ANGGOTA != $info)	    $upd[] = "INFO_ANGGOTA = '$info'";
		if (strlen($pass) >= 6)					$upd[] = "PASSWORD_ANGGOTA = '" . crypt($pass, $this->salt) . "'";
		if ( ! empty($upd)) {
			$run = $this->db->query("UPDATE anggota SET " . implode(', ', $upd) . " WHERE ID_ANGGOTA = '{$token['id']}'");
		}
		
		if (isset($_FILES['file'])) {
			// foto
			$run = $this->db->query("SELECT FOTO_ANGGOTA FROM anggota WHERE ID_ANGGOTA = '{$token['id']}'", TRUE);
			if ( ! empty($run)) {
				@unlink('upload/member/' . $run->FOTO_ANGGOTA);
				@unlink('upload/member/' . str_replace('.', '_thumb.', $run->FOTO_ANGGOTA));
			}
			$config['upload_path']		= 'upload/member/';
			$config['allowed_types']	= 'jpeg|jpg|png';
			$config['encrypt_name']		= TRUE;
			$config['overwrite']		= TRUE;
            $config['max_size']		    = 1024 * 1024;
			$iofiles->upload_config($config);
			$iofiles->upload('file');
			$filename 					= $iofiles->upload_get_param('file_name');
			// buat thumbnail
			$config						= array();
			$config['source_image']		= 'upload/member/' . $filename;
			$config['new_image']		= 'upload/member/' . str_replace('.', '_thumb.', $filename);
			$config['maintain_ratio']	= TRUE;
			$config['width']			= 200;
			$config['height']			= 200;
			$iofiles->image_config($config);
			$iofiles->image_resize();
			// update tabel
			$upd = $this->db->query("UPDATE anggota SET FOTO_ANGGOTA = '$filename' WHERE ID_ANGGOTA = '{$token['id']}'");
		}
		
		return array( 'type' => TRUE);
	}
}

