<?php
/**
 * Anggota Model
 */
namespace Model;

class AnggotaModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_detail($kode) {
		$kode	= $this->db->escape_str($kode);
		$r 		= array();
		$run	= $this->db->query("SELECT ID_ANGGOTA, NAMA_ANGGOTA, ALAMAT_ANGGOTA, TELEPON_ANGGOTA, FOTO_ANGGOTA, INFO_ANGGOTA, VALID_ANGGOTA, DAFTAR_ANGGOTA, JENIS_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode' AND STATUS_ANGGOTA = '1'", TRUE);
		if (empty($run)) return FALSE;
		// postanggota
		$id		= $run->ID_ANGGOTA;
		$count 	= $this->db->query("SELECT COUNT(ID_POSTANGGOTA) AS HASIL FROM postanggota WHERE ID_ANGGOTA = '$id' AND STATUS_POSTANGGOTA = '1'", TRUE);
		$post	= $count->HASIL;
		// review
		$count	= $this->db->query("SELECT COUNT(ID_REVIEWPRODUK) AS HASIL FROM reviewproduk WHERE ID_ANGGOTA = '$id' AND STATUS_REVIEWPRODUK = '2'", TRUE);
		$review	= $count->HASIL;
		// testimoni
		$count	= $this->db->query("SELECT COUNT(ID_TESTIMONI) AS HASIL FROM testimoni WHERE ID_ANGGOTA = '$id' AND STATUS_TESTIMONI = '2'", TRUE);
		$testi	= $count->HASIL;
		// apakah memiliki direktori
		$dir	= array();
		$cari	= $this->db->query("SELECT ID_DIREKTORI, NAMA_DIREKTORI FROM direktori WHERE PEMILIK_DIREKTORI = '$id'");
		if ( ! empty($cari)) { 
			foreach ($cari as $val) {
				$dir[] = array(
					'nama'	=> $val->NAMA_DIREKTORI,
					'link'	=> '/direktori/' . $val->ID_DIREKTORI . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_DIREKTORI))
				);
			}
		}
		
		$r['id']		= $id;
		$r['nama']		= $run->NAMA_ANGGOTA;
		$r['alamat']	= $run->ALAMAT_ANGGOTA;
		$r['telepon']	= $run->TELEPON_ANGGOTA;
		$r['foto']		= '/upload/member/' . (empty($run->FOTO_ANGGOTA) ? 'default.png' : str_replace('.', '_thumb.', $run->FOTO_ANGGOTA));
		$r['info']		= $run->INFO_ANGGOTA;
		$r['valid']		= ($run->VALID_ANGGOTA == '1' ? TRUE : FALSE);
		$r['jenis']		= ($run->JENIS_ANGGOTA == '1' ? 'Reguler' : 'Premium');
		$r['daftar']	= datedb_to_tanggal($run->DAFTAR_ANGGOTA, 'd M Y');
		$r['post']		= $post;
		$r['review']	= $review;
		$r['testi']		= $testi;
		$r['direktori'] = $dir;
		return $r;
	}
}