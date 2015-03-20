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
					'link'		=> $tabel . '/' . datedb_to_tanggal($val['TANGGAL_' . $utabel], 'dmY') . '/' . preg_replace('/[^a-z0-9]/', '_', strtolower($judul))
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
		$run 	= $this->db->query("SELECT a.NAMA_ANGGOTA, b.* FROM anggota a, postanggota b WHERE a.ID_ANGGOTA = b.ID_ANGGOTA AND b.STATUS_POSTANGGOTA = '1' AND TIPE_POSTANGGOTA = '$tipe' ORDER BY TANGGAL_POSTANGGOTA DESC LIMIT 0, 5");
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
					'isi'		=> $ptisi,
					'tanggal'	=> datedb_to_tanggal($val->TANGGAL_POSTANGGOTA, 'l, d M Y'),
					'foto'		=> $foto,
					'anggota'	=> $val->NAMA_ANGGOTA,
					'link'		=> '/' . $type . '/' . $val->ID_POSTANGGOTA . '/' . preg_replace('/[^a-z0-9]/', '_', strtolower($val->JUDUL_POSTANGGOTA))
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
					'stok'	=> $val->STOK_PRODUKUTAMA,
					'harga'	=> number_format($val->HARGA_PRODUKUTAMA, 0, ',', '.') . ',-',
					'info'	=> $ptisi,
					'foto'	=> $foto
				);
			}
		}
		return $r;
	}
}