<?php
/**
 * Review Model
 */
namespace Model;

class ReviewModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_review($produk = '', $member = '') {
		if (empty($produk)) extract($this->prepare_get(array('produk')));
		if (empty($member)) extract($this->prepare_get(array('member')));
		
		// berdasarkan produk
		if ( ! empty($produk)) {
			$id		= filter_var($produk, FILTER_SANITIZE_NUMBER_INT);
			$r 	 	= array();
			// apakah produk ini milik direktori member
			$run	= $this->db->query("SELECT COUNT(a.ID_ANGGOTA) AS HASIL FROM anggota a, direktori b, produk c WHERE c.ID_PRODUK = '$id' AND c.ID_DIREKTORI = b.ID_DIREKTORI AND b.PEMILIK_DIREKTORI = a.ID_ANGGOTA AND a.KODE_ANGGOTA = '$member'", TRUE);
			$owner	= $run->HASIL > 0;
			
			$run	= $this->db->query("SELECT a.ID_REVIEWPRODUK, a.ISI_REVIEWPRODUK, a.TANGGAL_REVIEWPRODUK, a.STATUS_REVIEWPRODUK, b.KODE_ANGGOTA, b.NAMA_ANGGOTA, b.FOTO_ANGGOTA, b.VALID_ANGGOTA FROM reviewproduk a, anggota b WHERE a.ID_ANGGOTA = b.ID_ANGGOTA AND a.ID_PRODUK = '$id' AND (STATUS_REVIEWPRODUK = '1' OR STATUS_REVIEWPRODUK = '2')");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					$r[]	= array(
						'id'		=> $val->ID_REVIEWPRODUK,
						'link'		=> '/anggota/' . $val->KODE_ANGGOTA,
						'foto'		=> '/upload/member/' . (empty($val->FOTO_ANGGOTA) ? 'default.png' : str_replace('.', '_thumb.', $val->FOTO_ANGGOTA)),
						'isi'		=> nl2br($val->ISI_REVIEWPRODUK, FALSE),
						'nama'		=> $val->NAMA_ANGGOTA,
						'valid'		=> $val->VALID_ANGGOTA == '1',
						'tanggal'	=> datedb_to_tanggal($val->TANGGAL_REVIEWPRODUK, 'd M Y H:i'),
						'hapus'		=> ($owner || $member == $val->KODE_ANGGOTA),
						'setuju'	=> ($owner && $val->STATUS_REVIEWPRODUK == '1'),
						'lihat'		=> ($owner || $member == $val->KODE_ANGGOTA || $val->STATUS_REVIEWPRODUK = '2')
					);
				}
			}
		} else {
			// berdasarkan pengirim
			$kode	= $this->db->escape_str($member);
			$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode'", TRUE);
			if (empty($run)) return FALSE;
			$id 	= $run->ID_ANGGOTA;
			$r 		= array();
			$run 	= $this->db->query("SELECT b.ID_PRODUK, b.NAMA_PRODUK, b.FOTO_PRODUK, a.ID_REVIEWPRODUK, a.ISI_REVIEWPRODUK, a.TANGGAL_REVIEWPRODUK FROM reviewproduk a, produk b WHERE a.ID_PRODUK = b.ID_PRODUK AND a.ID_ANGGOTA = '$id' AND a.STATUS_REVIEWPRODUK = '2'");
			if ( ! empty($run)) {
				foreach ($run as $val) {
					if (empty($val->FOTO_PRODUK))
						$foto 	= '/upload/produk/default.png';
					else {
						$f 		= unserialize($val->FOTO_PRODUK);
						$foto 	= '/upload/produk/' . str_replace('.', '_thumb.', $f[0]);
					}
					
					$r[]	= array(
						'link'		=> '/produk/' . $val->ID_PRODUK . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_PRODUK)) . '#review-' . $val->ID_REVIEWPRODUK,
						'foto'		=> $foto,
						'nama'		=> $val->NAMA_PRODUK,
						'isi'		=> token_truncate(strip_tags($val->ISI_REVIEWPRODUK), 350) . '...',
						'tanggal'	=> datedb_to_tanggal($val->TANGGAL_REVIEWPRODUK, 'd M Y H:i')
					);
				}
			}
		}
		return array(
			'type'		=> TRUE,
			'review'	=> $r
		);
	}
	
	public function save_review($id = 0) {
		if ( ! empty($id)) {
			extract($this->prepare_post(array('status', 'member')));
			if ( ! empty($status) && $status == 2) {
				$id 	= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
				$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE VALID_ANGGOTA = '1' AND STATUS_ANGGOTA = '1' AND KODE_ANGGOTA = '$member'", TRUE);
				if (empty($run)) return FALSE;
				$upd 	= $this->db->query("UPDATE reviewproduk SET STATUS_REVIEWPRODUK = '2' WHERE ID_REVIEWPRODUK = '$id'");
				return array(
					'type'		=> TRUE
				);
			}
		}
		
		extract($this->prepare_post(array('sender', 'produk', 'data')));
		$sender	= $this->db->escape_str($sender);
		$produk	= filter_var($produk, FILTER_SANITIZE_NUMBER_INT);
		$data	= $this->db->escape_str(htmlentities($data));
		// cari anggota
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE VALID_ANGGOTA = '1' AND STATUS_ANGGOTA = '1' AND KODE_ANGGOTA = '$sender'", TRUE);
		if (empty($run)) return FALSE;
		$id		= $run->ID_ANGGOTA;
		// periksa apakah ada review sebelumnya
		$run	= $this->db->query("SELECT TANGGAL_REVIEWPRODUK FROM reviewproduk WHERE ID_ANGGOTA = '$id' AND (STATUS_REVIEWPRODUK = '1' OR STATUS_REVIEWPRODUK = '2') ORDER BY TANGGAL_REVIEWPRODUK DESC LIMIT 0, 1", TRUE);
		if (empty($run)) {
			$ins	= $this->db->query("INSERT INTO reviewproduk VALUES(0, '$produk', '$id', '$data', NOW(), '1')");
			$type	= true;
		} else {
			$now	= time();
			$lpost	= datedb_to_tanggal($run->TANGGAL_REVIEWPRODUK, 'U');
			if (($now - $lpost) < (24 * 60 * 60)) {
				$type 	= FALSE;
				$rdata	= 'Anda hanya dapat mengirim satu review satu kali dalam sehari pada produk yang sama';
			} else {
				$ins	= $this->db->query("INSERT INTO reviewproduk VALUES(0, '$produk', '$id', '$data', NOW(), '1')");
				$type	= TRUE;
			}
		}
		return array(
			'type' => $type, 
			'data' => (isset($rdata) ? $rdata : '')
		);
	}
	
	public function delete_review($id) {
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$del 	= $this->db->query("UPDATE reviewproduk SET STATUS_REVIEWPRODUK = '0' WHERE ID_REVIEWPRODUK = '$id'");
		return array('type' => TRUE);
	}
}