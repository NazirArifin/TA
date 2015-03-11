<?php
/**
 * Anggota Model
 */
namespace Model;

set_time_limit(0);

class AdminanggotaModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	private function return_error() {
		return array( 'type' => FALSE );
	}
	
	public function show() {
		extract($this->prepare_get(array('cpage', 'numpage', 'query', 'order', 'sort', 'num', 'type', 'status', 'date')));
		$cpage 	= intval($cpage);
		$num	= intval($num);
		$query	= $this->db->escape_str($query);
		$sort	= ($sort == 'asc' ? 'ASC' : 'DESC');
		if ( ! in_array($order, array('nama', 'daftar', 'email'))) $order 	= 'daftar';
		if ( ! in_array($type, array('', '1', '2'))) 	$type = '';
		if ( ! in_array($status, array('', '1', '2'))) 	$status = '';
		
		$where		= array();
		$kolom		= 'NAMA_ANGGOTA';
		$where[]	= "JENIS_ANGGOTA != '0'";
		$where[]	= "STATUS_ANGGOTA != '0'";
		if ( ! empty($query)) {
			if ($order == 'nama') {
				$kolom		= 'NAMA_ANGGOTA';
				$where[] 	= "$kolom LIKE '%{$query}%'";
			}
			if ($order == 'email') {
				$kolom		= 'EMAIL_ANGGOTA';
				$where[] 	= "$kolom LIKE '%{$query}%'";
			}
		}
		if ( ! empty($date)) {
			$kolom		= 'DAFTAR_ANGGOTA';
			list($d, $m, $y) = explode('/', $date);
			$where[] 	= "DATE($kolom) = '". $y . '-' . $m . '-' . $d ."'";
		}
		if ( ! empty($type)) 	$where[] = "JENIS_ANGGOTA = '$type'";
		if ( ! empty($status))	$where[] = "STATUS_ANGGOTA = '$status'";
		
		// total halaman
		$run 	= $this->db->query("SELECT COUNT(ID_ANGGOTA) AS HASIL FROM anggota" . ( ! empty($where) ? " WHERE " . implode(" AND ", $where) : ''), TRUE);
		$total	= $run->HASIL;
		$numpg 	= ceil($total / $num);
		$start	= $cpage * $num;
				
		// cari data
		$r		= array();
		$run	= $this->db->query("SELECT * FROM anggota" .( ! empty($where) ? " WHERE " . implode(" AND ", $where) : '') . " ORDER BY $kolom $sort LIMIT $start, $num");
		$path	= 'upload/member/';
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$post 	= $this->db->query("SELECT COUNT(ID_POSTANGGOTA) AS POST FROM postanggota WHERE ID_ANGGOTA = '{$val->ID_ANGGOTA}' AND STATUS_POSTANGGOTA = '1'", TRUE);
				$review	= $this->db->query("SELECT COUNT(ID_REVIEWPRODUK) AS REVIEW FROM reviewproduk WHERE ID_ANGGOTA = '{$val->ID_ANGGOTA}' AND STATUS_REVIEWPRODUK = '2'", TRUE);
				$r[] = array(
					'kode'		=> $val->KODE_ANGGOTA,
					'nama'		=> $val->NAMA_ANGGOTA,
					'tipe'		=> ($val->JENIS_ANGGOTA == '1' ? 'Reguler' : 'Premium'),
					'valid'		=> ($val->VALID_ANGGOTA == '1' ? TRUE : FALSE),
					'daftar' 	=> datedb_to_tanggal($val->DAFTAR_ANGGOTA, 'd/m/Y H:i'),
					'email'		=> $val->EMAIL_ANGGOTA,
					'status'	=> ($val->STATUS_ANGGOTA == '1' ? 'Aktif' : 'Nonaktif'),
					'foto'		=> (empty($val->FOTO_ANGGOTA) ? $path . 'default.png' : $path . str_replace('.', '_thumb.', $val->FOTO_ANGGOTA)),
					'post'		=> $post->POST,
					'review'	=> $review->REVIEW
				);
			}
		}
		
		return array(
			'type'		=> TRUE,
			'anggota'	=> $r,
			'numpage'	=> $numpg
		);
	}
	
	public function detail($kode) {
		
	}
	
	public function update($kode) {
		extract($this->prepare_post(array('status', 'tipe', 'valid')));
		$kode 	= $this->db->escape_str($kode);
		$run 	= $this->db->query("SELECT COUNT(ID_ANGGOTA) AS HASIL FROM anggota WHERE KODE_ANGGOTA = '$kode'", TRUE);
		if (empty($run->HASIL)) return FALSE;
		
		if ( ! empty($status)) {
			$kolom	= 'STATUS_ANGGOTA';
			$value	= ($status == 1 ? 1 : 2);
		}
		if ( ! empty($tipe)) {
			$kolom 	= 'JENIS_ANGGOTA';
			$value	= ($tipe == 1 ? 1 : 2);	
		}
		if ( ! empty($valid)) {
			$kolom 	= 'VALID_ANGGOTA';
			$value	= 1;
		}
		$upd 	= $this->db->query("UPDATE anggota SET $kolom = '$value' WHERE KODE_ANGGOTA = '$kode'");
		return array( 'type' => TRUE );
	}
	
	public function delete($kode) {
		$kode	= $this->db->escape_str($kode);
		$run 	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode'", TRUE);
		if (empty($run)) return FALSE;
		
		$this->db->query("START TRANSACTION");
		$this->db->query("UPDATE reviewproduk SET ID_ANGGOTA = '1' WHERE ID_ANGGOTA = '{$run->ID_ANGGOTA}'");
		$this->db->query("UPDATE postanggota SET ID_ANGGOTA = '1' WHERE ID_ANGGOTA = '{$run->ID_ANGGOTA}'");
		$this->db->query("UPDATE komentar SET ID_ANGGOTA = '1' WHERE ID_ANGGOTA = '{$run->ID_ANGGOTA}'");
		$this->db->query("UPDATE caridirektori SET ID_ANGGOTA = '1' WHERE ID_ANGGOTA = '{$run->ID_ANGGOTA}'");
		$this->db->query("UPDATE cariproduk SET ID_ANGGOTA = '1' WHERE ID_ANGGOTA = '{$run->ID_ANGGOTA}'");
		$this->db->query("UPDATE testimoni SET ID_ANGGOTA = '1' WHERE ID_ANGGOTA = '{$run->ID_ANGGOTA}'");
		$this->db->query("UPDATE titipbeli SET ID_ANGGOTA = '1' WHERE ID_ANGGOTA = '{$run->ID_ANGGOTA}'");
		$this->db->query("UPDATE anggota SET STATUS_ANGGOTA = '0' WHERE ID_ANGGOTA = '{$run->ID_ANGGOTA}'");
		$this->db->query("COMMIT");
		
		return array( 'type' => TRUE );
	}
}