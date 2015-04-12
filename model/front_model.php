<?php
/**
 * Front Model
 */
namespace Model;

class FrontModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_berita($type) {
		$tabel	= ($type == 'bisnis' ? 'berita' : 'info');
		$utabel	= strtoupper($tabel);
		$r 		= array();
		$run 	= $this->db->query("SELECT JUDUL_$utabel, ISI_$utabel, TANGGAL_$utabel, FOTO_$utabel FROM $tabel ORDER BY TANGGAL_$utabel DESC LIMIT 0, 3", FALSE, FALSE);
		if ( ! empty($run)) {
			foreach ($run as $val) {
				if ($tabel == 'berita') {
					$data 		= unserialize($val['ISI_' . $utabel]);
					$pengantar 	= $data['pengantar'];
					$disi 		= $data['isi'];
					if ( ! empty($pengantar)) {
						$isi = token_truncate($pengantar, 150);
						$disi	= $data['pengantar'];
					} else $isi = token_truncate($disi, 150);
				} else {
					$disi		= $val['ISI_' . $utabel];
					$isi 		= token_truncate($disi, 150);
				}
				$judul			= $val['JUDUL_' . $utabel];
				$r[] = array(
					'judul' 	=> $judul,
					'tanggal'	=> datedb_to_tanggal($val['TANGGAL_' . $utabel], 'l, d M Y'),
					'foto'		=> '/upload/news/' . (empty($val['FOTO_' . $utabel]) ? 'default.png' : $val['FOTO_' . $utabel]),
					'isi'		=> $isi . (strlen($disi) > 150 ? '...' : ''),
					'link'		=> $tabel . '/' . datedb_to_tanggal($val['TANGGAL_' . $utabel], 'dmY') . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($judul))
				);
			}
		}
		return $r;
	}
	
	public function get_direktori_list() {
		$run 		= $this->db->query("SELECT LEFT(NAMA_DIREKTORI, 1) AS D FROM direktori GROUP BY LEFT(NAMA_DIREKTORI, 1)");
		$haslink 	= array();
		if ( ! empty($run)) {
			foreach ($run as $val) $haslink[] = $val->D;
		}
		$alpha = array();
		for ($b = 'A', $i = 1; $i <= 26; $i++, $b++) {
			$alpha[] = array(
				'a'	=> $b,
				'h'	=> (in_array($b, $haslink))
			);
		}
		return $alpha;
	}
	
	public function get_post($type) {
		$tipe	= ($type == 'jual' ? 1 : 2);
		$r 		= array();
		$run 	= $this->db->query("SELECT a.KODE_ANGGOTA, a.NAMA_ANGGOTA, b.*, c.NAMA_KATPRODUK FROM anggota a, postanggota b, katproduk c WHERE a.ID_ANGGOTA = b.ID_ANGGOTA AND b.STATUS_POSTANGGOTA = '1' AND TIPE_POSTANGGOTA = '$tipe' AND b.ID_KATPRODUK = c.ID_KATPRODUK ORDER BY TANGGAL_POSTANGGOTA DESC LIMIT 0, 5");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$isi 		= strip_tags($val->ISI_POSTANGGOTA);
				$ptisi		= token_truncate($isi, 150);
				if (strlen($isi) > 150) $ptisi .= '...';
				if (empty($val->FOTO_POSTANGGOTA))
					$foto 	= '/upload/post/default.png';
				else {
					$f 		= unserialize($val->FOTO_POSTANGGOTA);
					$foto 	= '/upload/post/' . str_replace('.', '_thumb.', $f[0]);
				}
				$r[] = array(
					'id' 		=> $val->ID_POSTANGGOTA,
					'judul'		=> $val->JUDUL_POSTANGGOTA,
					'kategori'	=> $val->NAMA_KATPRODUK,
					'isi'		=> $ptisi,
					'tanggal'	=> datedb_to_tanggal($val->TANGGAL_POSTANGGOTA, 'l, d M Y'),
					'foto'		=> $foto,
					'anggota'	=> $val->NAMA_ANGGOTA,
					'link_angg'	=> '/anggota/' . $val->KODE_ANGGOTA,
					'link'		=> '/' . $type . '/' . $val->ID_POSTANGGOTA . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->JUDUL_POSTANGGOTA))
				);
			}
		}
		return $r;
	}
	
	public function get_produk() {
		// secara acak
		$r 		= array();
		$run 	= $this->db->query("SELECT * FROM produkutama WHERE STATUS_PRODUKUTAMA = '1' ORDER BY RAND() LIMIT 10");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$isi 		= strip_tags($val->INFO_PRODUKUTAMA);
				$ptisi		= token_truncate($isi, 150);
				if (strlen($isi) > 150) $ptisi .= '...';
				if (empty($val->FOTO_PRODUKUTAMA))
					$foto 	= '/upload/produk/default.png';
				else {
					$f 		= unserialize($val->FOTO_PRODUKUTAMA);
					$foto	= '/upload/produk/' . str_replace('.', '_thumb.', $f[0]);
				}
				$r[] = array(
					'id'	=> $val->ID_PRODUKUTAMA,
					'nama'	=> $val->NAMA_PRODUKUTAMA,
					'link'	=> '/fproduk/' . $val->ID_PRODUKUTAMA . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_PRODUKUTAMA)),
					'stok'	=> $val->STOK_PRODUKUTAMA,
					'harga'	=> number_format($val->HARGA_PRODUKUTAMA, 0, ',', '.') . ',-',
					'info'	=> $ptisi,
					'foto'	=> $foto
				);
			}
		}
		return $r;
	}
	
	public function save_pesan() {
		extract($this->prepare_post(array('forCode', 'fromCode', 'type', 'message')));
		$message	= $this->db->escape_str($message);
		if ($type != 3 && $type != 4) return FALSE;
		if ($type == 4) {
			$message= mb_substr($message, 0, 160);
			$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$forCode'", TRUE);
			if (empty($run)) return FALSE;
			$forid	= $run->ID_ANGGOTA;
			$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$fromCode'", TRUE);
			if (empty($run)) return FALSE;
			$fromid	= $run->ID_ANGGOTA;
			$ins	= $this->db->query("INSERT INTO pesan VALUES(0, '$fromid', '$forid', NOW(), '$message', '1', '$type')");
		}
		if ($type == 3) {
			
		}
		return array('type' => TRUE);
	}
	
	public function news_detail($type, $id, $judul) {
		$r 		= array();
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$utype	= strtoupper($type);
		$run	= $this->db->query("SELECT ID_{$utype}, JUDUL_{$utype} FROM $type WHERE STR_TO_DATE('$id', '%d%m%Y') = DATE(TANGGAL_{$utype})", FALSE, FALSE);
		if (empty($run)) return FALSE;
		foreach ($run as $val) {
			if (preg_replace('/[^a-z0-9]/', '-', strtolower($val['JUDUL_' . $utype]))) {
				$id	= $val['ID_' . $utype];
				break;
			}
		}
		$run	= $this->db->query("SELECT a.*, b.NAMA_ADMIN, b.FOTO_ADMIN FROM $type a, admin b WHERE a.ID_ADMIN = b.ID_ADMIN AND a.ID_{$utype} = '$id' AND a.STATUS_{$utype} = '1'", TRUE, FALSE);
		$r['id']		= $run['ID_' . $utype];
		$r['judul']		= $run['JUDUL_' . $utype];
		$r['foto']		= '/upload/news/' . (empty($run['FOTO_' . $utype]) ? 'default.png' : $run['FOTO_' . $utype]);
		$r['tanggal']	= datedb_to_tanggal($run['TANGGAL_' . $utype], 'd F Y H:i');
		$r['nama_poster']	= $run['NAMA_ADMIN'];
		$r['foto_poster']	= '/upload/member/' . (empty($run['FOTO_ADMIN']) ? 'default.png' : str_replace('.', '_thumb.', $run['FOTO_ADMIN']));
		if ($type == 'berita') {
			$data		= unserialize($run['ISI_' . $utype]);
			$r['pengantar']	= $data['pengantar'];
			$r['isi']		= $data['isi'];
			$r['tag']		= $run['TAG_BERITA'];
		} else $r['isi']	= $run['ISI_' . $utype];
		$r['type']		= $type;
		return $r;
	}
	
	public function news_other($type, $id) {
		$r 		= array();
		$utype	= strtoupper($type);
		$run	= $this->db->query("SELECT JUDUL_{$utype}, TANGGAL_{$utype}, FOTO_{$utype} FROM $type WHERE STATUS_{$utype} = '1' AND ID_{$utype} != '$id' ORDER BY RAND() LIMIT 0, 5", FALSE, FALSE);
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$r[] = array(
					'link'		=> '/' . $type . '/' . datedb_to_tanggal($val['TANGGAL_' . $utype], 'dmY') . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val['JUDUL_' . $utype])),
					'judul'		=> $val['JUDUL_' . $utype],
					'tanggal'	=> datedb_to_tanggal($val['TANGGAL_' . $utype], 'd/m/Y'),
					'foto'		=> '/upload/news/' . (empty($val['FOTO_' . $utype]) ? 'default.png' : $val['FOTO_' . $utype])
				);
			}
		}
		return $r;
	}
	
	public function news_list($type) {
		extract($this->prepare_get(array('cpage', 'query')));
		$cpage	= filter_var($cpage, FILTER_SANITIZE_NUMBER_INT);
		if (empty($cpage)) $cpage = 0;
		$r 		= array();
		$where	= array();
		$utype	= strtoupper($type);
		if ( ! empty($query)) {
			$query		= $this->db->escape_str(strip_tags($query));
			$where[]	= "(JUDUL_{$utype} LIKE '%{$query}%' OR ISI_{$utype} LIKE '%{$query}%')";
			$r['param']['query'] = stripslashes($query);
		} else $r['param']['query'] = '';
		$where[]	= "STATUS_{$utype} = '1'";
		// jumlah halaman
		$numdt		= 15;
		$r['data']	= array();
		$run		= $this->db->query("SELECT COUNT(ID_{$utype}) AS HASIL FROM $type WHERE " . implode(" AND ", $where), TRUE);
		$numpg		= ceil($run->HASIL / $numdt);
		if ($numpg == 0) $numpg = 1;
		if ($cpage < 0) $cpage = 0;
		if ($cpage > $numpg - 1) $cpage = $numpg - 1;
		$start		= $cpage * $numdt;
		$run	 	= $this->db->query("SELECT * FROM $type WHERE " . implode(" AND ", $where) . " ORDER BY TANGGAL_{$utype} DESC LIMIT $start, $numdt", FALSE, FALSE);
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$datedb = $val['TANGGAL_' . $utype];
				if ($type == 'berita') {
					$data	= unserialize($val['ISI_' . $utype]);
					$isi	= $data['isi'];
				} else $isi	= $val['ISI_' . $utype];
				$r['data'][] = array(
					'link'		=> '/' . $type . '/' . datedb_to_tanggal($datedb, 'dmY') . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val['JUDUL_' . $utype])),
					'judul'		=> $val['JUDUL_' . $utype],
					'tanggal'	=> datedb_to_tanggal($datedb, 'd F Y'),
					'foto'		=> '/upload/news/' . (empty($val['FOTO_' . $utype]) ? 'default.png' : $val['FOTO_' . $utype]),
					'isi'		=> token_truncate(strip_tags($isi), 200) . '...'
				);
			}
		}
		
		$r['type']	= $type;
		$r['numpage'] 	= $numpg;
		$r['cpage']		= $cpage;
		$r['link']		= preg_replace('/&cpage=[0-9]+/', '', http_build_query($r['param']));
		return $r;
	}
	
	public function get_ongkir() {
		extract($this->prepare_get(array('kota')));
		$kota 	= filter_var($kota, FILTER_SANITIZE_NUMBER_INT);
		if (empty($kota)) return FALSE;
		$run	= $this->db->query("SELECT BIAYA_BIAYAKURIR FROM biayakurir WHERE ID_KOTA = '$kota'", TRUE);
		if ( ! empty($run)) $biaya = $run->BIAYA_BIAYAKURIR;
		else $biaya = 0;
		return array('type' => TRUE, 'biaya' => $biaya);
	}
}