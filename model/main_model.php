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
		$cari 		= $this->db->query("SELECT ID_ADMIN, LEVEL_ADMIN FROM admin WHERE EMAIL_ADMIN = '$email' AND PASSWORD_ADMIN = '$password'", TRUE);
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
	 * Validate token
	 * Periksa adakah token, jika ada dan tidak expired = perpanjang, 
	 * jika tidak ada = invalid, jika ada tapi expired = invalid
	 */
	public function validate_token() {
		$header		= apache_request_headers();
		if ( ! isset($header['Authorization'])) return FALSE;		
		
		list($a, $token) = explode(' ', $header['Authorization']);
		$token 		= (array) \JWT::decode($token, $this->salt);
		$data 		= array('id', 'email', 'tokenid', 'user', 'level', 'source');
		foreach ($data as $v) {
			if ( ! isset($token[$v])) return FALSE;
		}
		extract($token);
		
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
	public function save_profil($token, $iofiles) {
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
			$config['width']			= 120;
			$config['height']			= 120;
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
	public function save_admin($token, $kode = '') {
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
	public function get_data_table() {
		extract($this->prepare_get(array('t')));
		$tabel 	= explode(',', $t);
		$stabel	= array();
		foreach ($tabel as $val) {
			switch ($val) {
				case 'kota': 
					$stabel[]	= array('kota', 'kota'); break;
				case 'kategori_direktori': 
					$stabel[] 	= array('katdir', 'kategori_direktori'); break;
				case 'kategori_produk':	
					$stabel[] 	= array('katproduk', 'kategori_produk'); break;
				default: continue;
			}
		}
		$r 		= array();
		
		$this->db->query("START TRANSACTION");
		foreach ($stabel as $val) {
			$t 		= $val[0];
			$tu		= strtoupper($t);
			$l 		= $val[1];
			$run 	= $this->db->query("SELECT * FROM $t WHERE STATUS_$tu != '0' ORDER  BY NAMA_$tu", FALSE, FALSE);
			if ( ! empty($run)) {
				foreach ($run as $v) {
					$r[$l][]	= array(
						'id'	=> $v['ID_' . $tu],
						'nama'	=> $v['NAMA_' . $tu]
					);
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
		extract($this->prepare_post(array('nama')));
		
		switch ($t) {
			case 'kota': $tabel = 'kota'; break;
			case 'kategori_direktori': $tabel = 'katdir'; break;
			case 'kategori_produk':	$tabel = 'katproduk'; break;
			default: return FALSE;
		}
		$id = intval($id);
		$nama = $this->db->escape_str(ucwords($nama));
		if (empty($id)) {
			if ($tabel == 'kota')
				$ins = $this->db->query("INSERT INTO $tabel VALUES(0, '" . strtoupper(substr($nama, 0, 3)) . "', '$nama', '1')");
			else
				$ins = $this->db->query("INSERT INTO $tabel VALUES(0, '$nama', '1')");
		} else {
			$upd = $this->db->query("UPDATE $tabel SET NAMA_" . strtoupper($tabel) . " = '$nama' WHERE ID_" . strtoupper($tabel) . " = '$id'");
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
			default: return FALSE;
		}
		$id 	= intval($id);
		$del 	= $this->db->query("UPDATE $tabel SET STATUS_" . strtoupper($tabel) . " = '0' WHERE ID_" . strtoupper($tabel) . " = '$id'");
		return array('type' => TRUE);
	}
}

