<?php
/**
 * Admin Main Model
 */
namespace Model;

set_time_limit(0);

class AdminmainModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function report($type) {
		$r 			= array();
		if($type == 'total') {
			$this->db->query("START TRANSACTION");
			$run	= $this->db->query("SELECT COUNT(ID_DIREKTORI) AS TOTAL FROM direktori WHERE STATUS_DIREKTORI != '0'", TRUE);
			$r['direktori']			= $run->TOTAL;
			$run	= $this->db->query("SELECT COUNT(ID_ADMIN) AS TOTAL FROM admin WHERE STATUS_ADMIN != '0'", TRUE);
			$r['admin']				= $run->TOTAL;
			$run 	= $this->db->query("SELECT COUNT(ID_ANGGOTA) AS TOTAL FROM anggota WHERE STATUS_ANGGOTA != '0' AND JENIS_ANGGOTA = '2'", TRUE);
			$r['anggotapremium']	= $run->TOTAL;
			$run 	= $this->db->query("SELECT COUNT(ID_ANGGOTA) AS TOTAL FROM anggota WHERE STATUS_ANGGOTA != '0' AND JENIS_ANGGOTA = '1'", TRUE);
			$r['anggotareguler']	= $run->TOTAL;
			$run 	= $this->db->query("SELECT COUNT(ID_PRODUKUTAMA) AS TOTAL FROM produkutama WHERE STATUS_PRODUKUTAMA != '0'", TRUE);
			$r['produk']			= $run->TOTAL;
			$run 	= $this->db->query("SELECT COUNT(ID_PENJUALAN) AS TOTAL FROM penjualan WHERE STATUS_PENJUALAN = '5'", TRUE);
			$r['penjualan']			= $run->TOTAL;
			$run 	= $this->db->query("SELECT COUNT(ID_POSTANGGOTA) AS TOTAL FROM postanggota WHERE STATUS_POSTANGGOTA != '0' AND TIPE_POSTANGGOTA = '1'", TRUE);
			$r['postjual']			= $run->TOTAL;
			$run 	= $this->db->query("SELECT COUNT(ID_POSTANGGOTA) AS TOTAL FROM postanggota WHERE STATUS_POSTANGGOTA != '0' AND TIPE_POSTANGGOTA = '2'", TRUE);
			$r['postbeli']			= $run->TOTAL;
			$this->db->query("COMMIT");
		}
		
