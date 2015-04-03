<?php
/**
 * Testimoni Model
 */
namespace Model;

class TestimoniModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_testi() {
		// you berisi kode anggota yang dilihat dan me berisi kode yang melihat
		extract($this->prepare_get(array('you', 'me')));
		if (empty($you) || empty($me)) return FALSE;
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$you'", TRUE);
		if (empty($run)) return FALSE;
		$id		= $run->ID_ANGGOTA;
		$r 		= array();
		$run	= $this->db->query("SELECT a.*, b.KODE_ANGGOTA, b.FOTO_ANGGOTA, b.NAMA_ANGGOTA FROM testimoni a, anggota b WHERE a.PENGIRIM_TESTIMONI = b.ID_ANGGOTA AND a.ID_ANGGOTA = '$id' AND (a.STATUS_TESTIMONI = '1' OR a.STATUS_TESTIMONI = '2')");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				//jika pengirim atau pemilik profil bisa hapus				
				$r[] 	= array(
					'id'		=> $val->ID_TESTIMONI,
					'kode'		=> $val->KODE_ANGGOTA,
					'nama'		=> $val->NAMA_ANGGOTA,
					'link'		=> '/anggota/' . $val->KODE_ANGGOTA,
					'foto'		=> '/upload/member/' .(empty($val->FOTO_ANGGOTA) ? 'default.png' : str_replace('.', '_thumb.', $val->FOTO_ANGGOTA)),
					'isi'		=> nl2br($val->ISI_TESTIMONI, FALSE),
					'tanggal'	=> datedb_to_tanggal($val->TANGGAL_TESTIMONI, 'd M Y H:i'),
					'hapus'		=> ($val->KODE_ANGGOTA == $me || $you == $me),
					'lihat'		=> ($you == $me || $me == $val->KODE_ANGGOTA || $val->STATUS_TESTIMONI = '2'),
					'setuju'	=> ($you == $me && $val->STATUS_TESTIMONI == '1')
				);
			}
		}
		return array(
			'type'		=> TRUE,
			'testimoni' => $r
		);
	}
	
	public function save_testi($id = 0) {
		if ( ! empty($id)) {
			extract($this->prepare_post(array('status', 'member')));
			if ( ! empty($status) && $status == 2) {
				$id 	= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
				$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE VALID_ANGGOTA = '1' AND STATUS_ANGGOTA = '1' AND KODE_ANGGOTA = '$member'", TRUE);
				if (empty($run)) return FALSE;
				$upd 	= $this->db->query("UPDATE testimoni SET STATUS_TESTIMONI = '2' WHERE ID_TESTIMONI = '$id'");
				return array('type'		=> TRUE);
			}
		}
		
		extract($this->prepare_post(array('data', 'sender', 'member')));
		$data	= $this->db->escape_str(htmlentities($data));
		// cari pengirim
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$sender' AND STATUS_ANGGOTA = '1' AND VALID_ANGGOTA = '1'", TRUE);
		if (empty($run)) return FALSE;
		$uid	= $run->ID_ANGGOTA;
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$member' AND STATUS_ANGGOTA = '1'", TRUE);
		if (empty($run)) return FALSE;
		$id		= $run->ID_ANGGOTA;
		// periksa apakah ada testimoni sebelumnya
		$run	= $this->db->query("SELECT TANGGAL_TESTIMONI FROM testimoni WHERE ID_ANGGOTA = '$id' AND PENGIRIM_TESTIMONI = '$uid' AND STATUS_TESTIMONI = '1' ORDER BY TANGGAL_TESTIMONI DESC LIMIT 0, 1", TRUE);
		if (empty($run)) {
			$ins	= $this->db->query("INSERT INTO testimoni VALUES(0, '$id', '$uid', '$data', NOW(), '1')");
			$type 	= TRUE;
		} else {
			$now	= time();
			$lpost	= datedb_to_tanggal($run->TANGGAL_TESTIMONI, 'U');
			if (($now - $lpost) < (24 * 60 * 60)) {
				$type 	= FALSE;
				$rdata	= 'Anda hanya dapat mengirim testimoni satu kali dalam sehari pada anggota yang sama';
			} else {
				$ins	= $this->db->query("INSERT INTO testimoni VALUES(0, '$id', '$uid', '$data', NOW(), '1')");
				$type 	= TRUE;
			}
		}
		return array(
			'type'	=> $type,
			'data'	=> (isset($rdata) ? $rdata : '')
		);
	}
	
	public function delete_testi($id) {
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$del 	= $this->db->query("UPDATE testimoni SET STATUS_TESTIMONI = '0' WHERE ID_TESTIMONI = '$id'");
		return array('type' => TRUE);
	}
}