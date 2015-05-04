<?php
/**
 * Produk Model
 */
namespace Model;

class ProdukModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_produk($id, $for_edit = FALSE) {
		$r 		= array();
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		if ( ! $for_edit) {
			$run	= $this->db->query("SELECT b.ID_KATPRODUK, b.NAMA_KATPRODUK, a.* FROM produk a, katproduk b WHERE a.ID_KATPRODUK = b.ID_KATPRODUK AND a.ID_DIREKTORI = '$id' AND a.STATUS_PRODUK != '0' ORDER BY NAMA_PRODUK");
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
						'id_kategori'=> $val->ID_KATPRODUK,
						'nama'		=> $val->NAMA_PRODUK,
						'harga'		=> ( ! empty($val->HARGA_PRODUK) ? number_format($val->HARGA_PRODUK, 0, ',', '.') : ''),
						'info'		=> $info,
						'foto'		=> $foto,
						'link'		=> '/produk/' . $val->ID_PRODUK . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_PRODUK)),
						'status'	=> $val->STATUS_PRODUK
					);
				}
			}
		}
		
		if ($for_edit) {
			$run	= $this->db->query("SELECT * FROM produk WHERE ID_PRODUK = '$id'", TRUE);
			if (empty($run)) return FALSE;
			$r['id'] 		= $id;
			$r['kategori']	= $run->ID_KATPRODUK;
			$r['nama']		= $run->NAMA_PRODUK;
			$r['harga']		= number_format($run->HARGA_PRODUK, 0, ',', '.');
			$r['info']		= $run->INFO_PRODUK;
			$r['direktori']	= $run->ID_DIREKTORI;
			if (empty($run->FOTO_PRODUK)) $r['foto'] = array('/upload/produk/default.png');
			else {
				$foto = unserialize($run->FOTO_PRODUK);
				foreach ($foto as $key => $val) $foto[$key] = '/upload/produk/' . $val;
				$r['foto']	= $foto;
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
					'id'		=> $val->ID_PRODUKUTAMA,
					'link'		=> '/fproduk/' . $val->ID_PRODUKUTAMA . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_PRODUKUTAMA)),
					'kategori'	=> $val->NAMA_KATPRODUK,
					'nama'		=> str_replace(array('&nbsp;', '&amp;'), array(' ', '&'), $val->NAMA_PRODUKUTAMA),
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
		$run	= $this->db->query("SELECT a.*, b.ID_KATPRODUK, b.NAMA_KATPRODUK FROM $table a, katproduk b WHERE a.STATUS_{$utable} = '1' AND a.ID_KATPRODUK = b.ID_KATPRODUK AND a.ID_{$utable} = '$id'", TRUE, FALSE);
		if (empty($run)) return FALSE;
		if ($nama != preg_replace('/[^a-z0-9]/', '-', strtolower($run['NAMA_'.$utable]))) return FALSE;
		$r['id']		= $id;
		$r['kategori']	= $run['NAMA_KATPRODUK'];
		$r['id_kategori'] = $run['ID_KATPRODUK'];
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
	
	public function save_produk($produkid = 0, $iofiles) {
		extract($this->prepare_post(array('id', 'kategori', 'nama', 'harga', 'info', 'direktori', 'foto', 'status')));
		$id			= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		if (empty($id)) $id = 0;
		
		if ( ! empty($status)) {
			switch ($status) {
				case 1: case 2: break;
				default: return FALSE;
			}
			$run	= $this->db->query("UPDATE produk SET STATUS_PRODUK = '$status' WHERE ID_PRODUK = '$id'");
			return array( 'type'	=> TRUE );
		}
		
		$kategori	= filter_var($kategori, FILTER_SANITIZE_NUMBER_INT);
		$nama		= $this->db->escape_str($nama);
		$harga		= preg_replace('/[^0-9]/', '', $harga);
		$info		= $this->db->escape_str($info);
		$direktori	= filter_var($direktori, FILTER_SANITIZE_NUMBER_INT);
		// validasi
		$valid	= TRUE;
		if (empty($kat)) 		$v = FALSE;
		if (strlen($nama) < 3) 	$v = FALSE;
		if (strlen($info) < 5) 	$v = FALSE;
		if (empty($harga))		$v = FALSE;
		if ( ! $valid) return array('type' => FALSE);
		
		if (empty($id)) {
			$ins	= $this->db->query("INSERT INTO produk VALUES(0, '$direktori', '$kategori', '$nama', '$harga', '$info', '', '1')");
			$id 	= $this->db->get_insert_id();
		} else {
			$upd 	= array();
			$data	= $this->db->query("SELECT * FROM produk WHERE ID_PRODUK = '$id'", TRUE);
			if ($kategori != $data->ID_KATPRODUK)	$upd[] = "ID_KATPRODUK = '$kat'";
			if ($nama != $data->NAMA_PRODUK)		$upd[] = "NAMA_PRODUK = '$nama'";
			if ($info != $data->INFO_PRODUK)		$upd[] = "INFO_PRODUK = '$info'";
			if ($harga != $data->HARGA_PRODUK)		$upd[] = "HARGA_PRODUK = '$harga'";
			
			// analisa perubahan foto
			$ofoto	= (empty($data->FOTO_PRODUK) ? array() : unserialize($data->FOTO_PRODUK));
			$foto	= (empty($foto) ? array() : $foto);
			if ( ! empty($foto)) {
				foreach ($foto as $key => $val) $foto[$key] = str_replace('/upload/produk/', '', $val);
			}
			// dihapus
			if (count($foto) < count($ofoto)) {
				foreach ($ofoto as $val) {
					if (array_search($val, $foto) === FALSE) {
						$fpath 		= 'upload/produk/' . $val;
						$fpath_thumb= 'upload/produk/' . str_replace('.', '_thumb.', $val);
						@unlink($fpath);
						if (is_file($fpath_thumb)) @unlink($fpath_thumb);
					}
				}
				$upd[] = "FOTO_PRODUK = '" . (empty($foto) ? '' : serialize($foto)) . "'";
			}
			// ditukar
			if (count($foto) == count($ofoto) && count($foto) > 0) {
				// jika index 0 tidak sama
				if ($ofoto[0] != $foto[0]) {
					// hapus thumb yang lama
					$ofpath_thumb 	= 'upload/produk/' . str_replace('.', '_thumb.', $ofoto[0]);
					@unlink($ofpath_thumb);
					// buat thumb yang baru
					$config						= array();
					$config['source_image']		= 'upload/produk/' . $foto[0];
					$config['new_image']		= 'upload/produk/' . str_replace('.', '_thumb.', $foto[0]);
					$config['maintain_ratio']	= TRUE;
					$config['width']			= 200;
					$config['height']			= 200;
					$iofiles->image_config($config);
					$iofiles->image_resize();
				}
				$upd[] = "FOTO_PRODUK = '" . (empty($foto) ? '' : serialize($foto)) . "'";
			}
			
			if ( ! empty($upd))
				$run= $this->db->query("UPDATE produk SET " . implode(', ', $upd) . " WHERE ID_PRODUK = '$id'");
		}
		
		// handle file image
		if (isset($_FILES) && ! empty($_FILES)) {
			$run = $this->db->query("SELECT FOTO_PRODUK FROM produk WHERE ID_PRODUK = '$id'", TRUE);
			if (empty($run)) return FALSE;
			$fotos	= (empty($run->FOTO_PRODUK) ? array() : unserialize($run->FOTO_PRODUK));
			
			// maksimal 5
			$max 	= (5 - count($fotos));
			$path	= 'upload/produk/';
			$type	= 'jpeg|jpg|png';
			$fotos2	= array();
			
			for ($i = 0; $i < $max; $i++) {
				$field = 'file_' . $i;
				if ( ! isset($_FILES[$field])) continue;
				$config						= array();
				$config['upload_path']		= $path;
				$config['allowed_types']	= $type;
				$config['encrypt_name']		= TRUE;
				$config['overwrite']		= TRUE;
				$iofiles->upload_config($config);
				$iofiles->upload($field);
				
				$filename	= $iofiles->upload_get_param('file_name');
				$fotos2[]	= $filename;
				$filepath	= $path . $filename;
				if ($i == 0 && count($fotos) == 0) {
					// buat thumbnail
					$filethumb					= str_replace('.', '_thumb.', $filepath);
					$config						= array();
					$config['source_image']		= $filepath;
					$config['new_image']		= $filethumb;
					$config['maintain_ratio']	= TRUE;
					$config['width']			= 200;
					$config['height']			= 200;
					$iofiles->image_config($config);
					$iofiles->image_resize();
				}
			}
			
			// merge fotos dengan fotos2
			$afotos	= array_merge($fotos, $fotos2);
			$upd	= $this->db->query("UPDATE produk SET FOTO_PRODUK = '" . serialize($afotos) . "' WHERE ID_PRODUK = '$id'");
		}
		
		return array( 'type'	=> TRUE );
	}
	
	public function delete($id) {
		$id			= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$run		= $this->db->query("SELECT FOTO_PRODUK FROM produk WHERE ID_PRODUK = '$id'", TRUE);
		if (empty($run)) return FALSE;
		if ( ! empty($run->FOTO_PRODUK)) {
			$fotos	= unserialize($run->FOTO_PRODUKUTAMA);
			foreach ($fotos as $val) {
				$patht	= 'upload/produk/' . str_replace('.', '_thumb.', $val);
				@unlink('upload/produk/' . $val);
				if (is_file($patht)) @unlink($patht);
			}
		}
		$upd 		= $this->db->query("UPDATE produk SET STATUS_PRODUK = '0' WHERE ID_PRODUK = '$id'");
		return array('type' => TRUE);
	}
	
	public function get_order($kodemember) {
		extract($this->prepare_get(array('kode')));
		$id		= filter_var($kode, FILTER_SANITIZE_NUMBER_INT);
		if (empty($id)) return FALSE;
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kodemember'", TRUE);
		$idmember = $run->ID_ANGGOTA;
		$run	= $this->db->query("SELECT a.* FROM penjualan a, anggota b WHERE a.ID_ANGGOTA = b.ID_ANGGOTA AND a.ID_ANGGOTA = '$idmember' AND a.ID_PENJUALAN = '$id'", TRUE);
		if (empty($run)) return FALSE;
		$r['id']		= $run->ID_PENJUALAN;
		$r['nama']		= $run->NAMA_PENJUALAN;
		$r['alamat']	= $run->ALAMAT_PENJUALAN;
		$r['telepon']	= $run->TELEPON_PENJUALAN;
		$r['ongkir']	= number_format($run->ONGKIR_PENJUALAN, 0, ',', '.');
		$r['tanggal']	= datedb_to_tanggal($run->TANGGAL_PENJUALAN, 'd/m/Y');
		$r['akhir']		= datedb_to_tanggal($run->AKHIR_PENJUALAN, 'd/m/Y');
		// cari rincian
		$r['subtotal']	= 0;
		$r['produk']	= array();
		$run	= $this->db->query("SELECT a.JUMLAH_RINCIPENJUALAN, a.BIAYA_RINCIPENJUALAN, b.ID_PRODUKUTAMA, b.NAMA_PRODUKUTAMA FROM rincipenjualan a, produkutama b WHERE a.ID_PENJUALAN = '$id' AND a.ID_PRODUKUTAMA = b.ID_PRODUKUTAMA");
		foreach ($run as $val) {
			$r['subtotal'] += $val->BIAYA_RINCIPENJUALAN;
			$r['produk'][] = array(
				'id'	=> $val->ID_PRODUKUTAMA,
				'nama'	=> $val->NAMA_PRODUKUTAMA,
				'jumlah'=> $val->JUMLAH_RINCIPENJUALAN,
				'harga'	=> number_format(($val->BIAYA_RINCIPENJUALAN / $val->JUMLAH_RINCIPENJUALAN), 0, ',', '.'),
				'total'	=> number_format($val->BIAYA_RINCIPENJUALAN, 0, ',', '.')
			);
		}
		$r['subtotal']	= number_format($r['subtotal'], 0, ',', '.');
		$r['total']		= number_format(str_replace('.', '', $r['subtotal']) + str_replace('.', '', $r['ongkir']), 0, ',', '.');
		return $r;
	}
	
	public function get_order_by_id($id) {
		$id = filter_var($id, FILTER_SANITIZE_NUMBER_FLOAT);
		$run	= $this->db->query("SELECT a.*, b.NAMA_ANGGOTA, b.ALAMAT_ANGGOTA, b.TELEPON_ANGGOTA FROM penjualan a, anggota b WHERE a.ID_ANGGOTA = b.ID_ANGGOTA AND a.ID_PENJUALAN = '$id'", TRUE);
		if (empty($run)) return FALSE;
		$r['id']		= $run->ID_PENJUALAN;
		$r['nama']		= $run->NAMA_PENJUALAN;
		$r['alamat']	= $run->ALAMAT_PENJUALAN;
		$r['telepon']	= $run->TELEPON_PENJUALAN;
		$r['ongkir']	= number_format($run->ONGKIR_PENJUALAN, 0, ',', '.');
		$r['tanggal']	= datedb_to_tanggal($run->TANGGAL_PENJUALAN, 'd/m/Y');
		$r['akhir']		= datedb_to_tanggal($run->AKHIR_PENJUALAN, 'd/m/Y');
		
		// data member
		$member_nama	= $run->NAMA_ANGGOTA;
		$member_alamat	= $run->ALAMAT_ANGGOTA;
		$member_telepon	= $run->TELEPON_ANGGOTA;
		
		// cari rincian
		$r['subtotal']	= 0;
		$r['produk']	= array();
		$run	= $this->db->query("SELECT a.JUMLAH_RINCIPENJUALAN, a.BIAYA_RINCIPENJUALAN, b.ID_PRODUKUTAMA, b.NAMA_PRODUKUTAMA FROM rincipenjualan a, produkutama b WHERE a.ID_PENJUALAN = '$id' AND a.ID_PRODUKUTAMA = b.ID_PRODUKUTAMA");
		foreach ($run as $val) {
			$r['subtotal'] += $val->BIAYA_RINCIPENJUALAN;
			$r['produk'][] = array(
				'id'	=> $val->ID_PRODUKUTAMA,
				'nama'	=> $val->NAMA_PRODUKUTAMA,
				'jumlah'=> $val->JUMLAH_RINCIPENJUALAN,
				'harga'	=> number_format(($val->BIAYA_RINCIPENJUALAN / $val->JUMLAH_RINCIPENJUALAN), 0, ',', '.'),
				'total'	=> number_format($val->BIAYA_RINCIPENJUALAN, 0, ',', '.')
			);
		}
		$r['subtotal']	= number_format($r['subtotal'], 0, ',', '.');
		$r['total']		= number_format(str_replace('.', '', $r['subtotal']) + str_replace('.', '', $r['ongkir']), 0, ',', '.');
		
		return array(
			'invoice'		=> $r,
			'member_nama'	=> $member_nama,
			'member_alamat'	=> $member_alamat,
			'member_telepon'=> $member_telepon
		);
	}
	
	public function get_order_list($kode) {
		$kode	= $this->db->escape_str($kode);
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode'", TRUE);
		if (empty($run)) return FALSE;
		// update
		$upd		= $this->db->query("UPDATE penjualan SET STATUS_PENJUALAN = '2' WHERE NOW() > AKHIR_PENJUALAN AND STATUS_PENJUALAN = '1'");
		$r 			= array();
		$idmember	= $run->ID_ANGGOTA;
		$run	= $this->db->query("SELECT * FROM penjualan WHERE ID_ANGGOTA = '$idmember' AND STATUS_PENJUALAN NOT IN('2', '3')");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$produk = array();
				$harga	= 0;
				$srun = $this->db->query("SELECT a.NAMA_PRODUKUTAMA, b.BIAYA_RINCIPENJUALAN FROM produkutama a, rincipenjualan b WHERE a.ID_PRODUKUTAMA = b.ID_PRODUKUTAMA AND b.ID_PENJUALAN = '{$val->ID_PENJUALAN}'");
				foreach ($srun as $sval) {
					$produk[] 	= $sval->NAMA_PRODUKUTAMA;
					$harga		+= $sval->BIAYA_RINCIPENJUALAN;
				}
				$tanggal= array(
					datedb_to_tanggal($val->TANGGAL_PENJUALAN, 'd/m/Y'),
					datedb_to_tanggal($val->AKHIR_PENJUALAN, 'd/m/Y')
				);
				if ($val->KIRIM_PENJUALAN != '0000-00-00 00:00:00') $tanggal[] = datedb_to_tanggal($val->KIRIM_PENJUALAN, 'd/m/Y');
				switch ($val->STATUS_PENJUALAN) {
					case '1': $status = 'menunggu'; break;
					case '4': $status = 'dikonfirmasi'; break;
					case '5': $status = 'diproses'; break;
					case '6': $status = 'dikirim'; break;
				}
				
				$r[] = array(
					'id'	=> $val->ID_PENJUALAN,
					'nama'	=> $val->NAMA_PENJUALAN,
					'alamat'=> $val->ALAMAT_PENJUALAN,
					'telepon'=>$val->TELEPON_PENJUALAN,
					'tanggal'=>$tanggal,
					'status'=> $val->STATUS_PENJUALAN,
					'ongkir'=> number_format($val->ONGKIR_PENJUALAN, 0, ',', '.'),
					'produk'=> $produk,
					'harga'	=> number_format($harga, 0, ',', '.'),
					'total'	=> number_format($harga + $val->ONGKIR_PENJUALAN, 0, ',', '.'),
					'info'	=> $val->INFO_PENJUALAN,
					'status_data' => $status
				);
			}
		}
		return $r;
	}
	
	public function save_order($kode, $id = 0) {
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode'", TRUE);
		if (empty($run)) return FALSE;
		$idmember	= $run->ID_ANGGOTA;
		extract($this->prepare_post(array('nama', 'alamat', 'telepon', 'produk', 'ongkir', 'status')));
		
		$status = filter_var($status, FILTER_SANITIZE_NUMBER_INT);
		if ( ! empty($status)) {
			$id	= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
			$up = $this->db->query("UPDATE penjualan SET STATUS_PENJUALAN = '$status' WHERE ID_PENJUALAN = '$id'");
			return array('type' => TRUE);
		}
		
		$nama	= $this->db->escape_str($nama);
		$alamat	= $this->db->escape_str($alamat);
		$telepon= $this->db->escape_str($telepon);
		$ongkir	= filter_var($ongkir, FILTER_SANITIZE_NUMBER_INT);
		if ( ! is_array($produk)) return FALSE;
		
		$this->db->query("START TRANSACTION");
		foreach ($produk as $key => $val) {
			$id 	= $val['id'];
			// cari harga
			$run	= $this->db->query("SELECT HARGA_PRODUKUTAMA FROM produkutama WHERE ID_PRODUKUTAMA = '$id'", TRUE);
			if ( ! empty($run)) {
				$subtotal	= $run->HARGA_PRODUKUTAMA * $val['jumlah'];
				$produk[$key]['total'] = $subtotal;
			}
		}
		$jual	= time();
		$akhir	= $jual + (7 * 24 * 60 * 60);
		$ins	= $this->db->query("INSERT INTO penjualan VALUES(0, '$idmember', '$nama', '$alamat', '$telepon', '$ongkir', '" . date('Y-m-d H:i:s', $jual) . "', '" . date('Y-m-d H:i:s', $akhir) . "', '', '', '1')");
		$idord	= $this->db->get_insert_id();
		foreach ($produk as $val) {
			$id		= $val['id'];
			$jumlah	= $val['jumlah'];
			$total	= $val['total'];
			$ins 	= $this->db->query("INSERT INTO rincipenjualan VALUES(0, '$idord', '$id', '$jumlah', '$total')");
		}
		
		$this->db->query("COMMIT");
		return array('type' => TRUE);
	}
	
	public function confirm_order($kode) {
		extract($this->prepare_post(array('id', 'pesan', 'bayar', 'rekening')));
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$pesan	= $this->db->escape_str($pesan);
		$rekening= filter_var($rekening, FILTER_SANITIZE_NUMBER_INT);
		$bayar	= filter_var($bayar, FILTER_SANITIZE_NUMBER_INT);
		// cari rekening
		$run	= $this->db->query("SELECT * FROM rekening WHERE ID_REKENING = '$rekening'", TRUE);
		$rektext= $run->BANK_REKENING . ' / ' . $run->NOMOR_REKENING . ' / ' . $run->AN_REKENING;
		// update info
		$text 	= "KONFIRMASI PEMBAYARAN\r\n<br>REKENING: $rektext\r\n<br>BAYAR: Rp. $bayar,-\r\n<br>PESAN: $pesan";
		$run	= $this->db->query("UPDATE penjualan SET INFO_PENJUALAN = '$text' WHERE ID_PENJUALAN = '$id'");
		/*
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode'", TRUE);
		if (empty($run)) return FALSE;
		$idmember	= $run->ID_ANGGOTA;
		$main	= '(-_____-)KONFIRMASI PEMBAYARAN UNTUK PEMESANAN DENGAN ID: ' . $id . "\r\n";
		$main  .= $pesan;
		// cari admin
		$run	= $this->db->query("SELECT ID_ADMIN FROM admin WHERE STATUS_ADMIN = '1'");
		foreach ($run as $val) $values[] = "(0, '$idmember', '" . $val->ID_ADMIN . "', NOW(), '$main', '1', '5')";
		// insert
		$run 	= $this->db->query("INSERT INTO pesan VALUES" . implode(', ', $values));
		*/
		return array('type' => TRUE);
	}
	
	public function get_kategori_fproduk() {
		$r 		= array();
		$run	= $this->db->query("SELECT b.ID_KATPRODUK, b.NAMA_KATPRODUK FROM produkutama a, katproduk b WHERE a.ID_KATPRODUK = b.ID_KATPRODUK GROUP BY a.ID_KATPRODUK");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$r[] = array(
					'nama'	=> $val->NAMA_KATPRODUK,
					'id'	=> $val->ID_KATPRODUK
				);
			}
		}
		return $r;
	}
}