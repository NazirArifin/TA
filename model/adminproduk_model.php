<?php
/**
 * Produk Model
 */
namespace Model;

//set_time_limit(0);

class AdminprodukModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function show() {
		extract($this->prepare_get(array('cpage', 'query', 'order', 'sort', 'num', 'status')));
		$cpage 	= filter_var($cpage, FILTER_SANITIZE_NUMBER_INT);
		$status	= filter_var($status, FILTER_SANITIZE_NUMBER_INT);
		$query 	= $this->db->escape_str($query);
		$num 	= filter_var($num, FILTER_SANITIZE_NUMBER_INT);
		$sort	= ($sort == 'asc' ? 'ASC' : 'DESC');
		$status	= ( ! empty($status) ? "a.STATUS_PRODUKUTAMA = '$status'" : "a.STATUS_PRODUKUTAMA != '0'");
		if ( ! in_array($order, array('nama', 'kategori', 'harga'))) $order = 'nama';
		switch ($order) {
			case 'nama': 		$kolom = 'a.NAMA_PRODUKUTAMA'; break;
			case 'kategori': 	$kolom = 'b.NAMA_KATPRODUK'; break;
			case 'harga': 		$kolom = 'a.HARGA_PRODUKUTAMA'; break;
			case 'stok': 		$kolom = 'a.STOK_PRODUKUTAMA'; break;
		}
		
		// total halaman
		$run	= $this->db->query("SELECT COUNT(a.ID_PRODUKUTAMA) AS HASIL FROM produkutama a, katproduk b WHERE a.ID_KATPRODUK = b.ID_KATPRODUK AND a.NAMA_PRODUKUTAMA LIKE '%{$query}%' AND $status", TRUE);
		$numpg	= ceil($run->HASIL / $num);
		$start	= $cpage * $num;
		
