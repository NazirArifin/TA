<?php
/**
 * Direktori Model
 */
namespace Model;

class DirektoriModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_list($alpha) {
		$r 		= array();
		$row	= array();
		$run 	= $this->db->query("SELECT ID_DIREKTORI, NAMA_DIREKTORI FROM direktori WHERE LEFT(UPPER(NAMA_DIREKTORI), 1) = '$alpha' AND STATUS_DIREKTORI = '1'");
		if ( ! empty($run)) {
			for ($i = 0; $i < count($run); $i++) {
				if ($i % 3 == 0 && $i != 0) {
					$r[]	= $row;
					$row	= array();
				}
				$row[] 	= array(
					'link'	=> $run[$i]->ID_DIREKTORI . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($run[$i]->NAMA_DIREKTORI)),
					'nama'	=> $run[$i]->NAMA_DIREKTORI	
				);
			}
			while (count($row) < 3) $row[] = array('link' => '', 'nama' => '');
			$r[] = $row;
		}
		return array(
			'type'		=> TRUE,
			'direktori'	=> $r
		);
	}
	
	public function view() {
		extract($this->prepare_get(array('query', 'nama', 'alamat', 'kategori', 'kota', 'cpage', 'type')));
		$cpage	= filter_var($cpage, FILTER_SANITIZE_NUMBER_INT);
		if (empty($cpage)) $cpage = 0;
		$r 		= array();
		$where	= array();
		if ( ! empty($query)) {
			$query 	= $this->db->escape_str(strip_tags($query));
			$r['param']['query'] = stripslashes($query);
			$where[] = "(a.NAMA_DIREKTORI LIKE '%{$query}%' OR a.ALAMAT_DIREKTORI LIKE '%{$query}%' OR a.INFO_DIREKTORI LIKE '%{$query}%')";
		}
		if ( ! empty($nama)) {
			$nama		= $this->db->escape_str(strip_tags($nama));
			$r['param']['nama']	= stripslashes($nama);
			$where[] 	= "a.NAMA_DIREKTORI LIKE '%{$nama}%'";
		}
		if ( ! empty($alamat)) {
			$alamat		= $this->db->escape_str(strip_tags($alamat));
			$r['param']['alamat'] = stripslashes($alamat);
			$where[] 	= "a.ALAMAT_DIREKTORI LIKE '%{$alamat}%'";
		}
		if ( ! empty($kategori)) {
			$kategori 	= filter_var($kategori, FILTER_SANITIZE_NUMBER_INT);
			$r['param']['kategori'] = $kategori;
			$where[] 	= "a.ID_KATDIR = '$kategori'";
		}
		if ( ! empty($kota)) {
			$kota		= filter_var($kota, FILTER_SANITIZE_NUMBER_INT);
			$r['param']['kota']	= $kota;
			$where[] 	= "a.ID_KOTA = '$kota'";
		}
		if ( ! empty($type)) {
			$r['param']['type'] = ($type == 'advanced' ? $type : 'normal');
		} else $r['param']['type'] = 'normal';
		
		$where[]	= "a.STATUS_DIREKTORI = '1'";
		$where[]	= "a.ID_KATDIR = b.ID_KATDIR";
		$where[]	= "a.ID_KOTA = c.ID_KOTA";
		// cari jumlah halaman
		$numdt		= 15;
		$r['data']	= array();
		$run 		= $this->db->query("SELECT COUNT(a.ID_DIREKTORI) AS HASIL FROM direktori a, katdir b, kota c WHERE " . implode(" AND ", $where), TRUE);
		$numpg		= ceil($run->HASIL / $numdt);
		if ($cpage < 0) $cpage = 0;
		if ($cpage > $numpg - 1) $cpage = $numpg - 1;
		// cari data
		$start		= $cpage * $numdt;
		$run 		= $this->db->query("SELECT a.ID_DIREKTORI, a.NAMA_DIREKTORI, a.ALAMAT_DIREKTORI, a.TELEPON_DIREKTORI, a.INFO_DIREKTORI, a.FOTO_DIREKTORI, b.NAMA_KATDIR, c.NAMA_KOTA FROM direktori a, katdir b, kota c WHERE " . implode(" AND ", $where) . " ORDER BY a.NAMA_DIREKTORI LIMIT $start, $numdt");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$alamat = json_decode($val->ALAMAT_DIREKTORI);
				$telepon = json_decode($val->TELEPON_DIREKTORI);
				if ( ! empty($alamat[1])) $alamat = implode('<br>', $alamat);
				else $alamat = $alamat[0];
				if ( ! empty($telepon[1])) $telepon = implode('<br>', $telepon);
				else $telepon = $telepon[0];
				
				$r['data'][] = array(
					'link'		=> '/direktori/' . $val->ID_DIREKTORI . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_DIREKTORI)),
					'nama'		=> $val->NAMA_DIREKTORI,
					'kategori'	=> $val->NAMA_KATDIR,
					'info'		=> $val->INFO_DIREKTORI,
					'kota'		=> $val->NAMA_KOTA,
					'foto'		=> '/upload/direktori/' . (empty($val->FOTO_DIREKTORI) ? 'default.png' : str_replace('.', '_thumb.', $val->FOTO_DIREKTORI)),
					'alamat'	=> $alamat,
					'telepon'	=> $telepon
				);
			}
		}
		$r['numpage'] 	= $numpg;
		$r['cpage']		= $cpage;
		$r['link']		= preg_replace('/&cpage=[0-9]+/', '', http_build_query($r['param']));
		return $r;
	}
	
	public function get_detail($id, $nama) {
		$r 		= array();
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$run	= $this->db->query("SELECT a.*, b.NAMA_KATDIR, c.NAMA_KOTA FROM direktori a, katdir b, kota c WHERE a.ID_KATDIR = b.ID_KATDIR AND a.ID_KOTA = c.ID_KOTA AND a.ID_DIREKTORI = '$id' AND STATUS_DIREKTORI = '1'", TRUE);
		if (empty($run)) return FALSE;
		if ($nama != preg_replace('/[^a-z0-9]/', '-', strtolower($run->NAMA_DIREKTORI))) return FALSE;
		
		// pemilik jika angka maka diganti nama anggota
		$link_angg		= '';
		$valid_angg		= FALSE;
		if (is_numeric($run->PEMILIK_DIREKTORI)) {
			$own 		= $this->db->query("SELECT KODE_ANGGOTA, NAMA_ANGGOTA, VALID_ANGGOTA FROM anggota WHERE ID_ANGGOTA = '" . $run->PEMILIK_DIREKTORI . "'", TRUE);
			$anggota 	= TRUE;
			$pemilik	= $own->NAMA_ANGGOTA;
			$link_angg	= '/anggota/' . $own->KODE_ANGGOTA; 
			if ($own->VALID_ANGGOTA == '1') $valid_angg = TRUE;
		} else {
			$anggota	= FALSE;
			$pemilik	= $run->PEMILIK_DIREKTORI;
		}
		
		$r['nama']		= $run->NAMA_DIREKTORI;
		$r['kategori']	= $run->NAMA_KATDIR;
		$r['kota']		= $run->NAMA_KOTA;
		$r['email']		= $run->EMAIL_DIREKTORI;
		$r['alamat']	= json_decode($run->ALAMAT_DIREKTORI);
		$r['telepon']	= json_decode($run->TELEPON_DIREKTORI);
		$r['pemilik']	= $pemilik;
		$r['anggota']	= $anggota;
		$r['valid_angg']= $valid_angg;
		$r['link_angg']	= $link_angg;
		$r['koordinat']	= json_decode($run->KOORDINAT_DIREKTORI);
		$r['info']		= $run->INFO_DIREKTORI;
		$r['website']	= json_decode($run->WEB_DIREKTORI);
		$r['chat']		= json_decode($run->CHAT_DIREKTORI);
		$r['socmed']	= json_decode($run->SOCMED_DIREKTORI);
		$r['foto']		= '/upload/direktori/' . (empty($run->FOTO_DIREKTORI) ? 'default.png' : $run->FOTO_DIREKTORI);
		return $r;
	}
}