		return array(
			'type' 	=> TRUE,
			$type	=> $r
		);
	}
	
	public function show_admin($token) {
		extract($token);
		extract($this->prepare_get(array('cpage', 'numpage', 'query', 'order', 'sort', 'num', 'status')));
		$r 	= array();
		if ($level != '1') return FALSE;
		
		$cpage	= filter_var($cpage, FILTER_SANITIZE_NUMBER_INT);
		$num	= filter_var($num, FILTER_SANITIZE_NUMBER_INT);
		$query	= $this->db->escape_str($query);
		$sort	= ($sort == 'asc' ? 'ASC' : 'DESC');
		if ( ! in_array($order, array('nama', 'email')))
		$order	= 'nama';
		if ( ! in_array($status, array('', '1', '2'))) 	$status = '';
		
		$where		= array();
		$kolom		= 'NAMA_ADMIN';
		$where[]	= "LEVEL_ADMIN = '2'";
		$where[]	= "STATUS_ADMIN != '0'";
		if ( ! empty($query)) {
			if ($order == 'nama') {
				$kolom		= 'NAMA_ADMIN';
				$where[] 	= "$kolom LIKE '%{$query}%'";
			}
			if ($order == 'email') {
				$kolom		= 'EMAIL_ADMIN';
				$where[] 	= "$kolom LIKE '%{$query}%'";
			}
		}
		if ( ! empty($status))	$where[] = "STATUS_ADMIN = '$status'";
		$run 	= $this->db->query("SELECT COUNT(ID_ADMIN) AS HASIL FROM admin" . ( ! empty($where) ? " WHERE " . implode(" AND ", $where) : ''), TRUE);
		$total	= $run->HASIL;
		$numpg 	= ceil($total / $num);
		$start	= $cpage * $num;
		
		// cari data
		$run	= $this->db->query("SELECT * FROM admin" .( ! empty($where) ? " WHERE " . implode(" AND ", $where) : '') . " ORDER BY $kolom $sort LIMIT $start, $num");
		$path	= 'upload/member/';
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$r[] = array(
					'kode'		=> $val->ID_ADMIN,
					'nama'		=> $val->NAMA_ADMIN,
					'email'		=> $val->EMAIL_ADMIN,
					'status'	=> ($val->STATUS_ADMIN == '1' ? 'Aktif' : 'Nonaktif'),
					'foto'		=> (empty($val->FOTO_ADMIN) ? $path . 'default.png' : $path . str_replace('.', '_thumb.', $val->FOTO_ADMIN))
				);
			}
		}
		
		return array(
			'type' 		=> TRUE,
			'numpage'	=> $numpg,
			'admin'		=> $r
		);
	}
	
	public function delete_admin($id, $token) {
		if ($token['level'] != '1') return FALSE;
		
		$id 	= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$del 	= $this->db->query("UPDATE admin SET STATUS_ADMIN = '0' WHERE ID_ADMIN = '$id'");
		return array('type' => TRUE);
	}
	
	public function show_message($token) {
		extract($token);
		extract($this->prepare_get(array('view')));
		
		$where		= array();
		// jenisnya 1 atau 3
		$where[]	= "(JENIS_PESAN = '1' OR JENIS_PESAN = '3')";
		$where[] 	= "STATUS_PESAN != '0'";
		$where[]	= "PENERIMA_PESAN = '$id'";
		
		$return		= array();
		$unread		= 0;
		$run		= $this->db->query("SELECT * FROM pesan WHERE " . implode(' AND ', $where) ." ORDER BY TANGGAL_PESAN DESC LIMIT 0, 7");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$waktu = round((time() - datedb_to_tanggal($val->TANGGAL_PESAN, 'U')) / 60 );
				$swaktu = $waktu . ' menit';
				if ($waktu >= 60) $swaktu = floor($waktu / 60) . ' jam ' . ($waktu % 60) . ' menit';
				if ($waktu > (24 * 60)) $swaktu = datedb_to_tanggal($val->TANGGAL_PESAN, 'd M Y H:i');
				
				if ($val->STATUS_PESAN == '1') $unread += 1;
				// pengirim
				$foto = $nama = '';
				if ($val->JENIS_PESAN == '1') {
					$sender	= $this->db->query("SELECT NAMA_ADMIN, FOTO_ADMIN FROM admin WHERE ID_ADMIN = '" . $val->PENGIRIM_PESAN . "'", TRUE);
					$foto	= 'upload/member/' . (empty($sender->FOTO_ADMIN) ? 'default.png' : $sender->FOTO_ADMIN);
					$nama	= $sender->NAMA_ADMIN;
					$tipe	= 'Administrator';
				}
				if ($val->JENIS_PESAN == '3') {
					$sender	= $this->db->query("SELECT NAMA_ANGGOTA, FOTO_ANGGOTA FROM anggota WHERE ID_ANGGOTA = '" . $val->PENGIRIM_PESAN . "'", TRUE);
					$foto	= 'upload/member/' . (empty($sender->FOTO_ANGGOTA) ? 'default.png' : $sender->FOTO_ANGGOTA);
					$nama	= $sender->NAMA_ANGGOTA;
					$tipe	= 'Anggota';
				}
				
				$return[]	= array(
					'id'		=> $val->ID_PESAN,
					'tanggal'	=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd/m/Y H:i'),
					'isi'		=> nl2br(html_entity_decode(str_replace('(-_____-)', '', $val->ISI_PESAN)), FALSE),
					'status'	=> ($val->STATUS_PESAN == '1' ? 'Baru' : 'Terbaca'),
					'waktu'		=> $swaktu,
					'foto'		=> $foto,
					'nama'		=> $nama,
					'tipe'		=> $tipe
				);
			}
		}
		$result			= array();
		$result['type']	= TRUE;
		$result['pesan']= $return;
		if ($view == 'newest') $result['baru'] = $unread;
		return $result;
	}
	
	private function is_user_exist($id, $tipe, $user) {
		foreach ($user as $val) {
			if ($val['id'] == $id AND $val['tipe'] == $tipe) return TRUE;
		}
		return FALSE;
	}
	public function show_message_list($token) {
		extract($token);
		$r = array();
		$this->db->query("START TRANSACTION");
		if ($user == 'admin') {
			// cari di pesan tipe pesan 1,2 atau 3, 5
			$run = $this->db->query("SELECT MAX(a.TANGGAL_PESAN) AS TANGGAL_PESAN, b.ID_ADMIN, b.NAMA_ADMIN, b.FOTO_ADMIN FROM pesan a, admin b WHERE a.PENERIMA_PESAN = b.ID_ADMIN AND PENGIRIM_PESAN = '$id' AND JENIS_PESAN = '1' GROUP BY a.PENERIMA_PESAN ORDER BY a.TANGGAL_PESAN DESC");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					if ( ! $this->is_user_exist($val->ID_ADMIN, 'Administrator', $r)) {
						$r[] = array(
							'id'	=> $val->ID_ADMIN,
							'nama'	=> $val->NAMA_ADMIN,
							'tipe'	=> 'Administrator',
							'foto' 	=> 'upload/member/' . (empty($val->FOTO_ADMIN) ? 'default.png' : $val->FOTO_ADMIN),
							'tanggal'=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
					}
				}
			}
			$run = $this->db->query("SELECT MAX(a.TANGGAL_PESAN) AS TANGGAL_PESAN, b.ID_ADMIN, b.NAMA_ADMIN, b.FOTO_ADMIN FROM pesan a, admin b WHERE a.PENGIRIM_PESAN = b.ID_ADMIN AND PENERIMA_PESAN = '$id' AND JENIS_PESAN = '1' GROUP BY a.PENGIRIM_PESAN ORDER BY a.TANGGAL_PESAN DESC");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					if ( ! $this->is_user_exist($val->ID_ADMIN, 'Administrator', $r)) {
						$r[] = array(
							'id' 	=> $val->ID_ADMIN,
							'nama'	=> $val->NAMA_ADMIN,
							'tipe'	=> 'Administrator',
							'foto'	=> 'upload/member/' . (empty($val->FOTO_ADMIN) ? 'default.png' : $val->FOTO_ADMIN),
							'tanggal'=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
					}
				}
			}
			$run = $this->db->query("SELECT MAX(a.TANGGAL_PESAN) AS TANGGAL_PESAN, b.KODE_ANGGOTA, b.NAMA_ANGGOTA, b.VALID_ANGGOTA, b.FOTO_ANGGOTA FROM pesan a, anggota b WHERE a.PENERIMA_PESAN = b.ID_ANGGOTA AND PENGIRIM_PESAN = '$id' AND JENIS_PESAN = '2' GROUP BY a.PENERIMA_PESAN ORDER BY a.TANGGAL_PESAN DESC");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					if ( ! $this->is_user_exist($val->KODE_ANGGOTA, 'Anggota', $r)) {
						$r[] = array(
							'id'	=> $val->KODE_ANGGOTA,
							'nama'	=> $val->NAMA_ANGGOTA,
							'tipe'	=> 'Anggota',
							'valid'	=> $val->VALID_ANGGOTA,
							'foto'	=> 'upload/member/' . (empty($val->FOTO_ANGGOTA) ? 'default.png' : $val->FOTO_ANGGOTA),
							'tanggal'=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
					}
				}
			}
			$run = $this->db->query("SELECT MAX(a.TANGGAL_PESAN) AS TANGGAL_PESAN, b.KODE_ANGGOTA, b.NAMA_ANGGOTA, b.VALID_ANGGOTA, b.FOTO_ANGGOTA FROM pesan a, anggota b WHERE a.PENGIRIM_PESAN = b.ID_ANGGOTA AND PENERIMA_PESAN = '$id' AND JENIS_PESAN IN('3', '5') GROUP BY a.PENGIRIM_PESAN ORDER BY a.TANGGAL_PESAN DESC");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					if ( ! $this->is_user_exist($val->KODE_ANGGOTA, 'Anggota', $r)) {
						$r[] = array(
							'id'	=> $val->KODE_ANGGOTA,
							'nama'	=> $val->NAMA_ANGGOTA,
							'tipe'	=> 'Anggota',
							'valid'	=> $val->VALID_ANGGOTA,
							'foto'	=> 'upload/member/' . (empty($val->FOTO_ANGGOTA) ? 'default.png' : $val->FOTO_ANGGOTA),
							'tanggal'=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
					}
				}
			}
			
		}
		
		if ($user == 'member') {
			// cari di pesan tipe pesan 2,3 atau 4
			$run = $this->db->query("SELECT MAX(a.TANGGAL_PESAN) AS TANGGAL_PESAN, b.ID_ADMIN, b.NAMA_ADMIN, b.FOTO_ADMIN FROM pesan a, admin b WHERE a.PENGIRIM_PESAN = b.ID_ADMIN AND PENERIMA_PESAN = '$id' AND JENIS_PESAN = '2' GROUP BY a.PENGIRIM_PESAN ORDER BY a.TANGGAL_PESAN DESC");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					if ( ! $this->is_user_exist($val->ID_ADMIN, 'Administrator', $r)) {
						$r[] = array(
							'id' 	=> $val->ID_ADMIN,
							'nama'	=> $val->NAMA_ADMIN,
							'tipe'	=> 'Administrator',
							'foto'	=> 'upload/member/' . (empty($val->FOTO_ADMIN) ? 'default.png' : $val->FOTO_ADMIN),
							'tanggal'=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
					}
				}
			}
			$run = $this->db->query("SELECT MAX(a.TANGGAL_PESAN) AS TANGGAL_PESAN, b.ID_ADMIN, b.NAMA_ADMIN, b.FOTO_ADMIN FROM pesan a, admin b WHERE a.PENGIRIM_PESAN = '$id' AND PENERIMA_PESAN = b.ID_ADMIN AND JENIS_PESAN = '3' GROUP BY a.PENERIMA_PESAN ORDER BY a.TANGGAL_PESAN DESC");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					if ( ! $this->is_user_exist($val->ID_ADMIN, 'Administrator', $r)) {
						$r[] = array(
							'id' 	=> $val->ID_ADMIN,
							'nama'	=> $val->NAMA_ADMIN,
							'tipe'	=> 'Administrator',
							'foto'	=> 'upload/member/' . (empty($val->FOTO_ADMIN) ? 'default.png' : $val->FOTO_ADMIN),
							'tanggal'=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
					}
				}
			}
			$run = $this->db->query("SELECT MAX(a.TANGGAL_PESAN) AS TANGGAL_PESAN, b.KODE_ANGGOTA, b.NAMA_ANGGOTA, b.VALID_ANGGOTA, b.FOTO_ANGGOTA FROM pesan a, anggota b WHERE a.PENERIMA_PESAN = b.ID_ANGGOTA AND PENGIRIM_PESAN = '$id' AND JENIS_PESAN = '4' GROUP BY a.PENERIMA_PESAN ORDER BY a.TANGGAL_PESAN DESC");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					if ( ! $this->is_user_exist($val->KODE_ANGGOTA, 'Anggota', $r)) {
						$r[] = array(
							'id'	=> $val->KODE_ANGGOTA,
							'nama'	=> $val->NAMA_ANGGOTA,
							'tipe'	=> 'Anggota',
							'valid'	=> $val->VALID_ANGGOTA,
							'foto'	=> 'upload/member/' . (empty($val->FOTO_ANGGOTA) ? 'default.png' : $val->FOTO_ANGGOTA),
							'tanggal'=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
					}
				}
			}
			$run = $this->db->query("SELECT MAX(a.TANGGAL_PESAN) AS TANGGAL_PESAN, b.KODE_ANGGOTA, b.NAMA_ANGGOTA, b.VALID_ANGGOTA, b.FOTO_ANGGOTA FROM pesan a, anggota b WHERE a.PENERIMA_PESAN = '$id' AND PENGIRIM_PESAN = b.ID_ANGGOTA AND JENIS_PESAN = '4' GROUP BY a.PENGIRIM_PESAN ORDER BY a.TANGGAL_PESAN DESC");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					if ( ! $this->is_user_exist($val->KODE_ANGGOTA, 'Anggota', $r)) {
						$r[] = array(
							'id'	=> $val->KODE_ANGGOTA,
							'nama'	=> $val->NAMA_ANGGOTA,
							'tipe'	=> 'Anggota',
							'valid'	=> $val->VALID_ANGGOTA,
							'foto'	=> 'upload/member/' . (empty($val->FOTO_ANGGOTA) ? 'default.png' : $val->FOTO_ANGGOTA),
							'tanggal'=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
					}
				}
			}
		}
		$this->db->query("COMMIT");
		return array(
			'type'		=> TRUE,
			'daftar' 	=> $r
		);
	}
	
	public function show_message_data($token) {
		extract($token);
		extract($this->prepare_get(array('kode', 'tipe')));
		if ($tipe != 'Administrator' && $tipe != 'Anggota') return FALSE;
		if ($tipe == 'Administrator') $kode = filter_var($kode, FILTER_SANITIZE_NUMBER_INT);
		else $kode 	= $this->db->escape_str($kode);
		$r = array();
		$this->db->query("START TRANSACTION");
		$unread = array();
		if ($user == 'admin') {
			if ($tipe == 'Administrator') {
				$you = $this->db->query("SELECT ID_ADMIN, NAMA_ADMIN, FOTO_ADMIN FROM admin WHERE ID_ADMIN = '$kode'", TRUE);
				if (empty($you)) return FALSE;
				$run = $this->db->query("SELECT * FROM pesan WHERE JENIS_PESAN = '1' AND ((PENERIMA_PESAN = '$id' AND PENGIRIM_PESAN = '$kode') OR (PENERIMA_PESAN = '$kode' AND PENGIRIM_PESAN = '$id')) ORDER BY TANGGAL_PESAN DESC LIMIT 0, 50");
				if ( ! empty($run)) {
					foreach ($run as $val) {
						if ($val->PENGIRIM_PESAN == $id) $from = 'me';
						else $from = $you->NAMA_ADMIN;
						$r[] = array(
							'f'	=> $from,
							'i'	=>  nl2br(html_entity_decode(str_replace('(-_____-)', '', $val->ISI_PESAN)), FALSE),
							't'	=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
						if ($val->STATUS_PESAN == '1' && $from != 'me' && ! in_array($val->ID_PESAN, $unread)) $unread[] = $val->ID_PESAN; 
					}
				}
			}
			if ($tipe == 'Anggota') {
				$you = $this->db->query("SELECT ID_ANGGOTA, NAMA_ANGGOTA, FOTO_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode'", TRUE);
				if (empty($you)) return FALSE;
				//$where[] = "(JENIS_PESAN = '2')";
				$run = $this->db->query("SELECT * FROM pesan WHERE (JENIS_PESAN = '2' AND PENERIMA_PESAN = '{$you->ID_ANGGOTA}' AND PENGIRIM_PESAN = '$id') OR (JENIS_PESAN = '3' AND PENERIMA_PESAN = '$id' AND PENGIRIM_PESAN = '{$you->ID_ANGGOTA}') OR (JENIS_PESAN = '5' AND PENERIMA_PESAN = '$id' AND PENGIRIM_PESAN = '{$you->ID_ANGGOTA}') ORDER BY TANGGAL_PESAN DESC LIMIT 0, 50");
				if ( ! empty($run)) {
					foreach ($run as $val) {
						if ($val->JENIS_PESAN == '2') $from = 'me'; 
						else $from = $you->NAMA_ANGGOTA;
						$r[] = array(
							'f'	=> $from,
							'i'	=> nl2br(html_entity_decode(str_replace('(-_____-)', '', $val->ISI_PESAN)), FALSE),
							't'	=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
						if ($val->STATUS_PESAN == '1' && $from != 'me' && ! in_array($val->ID_PESAN, $unread)) $unread[] = $val->ID_PESAN;
					}
				}
			}
		}
		if ($user == 'member') {
			if ($tipe == 'Administrator') {
				$you = $this->db->query("SELECT ID_ADMIN, NAMA_ADMIN, FOTO_ADMIN FROM admin WHERE ID_ADMIN = '$kode'", TRUE);
				$where[] = "(JENIS_PESAN = '2' AND PENGIRIM_PESAN = '$kode' AND PENERIMA_PESAN = '$id')";
				$where[] = "(JENIS_PESAN = '3' AND PENGIRIM_PESAN = '$id' AND PENERIMA_PESAN = '$kode')";
				$run = $this->db->query("SELECT * FROM pesan WHERE " . implode(" OR ", $where) . " ORDER BY TANGGAL_PESAN DESC LIMIT 0, 50");
				if ( ! empty($run)) {
					foreach ($run as $val) {
						if ($val->PENGIRIM_PESAN == $id) $from = 'me';
						else $from = $you->NAMA_ADMIN;
						$r[] = array(
							'f'	=> $from,
							'i'	=>  nl2br(html_entity_decode(str_replace('(-_____-)', '', $val->ISI_PESAN)), FALSE),
							't'	=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
						if ($val->STATUS_PESAN == '1' && $from != 'me' && ! in_array($val->ID_PESAN, $unread)) $unread[] = $val->ID_PESAN; 
					}
				}
			}
			if ($tipe == 'Anggota') {
				$you = $this->db->query("SELECT ID_ANGGOTA, NAMA_ANGGOTA, FOTO_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode'", TRUE);
				$where[] = "(PENERIMA_PESAN = '{$you->ID_ANGGOTA}' AND PENGIRIM_PESAN = '$id')";
				$where[] = "(PENERIMA_PESAN = '$id' AND PENGIRIM_PESAN = '{$you->ID_ANGGOTA}')";
				$run = $this->db->query("SELECT * FROM pesan WHERE JENIS_PESAN = '4' AND (" . implode(" OR ", $where) . ") ORDER BY TANGGAL_PESAN DESC LIMIT 0, 50");
				if ( ! empty($run)) {
					foreach ($run as $val) {
						if ($val->PENGIRIM_PESAN == $id) $from = 'me';
						else $from = $you->NAMA_ANGGOTA;
						$r[] = array(
							'f'	=> $from,
							'i'	=> nl2br(html_entity_decode(str_replace('(-_____-)', '', $val->ISI_PESAN)), FALSE),
							't'	=> datedb_to_tanggal($val->TANGGAL_PESAN, 'd F Y H:i')
						);
						if ($val->STATUS_PESAN == '1' && $from != 'me' && ! in_array($val->ID_PESAN, $unread)) $unread[] = $val->ID_PESAN;
					}
				}
			}
		}
		// update status terbaca
		if ( ! empty($unread)) {
			$upd = $this->db->query("UPDATE pesan SET STATUS_PESAN = '2' WHERE ID_PESAN IN(" . implode(',', $unread) . ")");
		}
		//$return = array();
		//for ($i = count($r) - 1; $i >= 0; $i--) $return[] = $r[$i];
		$this->db->query("COMMIT");
		return array(
			'type'		=> TRUE,
			'pesan' 	=> $r
		);
	}
	
	public function save_message($token) {
		// pengirim berasal dari token
		extract($token);
		extract($this->prepare_post(array('forCode', 'message', 'type', 'status', 'ids')));
		// pesan baru
		if (empty($status)) {
			$forCode 	= $this->db->escape_str($forCode);
			$message	= $this->db->escape_str(htmlentities($message));
			if ($type == 'administrator') $type = 'admin';
			$type		= ($type == 'admin' ? 'admin' : 'anggota');
			$posttype	= 0;
			if (strlen($message) < 1) return FALSE;
			switch ($user) {
				case 'admin':
					if ($type == 'admin') 	$posttype = 1;
					if ($type == 'anggota') $posttype = 2;
					break;
				case 'member':
					if ($type == 'admin') 	$posttype = 3;
					if ($type == 'anggota') $posttype = 4;
					break;
			}
			if (empty($posttype)) return FALSE;
			$idrecpt	= filter_var($forCode, FILTER_SANITIZE_NUMBER_INT);
			if ($type == 'anggota') {
				$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$forCode'", TRUE);
				$idrecpt= $run->ID_ANGGOTA;
			}
			// masukkan ke pesan
			$ins	= $this->db->query("INSERT pesan VALUES(0, '$id', '$idrecpt', NOW(), '$message', '1', '$posttype')");
		}
		
		// set status
		if ( ! empty($status)) {
			if ($status != 2) return;
			$id		= explode(',', $ids);
			foreach ($id as $key => $val) $id[$key]	= "'$val'";
			$id		= implode(',', $id);
			$upd	= $this->db->query("UPDATE pesan SET STATUS_PESAN = '2' WHERE ID_PESAN IN($id)");
		}
		return array( 'type' => TRUE );
	}
	
	public function get_data_table($table) {
		extract($this->prepare_get(array('cpage')));
		$cpage	= intval($cpage);
		$r 		= array();
		$where	= array();
		switch($table) {
			case 'kota':
				$numdt = 75;
				$tabel = 'kota';
				$where[] = "STATUS_KOTA = '1'";
				break;
			case 'ongkir':
				$numdt = 25;
				$tabel = 'biayakurir';
				break;
		}
		$utabel	= strtoupper($tabel);
		$run	= $this->db->query("SELECT COUNT(ID_{$utabel}) AS HASIL FROM $tabel" . ( ! empty($where) ? " WHERE " . implode(" AND ", $where) : ''), TRUE);
		$numpg	= ceil($run->HASIL / $numdt);
		$start	= $cpage * $numdt;
		
		switch ($table) {
			case 'kota':
				$run = $this->db->query("SELECT * FROM kota WHERE STATUS_KOTA = '1' ORDER BY NAMA_KOTA LIMIT $start, $numdt");
				if ( ! empty($run)) {
					foreach ($run as $val) {
						$r[] = array(
							'id'	=> $val->ID_KOTA,
							'nama'	=> $val->NAMA_KOTA
						);
					}
				}
				break;
			case 'ongkir':
				$run 	= $this->db->query("SELECT a.ID_BIAYAKURIR, a.BIAYA_BIAYAKURIR, b.ID_KOTA, b.NAMA_KOTA, c.ID_KURIR, c.NAMA_KURIR FROM biayakurir a, kota b, kurir c WHERE a.ID_KOTA = b.ID_KOTA AND a.ID_KURIR = c.ID_KURIR ORDER BY c.NAMA_KURIR, b.NAMA_KOTA");
				if ( ! empty($run)) {
					foreach ($run as $val) {
						$r[] = array(
							'i'	=> $val->ID_BIAYAKURIR,
							'o'	=> $val->NAMA_KOTA,
							'oi'=> $val->ID_KOTA,
							'b'	=> number_format($val->BIAYA_BIAYAKURIR, 0, ',', '.'),
							'k'	=> $val->NAMA_KURIR,
							'ki'=> $val->ID_KURIR
						);
					}
				}
				break;
		}
		return array(
			$table 	=> $r, 'numpage' => $numpg, 'type' => TRUE
		);
	}
}