		$r 		= array();
		$run	= $this->db->query("SELECT a.*, b.NAMA_KATPRODUK FROM produkutama a, katproduk b WHERE a.ID_KATPRODUK = b.ID_KATPRODUK AND NAMA_PRODUKUTAMA LIKE '%{$query}%' AND $status ORDER BY $kolom $sort LIMIT $start, $num");
		$path	= 'upload/produk/';
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$fotos	= ( ! empty($val->FOTO_PRODUKUTAMA) ? unserialize($val->FOTO_PRODUKUTAMA) : '');
				$status	= ($val->STATUS_PRODUKUTAMA == 1 ? 'Aktif' : 'Nonaktif');
				$info = strip_tags($val->INFO_PRODUKUTAMA);
				$r[]	= array(
					'link'	=> 'fproduk/' . $val->ID_PRODUKUTAMA . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_PRODUKUTAMA)),
					'id'	=> $val->ID_PRODUKUTAMA,
					'nama'	=> $val->NAMA_PRODUKUTAMA,
					'kat'	=> $val->NAMA_KATPRODUK,
					'status'=> $status,
					'stok'	=> $val->STOK_PRODUKUTAMA,
					'berat'	=> number_format($val->BERAT_PRODUKUTAMA, 2, ',', '.'),
					'info'	=> token_truncate($info, 80) . (strlen($info) > 80 ? ' ...' : ''),
					'harga'	=> number_format($val->HARGA_PRODUKUTAMA, 0, ',', '.') . ',-',
					'foto'	=> (empty($fotos) ? $path . 'default.png' : $path . str_replace('.', '_thumb.', $fotos[0])),
				);
			}
		}
		
		return array(
			'type'		=> TRUE,
			'produk'	=> $r,
			'numpage'	=> $numpg
		);
	}
	
	public function detail($id) {
		$id 		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$run		= $this->db->query("SELECT * FROM produkutama WHERE ID_PRODUKUTAMA = '$id'", TRUE);
		if (empty($run)) return FALSE;
		$r			= array();
		$r['id']	= $run->ID_PRODUKUTAMA;
		$r['kategori'] = $run->ID_KATPRODUK;
		$r['nama']	= $run->NAMA_PRODUKUTAMA;
		$r['harga']	= number_format($run->HARGA_PRODUKUTAMA, 0, ',', '.');
		$r['stok']	= number_format($run->STOK_PRODUKUTAMA, 0, ',', '.');
		$r['berat']	= number_format($run->BERAT_PRODUKUTAMA, 2, ',', '.');
		$r['info']	= $run->INFO_PRODUKUTAMA;
		$fotos		= ( ! empty($run->FOTO_PRODUKUTAMA) ? unserialize($run->FOTO_PRODUKUTAMA) : array());
		foreach ($fotos as $key => $val) $fotos[$key] = 'upload/produk/' . $val;
		$r['foto']	= $fotos;
		return array(
			'type'		=> TRUE, 'produk'	=> $r
		);
	}
	
	public function add($id, $iofiles) {
		extract($this->prepare_post(array('nama', 'kategori', 'info', 'harga', 'berat', 'stok', 'foto', 'status')));
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		
		if ( ! empty($status)) {
			switch ($status) {
				case 1: case 2: break;
				default: return FALSE;
			}
			$run	= $this->db->query("UPDATE produkutama SET STATUS_PRODUKUTAMA = '$status' WHERE ID_PRODUKUTAMA = '$id'");
			return array( 'type'	=> TRUE );
		}
		
		$kat	= filter_var($kategori, FILTER_SANITIZE_NUMBER_INT);
		$nama	= $this->db->escape_str($nama);
		$info	= $this->db->escape_str($info);
		$harga	= preg_replace('/[^0-9]/', '', $harga);
		$stok	= preg_replace('/[^0-9]/', '', $stok);
		$berat	= str_replace(',', '.', preg_replace('/[^0-9,]/', '', $berat));
		
		// validasi
		$valid	= TRUE;
		if (empty($kat)) 		$v = FALSE;
		if (strlen($nama) < 3) 	$v = FALSE;
		if (strlen($info) < 5) 	$v = FALSE;
		if (empty($harga))		$v = FALSE;
		if ( ! $valid) return array('type' => FALSE);
		
		if (empty($id)) {
			$ins	= $this->db->query("INSERT INTO produkutama VALUES(0, '$kat', '$nama', '$harga', '$stok', '$info', '$berat', '', '1')");
			$id 	= $this->db->get_insert_id();
		} else {
			$upd 	= array();
			$data	= $this->db->query("SELECT * FROM produkutama WHERE ID_PRODUKUTAMA = '$id'", TRUE);
			if ($kat != $data->ID_KATPRODUK)		$upd[] = "ID_KATPRODUK = '$kat'";
			if ($nama != $data->NAMA_PRODUKUTAMA)	$upd[] = "NAMA_PRODUKUTAMA = '$nama'";
			if ($info != $data->INFO_PRODUKUTAMA)	$upd[] = "INFO_PRODUKUTAMA = '$info'";
			if ($harga != $data->HARGA_PRODUKUTAMA)	$upd[] = "HARGA_PRODUKUTAMA = '$harga'";
			if ($stok != $data->STOK_PRODUKUTAMA)	$upd[] = "STOK_PRODUKUTAMA = '$stok'";
			if ($berat != $data->BERAT_PRODUKUTAMA)	$upd[] = "BERAT_PRODUKUTAMA = '$berat'";
			
			// analisa perubahan foto
			$ofoto	= (empty($data->FOTO_PRODUKUTAMA) ? array() : unserialize($data->FOTO_PRODUKUTAMA));
			$foto	= (empty($foto) ? array() : $foto);
			if ( ! empty($foto)) {
				foreach ($foto as $key => $val) $foto[$key] = str_replace('upload/produk/', '', $val);
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
				$upd[] = "FOTO_PRODUKUTAMA = '" . (empty($foto) ? '' : serialize($foto)) . "'";
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
				$upd[] = "FOTO_PRODUKUTAMA = '" . (empty($foto) ? '' : serialize($foto)) . "'";
			}
			
			if ( ! empty($upd))
				$run= $this->db->query("UPDATE produkutama SET " . implode(', ', $upd) . " WHERE ID_PRODUKUTAMA = '$id'");
		}
		
		// handle file image
		if (isset($_FILES) && ! empty($_FILES)) {
			$run = $this->db->query("SELECT FOTO_PRODUKUTAMA FROM produkutama WHERE ID_PRODUKUTAMA = '$id'", TRUE);
			if (empty($run)) return FALSE;
			$fotos	= (empty($run->FOTO_PRODUKUTAMA) ? array() : unserialize($run->FOTO_PRODUKUTAMA));
			
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
			$upd	= $this->db->query("UPDATE produkutama SET FOTO_PRODUKUTAMA = '" . serialize($afotos) . "' WHERE ID_PRODUKUTAMA = '$id'");
		}
		
		return array( 'type'	=> TRUE );
	}
	
	public function delete($id) {
		$id			= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$run		= $this->db->query("SELECT FOTO_PRODUKUTAMA FROM produkutama WHERE ID_PRODUKUTAMA = '$id'", TRUE);
		if (empty($run)) return FALSE;
		if ( ! empty($run->FOTO_PRODUKUTAMA)) {
			$fotos	= unserialize($run->FOTO_PRODUKUTAMA);
			foreach ($fotos as $val) {
				$patht	= 'upload/produk/' . str_replace('.', '_thumb.', $val);
				@unlink('upload/produk/' . $val);
				if (is_file($patht)) @unlink($patht);
			}
		}
		$upd 		= $this->db->query("UPDATE produkutama SET STATUS_PRODUKUTAMA = '0' WHERE ID_PRODUKUTAMA = '$id'");
		return array('type' => TRUE);
	}
}