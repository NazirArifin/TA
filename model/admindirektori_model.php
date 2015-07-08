<?php
/**
 * Direktori Model
 */
namespace Model;

//set_time_limit(0);

class AdmindirektoriModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	private function return_error() {
		return array( 'type' => FALSE );
	}
	
	public function show() {
		extract($this->prepare_get(array('cpage', 'query', 'order', 'sort', 'num', 'status')));
		$cpage 	= intval($cpage);
		$status	= intval($status);
		$query 	= $this->db->escape_str($query);
		$num 	= intval($num);
		$sort	= ($sort == 'asc' ? 'ASC' : 'DESC');
		$status	= ( ! empty($status) ? "a.STATUS_DIREKTORI = '$status'" : "a.STATUS_DIREKTORI != '0'");
		if ( ! in_array($order, array('nama', 'kategori', 'kota', 'alamat', 'telepon'))) $order = 'nama';
		
		switch ($order) {
			case 'nama': 		$kolom = 'a.NAMA_DIREKTORI'; break;
			case 'kategori': 	$kolom = 'b.NAMA_KATDIR'; break;
			case 'kota': 		$kolom = 'c.NAMA_KOTA'; break;
			case 'alamat': 		$kolom = 'a.ALAMAT_DIREKTORI'; break;
			case 'telepon': 	$kolom = 'a.TELEPON_DIREKTORI'; break;
		}
		
		// total halaman
		$run 	= $this->db->query("SELECT COUNT(a.ID_DIREKTORI) AS HASIL FROM direktori a, katdir b, kota c WHERE a.ID_KATDIR = b.ID_KATDIR AND a.ID_KOTA = c.ID_KOTA AND $kolom LIKE '%{$query}%' AND $status", TRUE);
		$total 	= $run->HASIL;
		$numpg	= ceil($total / $num);
		$start	= $cpage * $num;
		
		// cari data
		$r			= array();
		$run		= $this->db->query("SELECT a.ID_DIREKTORI, a.NAMA_DIREKTORI, a.ALAMAT_DIREKTORI, a.TELEPON_DIREKTORI, a.STATUS_DIREKTORI, b.NAMA_KATDIR, c.NAMA_KOTA FROM direktori a, katdir b, kota c WHERE a.ID_KATDIR = b.ID_KATDIR AND a.ID_KOTA = c.ID_KOTA AND $kolom LIKE '%{$query}%' AND $status ORDER BY $kolom $sort LIMIT $start, $num");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$alamat	= json_decode($val->ALAMAT_DIREKTORI);
				$alamat	= (empty($alamat[1]) ? $alamat[0] : implode('<br>', $alamat));
				$tlp	= json_decode($val->TELEPON_DIREKTORI);
				$tlp	= (empty($tlp[1]) ? $tlp[0] : implode('<br>', $tlp));
				$status	= ($val->STATUS_DIREKTORI == 1 ? 'Aktif' : 'Non Aktif');
				$r[] = array(
					'link' =>	'direktori/' . $val->ID_DIREKTORI . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_DIREKTORI)),
					'id' => 	$val->ID_DIREKTORI,
					'nama' => 	$val->NAMA_DIREKTORI,
					'kat' => 	$val->NAMA_KATDIR,
					'kota' => 	$val->NAMA_KOTA,
					'alamat' => $alamat,
					'telepon' =>$tlp,
					'status' => $status
				);
			}
		}
		
		return array(
			'type' => 		TRUE,
			'direktori' => 	$r,
			'numpage' => 	$numpg
		);
	}
	
	public function detail($id) {
		$id 		= intval($id);
		$run 		= $this->db->query("SELECT * FROM direktori WHERE ID_DIREKTORI = '$id'", TRUE);
		if (empty($run)) return FALSE;
		$alamat		= json_decode($run->ALAMAT_DIREKTORI);
		$telepon 	= json_decode($run->TELEPON_DIREKTORI);
		$koordinat	= json_decode($run->KOORDINAT_DIREKTORI);
		$direktori 	= array(
			'id' 		=> $id,
			'kategori' 	=> $run->ID_KATDIR,
			'nama' 		=> $run->NAMA_DIREKTORI,
			'pemilik' 	=> $run->PEMILIK_DIREKTORI,
			'kota' 		=> $run->ID_KOTA,
			'info' 		=> $run->INFO_DIREKTORI,
			'email' 	=> $run->EMAIL_DIREKTORI,
			'web'		=> $run->WEB_DIREKTORI,
            'subdomain' => ( ! empty($run->WEB_DIREKTORI)),
			'im'		=> json_decode($run->CHAT_DIREKTORI),
			'sm'		=> json_decode($run->SOCMED_DIREKTORI),
			'alamat'	=> $alamat[0],
			'alamat2'	=> $alamat[1],
			'telepon'	=> $telepon[0],
			'telepon2'	=> $telepon[1],
			'koordinat'	=> $koordinat[0],
			'koordinat2'=> $koordinat[1],
			'image'		=> (empty($run->FOTO_DIREKTORI) ? 'upload/direktori/default.png' : 'upload/direktori/' . str_replace('.', '_thumb.', $run->FOTO_DIREKTORI))
		);
		return array(
			'type' 		=> TRUE,
			'direktori'	=> $direktori
		);
	}
	
	public function add($id, $iofiles) {
		$r 			= array( 'type' => TRUE );
		$mode 		= 'tambah';
		extract($this->prepare_post(array('kategori', 'nama', 'pemilik', 'kota', 'alamat', 'alamat2', 'telepon', 'telepon2', 'info', 'email', 'koordinat', 'koordinat2', 'im', 'sm', 'web', 'status')));
		
		// casting
		$id 		= intval($id);
		$kategori 	= intval($kategori);
		$kota 		= intval($kota);
		$nama 		= $this->db->escape_str($nama);
		$pemilik 	= $this->db->escape_str($pemilik);
		$alamat 	= $this->db->escape_str($alamat);
		$alamat2 	= $this->db->escape_str($alamat2);
		$telepon 	= $this->db->escape_str($telepon);
		$telepon2 	= $this->db->escape_str($telepon2);
		$info 		= $this->db->escape_str($info);
		$email 		= $this->db->escape_str(filter_var($email, FILTER_SANITIZE_EMAIL));
		$web 		= $this->db->escape_str(filter_var($web, FILTER_SANITIZE_URL));
		$koordinat 	= $this->db->escape_str($koordinat);
		$koordinat2 = $this->db->escape_str($koordinat2);
		
		// hanya ubah status
		switch($status) {
			case 1: case 2: break;
			default: $status = 0;
		}
		if ( ! empty($status)) {
			$upd = $this->db->query("UPDATE direktori SET STATUS_DIREKTORI = '$status' WHERE ID_DIREKTORI = '$id'");
			if (empty($upd)) return FALSE;
			return $r;
		}
		
		// validasi
		$v = TRUE;
		if ( ! is_array($im)) 		$v = FALSE;
		if ( ! is_array($sm)) 		$v = FALSE;
		$imt 	= array('wa', 'bbm', 'line', 'wechat');
		$smt 	= array('fb', 'twitter', 'gplus', 'ig');
		foreach ($imt as $val) {
			if ( ! isset($im[$val])) $im[$val] = '';
		}
		foreach ($smt as $val) {
			if ( ! isset($sm[$val])) $sm[$val] = '';
			else $sm[$val] = filter_var($sm[$val], FILTER_SANITIZE_URL);
		}
		if (empty($kategori)) 		$v = FALSE;
		if (strlen($nama) < 5) 		$v = FALSE;
		if (empty($kota)) 			$v = FALSE;
		if (strlen($telepon) < 6) 	$v = FALSE;
		if (strlen($info) < 5) 		$v = FALSE;
		
		if ( ! $v) return $this->return_error();
		
		// kumpulkan
		$calamat 	= array($alamat, $alamat2);
		$ctelepon 	= array($telepon, $telepon2);
		$ckoordinat = array($koordinat, $koordinat2);
		
		// tambah data
		$getid 			= 0;
		if (empty($id)) {
			$ins 		= $this->db->query("INSERT INTO direktori VALUES(0, '$kategori', '$kota', '$nama', '$email', '', '" . json_encode($calamat) . "', '" . json_encode($ctelepon) . "', '$pemilik', '" . json_encode($ckoordinat) . "', '$info', '$web', '" . json_encode($im) . "', '" . json_encode($sm) . "', '1')");
			if ($ins === FALSE) return $this->return_error();
			$getid 	= $this->db->get_insert_id();
		} else {
			$mode 		= 'edit';
			$getid 		= $id;
			$upd		= array();
			$jalamat	= json_encode($calamat);
			$jtelepon	= json_encode($ctelepon);
			$jkoordinat	= json_encode($ckoordinat);
			$jim		= json_encode($im);
			$jsm		= json_encode($sm);
			$run 		= $this->db->query("SELECT * FROM direktori WHERE ID_DIREKTORI = '$id'", TRUE);
			if (empty($run)) return FALSE;
			if ($kategori != $run->ID_KATDIR) 				$upd[] = "ID_KATDIR = '$kategori'";
			if ($kota != $run->ID_KOTA) 					$upd[] = "ID_KOTA = '$kota'";
			if ($nama != $run->NAMA_DIREKTORI) 				$upd[] = "NAMA_DIREKTORI = '$nama'";
			if ($email != $run->EMAIL_DIREKTORI) 			$upd[] = "EMAIL_DIREKTORI = '$email'";
			if ($jalamat != $run->ALAMAT_DIREKTORI) 		$upd[] = "ALAMAT_DIREKTORI = '$jalamat'";
			if ($jtelepon != $run->TELEPON_DIREKTORI) 		$upd[] = "TELEPON_DIREKTORI = '$jtelepon'";
			if ($pemilik != $run->PEMILIK_DIREKTORI) 		$upd[] = "PEMILIK_DIREKTORI = '$pemilik'";
			if ($jkoordinat != $run->KOORDINAT_DIREKTORI) 	$upd[] = "KOORDINAT_DIREKTORI = '$jkoordinat'";
			if ($info != $run->INFO_DIREKTORI) 				$upd[] = "INFO_DIREKTORI = '$info'";
			if ($web != $run->WEB_DIREKTORI) 				$upd[] = "WEB_DIREKTORI = '$web'";
			if ($jim != $run->CHAT_DIREKTORI) 				$upd[] = "CHAT_DIREKTORI = '$jim'";
			if ($jsm != $run->SOCMED_DIREKTORI) 			$upd[] = "SOCMED_DIREKTORI = '$jsm'";
			if ( ! empty($upd)) $run = $this->db->query("UPDATE direktori SET " . implode(', ', $upd) . " WHERE ID_DIREKTORI = '$id'");
		}
		
		// jika ada file foto
		if (isset($_FILES['file'])) {
			if ( ! empty($getid)) {
				// hapus foto
				$run = $this->db->query("SELECT FOTO_DIREKTORI FROM direktori WHERE ID_DIREKTORI = '$getid'", TRUE);
				if ( ! empty($run)) @unlink('upload/direktori/' . $run->FOTO_DIREKTORI);
				
				$config['upload_path']		= 'upload/direktori/';
				$config['allowed_types']	= 'jpeg|jpg|png';
				$config['encrypt_name']		= TRUE;
				$config['overwrite']		= TRUE;
				$iofiles->upload_config($config);
				$iofiles->upload('file');
				
				// buat thumbnail
				$filename 					= $iofiles->upload_get_param('file_name');
				$filepath					= 'upload/direktori/' . $filename;
				$config 					= array();
				$filethumb					= str_replace('.', '_thumb.', $filepath);
				$config['source_image']		= $filepath;
				$config['new_image']		= $filethumb;
				$config['maintain_ratio']	= TRUE;
				$config['width']			= 120;
				$config['height']			= 120;
				$iofiles->image_config($config);
				$iofiles->image_resize();
				
				// update tabel
				$upd = $this->db->query("UPDATE direktori SET FOTO_DIREKTORI = '$filename' WHERE ID_DIREKTORI = '$getid'");
			}
		}
		
		return $r;
	}
	
	public function delete($id) {
		$id		= intval($id);
		$del 	= $this->db->query("UPDATE direktori SET STATUS_DIREKTORI = '0' WHERE ID_DIREKTORI = '$id'");
		if (empty($del)) return FALSE;
		return array(
			'type' => TRUE
		);
	}
	
	public function save_new_direktori() {
		extract($this->prepare_post(array('id', 'status')));
		$id = intval($id);
		$status = intval($status);
		$cari = $this->db->query("SELECT * FROM prosesdirektori WHERE ID_PROSESDIREKTORI = '$id'", true);
		if (empty($cari)) return array('type' => false);
		$direktori = $cari->ID_DIREKTORI;
		$anggota = $cari->ID_ANGGOTA;
		$foto = $cari->FOTO_PROSESDIREKTORI;
		
		// disetujui
		if ($status == 1) {
			if (empty($foto)) {
				// ubah status direktori
				$upd = $this->db->query("UPDATE direktori SET STATUS_DIREKTORI = '1' WHERE ID_DIREKTORI = '$direktori'");
			} else {
				// set pemilik di direktori
				$upd = $this->db->query("UPDATE direktori SET PEMILIK_DIREKTORI = '$anggota' WHERE ID_DIREKTORI = '$direktori'");
			}
			// hapus prosesdirektori
			$del = $this->db->query("DELETE FROM prosesdirektori WHERE ID_PROSESDIREKTORI = '$id'");
		}
		
		// ditolak
		if ($status == 0) {
			if (empty($foto)) {
				// ubah status direktori jadi 0
				$upd = $this->db->query("UPDATE direktori SET STATUS_DIREKTORI = '0' WHERE ID_DIREKTORI = '$direktori'");
			} else {
				// hapus foto
				@unlink('upload/direktori/' . $foto);
			}
			// hapus prosesdirektori
			$del = $this->db->query("DELETE FROM prosesdirektori WHERE ID_PROSESDIREKTORI = '$id'");
		}
		return array('type' => true);
	}
}