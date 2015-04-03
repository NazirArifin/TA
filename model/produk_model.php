<?php
/**
 * Produk Model
 */
namespace Model;

class ProdukModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_produk($id) {
		$r 		= array();
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$run	= $this->db->query("SELECT b.NAMA_KATPRODUK, a.ID_PRODUK, a.NAMA_PRODUK, a.HARGA_PRODUK, a.INFO_PRODUK, a.FOTO_PRODUK FROM produk a, katproduk b WHERE a.ID_KATPRODUK = b.ID_KATPRODUK AND a.ID_DIREKTORI = '$id' AND a.STATUS_PRODUK = '1' ORDER BY ID_PRODUK DESC");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$infoe	= strip_tags($val->INFO_PRODUK);
				$info 	= token_truncate($infoe, 150) . (strlen($infoe) > 150 ? '...' : '');
				if (empty($val->FOTO_PRODUK))
					$foto 	= '/upload/produk/default.png';
				else {
					$f 		= unserialize($val->FOTO_PRODUK);
					$foto 	= '/upload/produk/' . str_replace('.', '_thumb.', $f[0]);
				}
				$r[]	= array(
					'id'		=> $val->ID_PRODUK,
					'kategori'	=> $val->NAMA_KATPRODUK,
					'nama'		=> $val->NAMA_PRODUK,
					'harga'		=> ( ! empty($val->HARGA_PRODUK) ? number_format($val->HARGA_PRODUK, 0, ',', '.') : ''),
					'info'		=> $info,
					'foto'		=> $foto,
					'link'		=> '/produk/' . $val->ID_PRODUK . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_PRODUK))
				);
			}
		}
		return $r;
	}
	
	public function get_all_post() {
		extract($this->prepare_get(array('cpage', 'kategori', 'query')));
		$cpage 	= filter_var($cpage, FILTER_SANITIZE_NUMBER_INT);
		if (empty($cpage)) $cpage = 0;
		$where	= array();
		$r 		= array();
		if ( ! empty($query)) {
			$query		= $this->db->escape_str(strip_tags($query));
			$where[]	= "(a.NAMA_PRODUKUTAMA LIKE '%{$query}%' OR a.INFO_PRODUKUTAMA LIKE '%{$query}%')";
			$r['param']['query'] = stripslashes($query);
		} else $r['param']['query'] = '';
		if ( ! empty($kategori)) {
			$kategori	= filter_var($kategori, FILTER_SANITIZE_NUMBER_INT);
			$where[]	= "a.ID_KATPRODUK = '$kategori'";
			$r['param']['kategori'] = $kategori;
		} else $r['param']['kategori'] = '';
		$where[]	= "a.STATUS_PRODUKUTAMA = '1'";
		$where[]	= "a.ID_KATPRODUK = b.ID_KATPRODUK";
		// jumlah halaman
		$numdt		= 21;
		$r['produk']= array();
		$run		= $this->db->query("SELECT COUNT(a.ID_PRODUKUTAMA) AS HASIL FROM produkutama a, katproduk b WHERE " . implode(" AND ", $where), TRUE);
		$numpg		= ceil($run->HASIL / $numdt);
		if ($numpg == 0) $numpg = 1;
		if ($cpage < 0) $cpage = 0;
		if ($cpage > $numpg - 1) $cpage = $numpg - 1;
		$start		= $cpage * $numdt;
		$run		= $this->db->query("SELECT a.*, b.NAMA_KATPRODUK FROM produkutama a, katproduk b WHERE " . implode(" AND ", $where) . " ORDER BY a.NAMA_PRODUKUTAMA LIMIT $start, $numdt");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				if ( ! empty($val->FOTO_PRODUKUTAMA)) {
					$f 		= unserialize($val->FOTO_PRODUKUTAMA);
					$foto	= '/upload/produk/' . str_replace('.', '_thumb.', $f[0]);
				} else $foto = '/upload/produk/default.png';
				
				$r['produk'][]	= array(
					'link'		=> '/fproduk/' . $val->ID_PRODUKUTAMA . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_PRODUKUTAMA)),
					'kategori'	=> $val->NAMA_KATPRODUK,
					'nama'		=> $val->NAMA_PRODUKUTAMA,
					'info'		=> token_truncate(strip_tags($val->INFO_PRODUKUTAMA), 100) . '...',
					'harga'		=> number_format($val->HARGA_PRODUKUTAMA, 0, ',', '.'),
					'stok'		=> $val->STOK_PRODUKUTAMA,
					'foto'		=> $foto
				);
			}
		}
		
		$r['numpage'] 	= $numpg;
		$r['cpage']		= $cpage;
		$r['link']		= preg_replace('/&cpage=[0-9]+/', '', http_build_query($r['param']));
		return $r;
	}
	
	public function get_detail($id, $nama = '', $feat = FALSE) {
		$r 		= array();
		$table	= ($feat ? 'produkutama' : 'produk');
		$utable	= strtoupper($table);
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$run	= $this->db->query("SELECT a.*, b.NAMA_KATPRODUK FROM $table a, katproduk b WHERE a.STATUS_{$utable} = '1' AND a.ID_KATPRODUK = b.ID_KATPRODUK AND a.ID_{$utable} = '$id'", TRUE, FALSE);
		if (empty($run)) return FALSE;
		if ($nama != preg_replace('/[^a-z0-9]/', '-', strtolower($run['NAMA_'.$utable]))) return FALSE;
		$r['id']		= $id;
		$r['kategori']	= $run['NAMA_KATPRODUK'];
		$r['nama']		= $run['NAMA_' . $utable];
		$r['harga']		= number_format($run['HARGA_' . $utable], 0, ',', '.');
		$r['info']		= $run['INFO_' . $utable];
		if ( ! empty($run['FOTO_' . $utable])) {
			$foto			= unserialize($run['FOTO_' . $utable]);
			foreach ($foto as $key => $val) $foto[$key] = '/upload/produk/' . $val;
			$r['foto']		= $foto;
		} else $r['foto']	= array('/upload/produk/default.png');
		if (isset($run['STOK_' . $utable])) $r['stok']		= $run['STOK_' . $utable];
		// jika produk maka dapatkan nama direktorinya
		if ($table == 'produk') {
			$srun	= $this->db->query("SELECT a.ID_DIREKTORI, a.NAMA_DIREKTORI FROM direktori a, produk b WHERE a.ID_DIREKTORI = b.ID_DIREKTORI AND a.ID_DIREKTORI = '{$run['ID_DIREKTORI']}'", TRUE);
			$r['direktori'] 		= $srun->NAMA_DIREKTORI;
			$r['direktori_id']		= $srun->ID_DIREKTORI;
			$r['direktori_link']	= '/direktori/' . $run['ID_DIREKTORI'] . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($srun->NAMA_DIREKTORI));
		} else {
			$r['direktori']			= 'Semua Produk';
			$r['direktori_link']	= '/fproduk';
		}
		return $r;
	}
	
	public function get_other_produk($id = 0, $pid) {
		$type = 'produk';
		if (empty($id)) {
			$table	= 'produkutama';
			$limit	= 12;
			$type	= 'fproduk';
			$where 	= '';
		} else {
			$table	= 'produk';
			$limit	= 5;
			$where	= "AND ID_DIREKTORI = '$id' ";
		}
		$r 		= array();
		$utable	= strtoupper($table);
		$run 	= $this->db->query("SELECT ID_{$utable}, NAMA_{$utable}, HARGA_{$utable}, INFO_{$utable}, FOTO_{$utable} FROM $table WHERE ID_{$utable} != '$pid' AND STATUS_{$utable} = '1' {$where}ORDER BY RAND() LIMIT 0, $limit", FALSE, FALSE);
		if ( ! empty($run)) {
			foreach ($run as $val) {
				if ($type == 'fproduk') {
					$infoe	= strip_tags($val['INFO_' . $utable]);
					$info 	= token_truncate($infoe, 70) . (strlen($infoe) > 70 ? '...' : '');
				} else $info = '';
				if (empty($val['FOTO_' . $utable]))
					$foto 	= '/upload/produk/default.png';
				else {
					$f 		= unserialize($val['FOTO_' . $utable]);
					$foto 	= '/upload/produk/' . str_replace('.', '_thumb.', $f[0]);
				}
				$r[]	= array(
					'link'	=> '/' . $type . '/' . $val['ID_' . $utable] . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val['NAMA_' . $utable])),
					'nama'	=> $val['NAMA_' . $utable],
					'harga'	=> number_format($val['HARGA_' . $utable], 0, ',', '.'),
					'foto'	=> $foto,
					'info'	=> $info
				);
			}
		}
		return $r;
	}
}