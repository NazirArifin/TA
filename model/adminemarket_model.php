<?php
/**
 * Emarket Model
 */
namespace Model;

set_time_limit(0);

class AdminemarketModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	private function return_error() {
		return array( 'type' => FALSE );
	}
	
	public function show($type) {
		$return		= array(
			'type' 		=> TRUE,
			'kiriman' 	=> array(),
			'numpage'	=> 0
		);
		
		extract($this->prepare_get(array('cpage', 'numpage', 'query', 'date', 'numdt', 'order', 'sort')));
		$cpage	= intval($cpage);
		$numdt	= intval($numdt);
		$query	= $this->db->escape_str($query);
		$sort	= ($sort == 'asc' ? 'ASC' : 'DESC');
		$order	= ($order == 'date' ? 'TANGGAL_POSTANGGOTA' : 'ID_ANGGOTA');
		$type 	= ($type == 'jual' ? 1 : 2);
		
		$where	= array();
		$where[]= "TIPE_POSTANGGOTA = '$type'";
		$where[]= "STATUS_POSTANGGOTA = '1'";
		if ( ! empty($date)) 
			$where[]	= "DATE(TANGGAL_POSTANGGOTA) = '" . tanggal_to_datedb($date) . "'";
		if ( ! empty($query)) {
			$where[]	= "(ISI_POSTANGGOTA LIKE '%{$query}%' OR JUDUL_POSTANGGOTA LIKE '%{$query}%')";
		}
		
		$run	= $this->db->query("SELECT COUNT(ID_POSTANGGOTA) AS HASIL FROM postanggota WHERE " . implode(" AND ", $where), TRUE);
		$total	= $run->HASIL;
		$numpg	= ceil($total / $numdt);
		$start	= $cpage * $numdt;
		$path	= 'upload/post/';
		
		$r 		= array();
		$run	= $this->db->query("SELECT a.*, b.KODE_ANGGOTA, b.NAMA_ANGGOTA, b.VALID_ANGGOTA FROM postanggota a, anggota b WHERE a.ID_ANGGOTA = b.ID_ANGGOTA AND " . implode(" AND ", $where) . " ORDER BY $order $sort LIMIT $start, $numdt");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				// hitung komentar
				$komentar = $this->db->query("SELECT COUNT(ID_KOMENTAR) AS HASIL FROM komentar WHERE ID_POSTANGGOTA = '{$val->ID_POSTANGGOTA}'", TRUE);
				
				if ( ! empty($val->FOTO_POSTANGGOTA)) {
					$fotos 	= unserialize($val->FOTO_POSTANGGOTA);
					$foto 	= $path . $fotos[0];
				} else $foto = $path . 'default.png';
				
				$r[]= array(
					'kode_pengirim' => $val->KODE_ANGGOTA,
					'nama_pengirim'	=> $val->NAMA_ANGGOTA,
					'valid_pengirim'=> ($val->VALID_ANGGOTA == '1' ? TRUE : FALSE),
					'tanggal'		=> datedb_to_tanggal($val->TANGGAL_POSTANGGOTA, 'd/m/Y H:i'),
					'isi'			=> token_truncate(strip_tags($val->ISI_POSTANGGOTA), 150) . (strlen($val->ISI_POSTANGGOTA) > 150 ? ' ...' : ''),
					'id'			=> $val->ID_POSTANGGOTA,
					'foto'			=> $foto,
					'judul'			=> $val->JUDUL_POSTANGGOTA,
					'komentar'		=> $komentar->HASIL
				);
			}
		}
		
		$return['kiriman']	= $r;
		$return['numpage']	= $numpg;
		return $return;
	}
	
	public function delete($id) {
		$id		= floatval($id);
		$upd	= $this->db->query("UPDATE postanggota SET STATUS_POSTANGGOTA = '0' WHERE ID_POSTANGGOTA = '$id'");
		return array( 'type' => TRUE );
	}
}