<?php
/**
 * Transaksi Model
 */
namespace Model;

set_time_limit(0);

class AdmintransaksiModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	private function return_error() {
		return array( 'type' => FALSE );
	}
	
	public function show_jual() {
		$return	= array(
			'transaksi'	=> array(),
			'type'		=> TRUE
		);
		extract($this->prepare_get(array('cpage', 'numpage', 'date', 'status', 'numdt', 'order', 'sort')));
		$cpage	= intval($cpage);
		$numdt	= intval($numdt);
		$sort	= ($sort == 'asc' ? 'ASC' : 'DESC');
		$date	= tanggal_to_datedb($date);
		switch ($status) {
			case 1: case 2: case 3: case 4: case 5: break;
			default: $status = '';
		}
		$orderf	= array('a.TANGGAL_PENJUALAN', 'a.STATUS_PENJUALAN', 'b.NAMA_ANGGOTA', 'a.ID_PENJUALAN');
		// ubah urutan
		switch ($order) {
			case 'code': 	$index = 3; $field = "a.ID_PENJUALAN $sort"; 		break;
			case 'member': 	$index = 2; $field = "b.NAMA_ANGGOTA $sort"; 		break;
			case 'status': 	$index = 1; $field = "a.STATUS_PENJUALAN $sort"; 	break;
			case 'date': 	$index = 0; $field = "a.TANGGAL_PENJUALAN $sort"; 	break;
		}
		array_splice($orderf, $index, 1);
		array_unshift($orderf, $field);
		
		$where	= array();
		if ( ! empty($status)) $where[] = "a.STATUS_PENJUALAN = '$status'";
		else $where[] = "a.STATUS_PENJUALAN != '0'";
		if ( ! empty($date)) $where[] = "DATE(a.TANGGAL_PENJUALAN) = '$date'";
		
		// total
		$run 	= $this->db->query("SELECT COUNT(a.ID_PENJUALAN) AS HASIL FROM penjualan a WHERE " . implode(" AND ", $where), TRUE);
		$total	= $run->HASIL;
		$numpg	= ceil($total / $numdt);
		$start	= $cpage * $numdt;
		
		$r		= array();
		$run	= $this->db->query("SELECT a.ID_PENJUALAN, a.TANGGAL_PENJUALAN, a.STATUS_PENJUALAN, a.INFO_PENJUALAN, b.KODE_ANGGOTA, b.NAMA_ANGGOTA, b.VALID_ANGGOTA FROM penjualan a, anggota b WHERE a.ID_ANGGOTA = b.ID_ANGGOTA AND " . implode(" AND ", $where) . " ORDER BY " . implode(', ', $orderf) . " LIMIT $start, $numdt");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				switch ($val->STATUS_PENJUALAN) {
					case 1: $status = 'Tertunda'; break;
					case 2: $status = 'Lewat'; break;
					case 3: $status = 'Batal'; break;
					case 4: $status = 'Dikonfirmasi'; break;
					case 5: $status = 'Diproses'; break;
					case 6: $status = 'Dikirim'; break;
					case 7: $status = 'Selesai'; break;
				}
				/*
				1	Tertunda / Pending
				2	Lewat
				3	Batal
				4 	Dikonfirmasi
				5 	Diproses / Dipacking
				6 	Dikirim
				7	Selesai
				0	Dihapus
				*/
				$r[]	= array(
					'id'		=> $val->ID_PENJUALAN,
					'tanggal' 	=> datedb_to_tanggal($val->TANGGAL_PENJUALAN, 'd/m/Y H:i'),
					'anggota'	=> array(
						'kode'	=> $val->KODE_ANGGOTA,
						'nama'	=> $val->NAMA_ANGGOTA,
						'valid'	=> $val->VALID_ANGGOTA
					),
					'status'	=> $status,
					'info'		=> $val->INFO_PENJUALAN
				);
			}
		}
		
		$return['transaksi']	= $r;
		$return['numpage']		= $numpg;
		return $return;
	}
	
	public function update($type, $id) {
		extract($this->prepare_post(array('status')));
		$status 	= intval($status);
		$id			= floatval($id);
		if ($status < 0 || $status > 7) return FALSE;
		
		if ($type == 'jual') {
			$run	= $this->db->query("UPDATE penjualan SET STATUS_PENJUALAN = '$status' WHERE ID_PENJUALAN = '$id'");
		}
		
		return array( 'type' => TRUE );
	}
}