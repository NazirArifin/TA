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
}