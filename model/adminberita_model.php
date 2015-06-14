<?php
/**
 * Berita Model
 */
namespace Model;

//set_time_limit(0);

class AdminberitaModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function show($type) {
		switch ($type) {
			case 'bisnis': 	$tabel = 'berita'; 	$utabel = 'BERITA';	break;
			case 'info':	$tabel = 'info'; 	$utabel = 'INFO'; 	break;
			default: return FALSE;
		}
		
		extract($this->prepare_get(array('cpage', 'numpage', 'date', 'query', 'numdt', 'order', 'sort', 'status')));
		$cpage	= intval($cpage);
		$numdt	= intval($numdt);
		$query	= $this->db->escape_str($query);
		$sort	= ($sort == 'asc' ? 'ASC' : 'DESC');
		
		if ( ! empty($date)) {
			$dates = explode(' - ', $date);
			if (count($dates) != 2) return FALSE;
			$start_date	= tanggal_to_datedb($dates[0]);
			$end_date	= tanggal_to_datedb($dates[1]);
		}
		if ( ! in_array($order, array('title', 'date', 'state'))) $order = 'date';
		$kolom	= "TANGGAL_{$utabel} $sort";
		switch ($order) {
			case 'title': $kolom	= "JUDUL_{$utabel} $sort, ISI_{$utabel} $sort"; break;
			case 'state': $kolom	= "STATUS_{$utabel} $sort"; break;
		}
		if ( ! in_array($status, array('', '1', '2'))) 	$status = '';
		$where[]	= "STATUS_{$utabel} != '0'";
		if ( ! empty($query))
			$where[]	= "(JUDUL_{$utabel} LIKE '%{$query}%' OR ISI_{$utabel} LIKE '%{$query}%')";
		if ( ! empty($data)) {
			if ($start_date != $end_date)
				$where[]	= "(TANGGAL_{$utabel} BETWEEN '{$start_date}' AND '{$end_date}')";
			else {
				$where[]	= "TANGGAL_{$utabel} = '$start_date'";
			}
		}
				
		// total halaman
		$run	= $this->db->query("SELECT COUNT(ID_{$utabel}) AS HASIL FROM $tabel WHERE " . implode(" AND ", $where), TRUE);
		$numpg	= ceil($run->HASIL / $numdt);
		$start 	= $cpage * $numdt;
		$r 		= array();
		$path	= 'upload/news/';
		
		// cari data
		$run	= $this->db->query("SELECT * FROM $tabel WHERE " . implode(" AND ", $where) . " ORDER BY " . $kolom . " LIMIT $start, $numdt");
		if ( ! empty($run)) {
			if ($type == 'bisnis') {
				foreach ($run as $val) {
					if ( ! empty($val->FOTO_BERITA)) {
						$foto 	= $path . $val->FOTO_BERITA;
					} else $foto = $path . 'default.png';
					$isi = array(
						'pengantar' => $val->PENGANTAR_BERITA,
						'isi'		=> $val->ISI_BERITA
					);//unserialize($val->ISI_BERITA);
					if (strlen($isi['pengantar']) > 0) $data = strip_tags($isi['pengantar']);
					else $data = strip_tags($isi['isi']);
					
					$r[] 	= array(
						'id'		=> $val->ID_BERITA,
						'judul'		=> $val->JUDUL_BERITA,
						'link'		=> 'berita/' . datedb_to_tanggal($val->TANGGAL_BERITA, 'dmY') . '/' . preg_replace('/[^0-9a-z]/', '-', strtolower($val->JUDUL_BERITA)),
						'isi'		=> token_truncate($data, 150) . (strlen($data) > 150 ? ' ...' : ''),
						'status'	=> ($val->STATUS_BERITA == '1' ? 'Aktif' : 'Nonaktif'),
						'foto'		=> $foto,
						'tag'		=> $val->TAG_BERITA,
						'tanggal'	=> datedb_to_tanggal($val->TANGGAL_BERITA, 'd/m/Y H:i')
					);
				}
			}
			if ($type == 'info') {
				foreach ($run as $val) {
					if ( ! empty($val->FOTO_INFO)) {
						$foto 	= $path . $val->FOTO_INFO;
					} else $foto = $path . 'default.png';
					$data = strip_tags($val->ISI_INFO);
					$data = str_replace(array('&nbsp;'), array(' '), $data);
					
					$r[] 	= array(
						'id'		=> $val->ID_INFO,
						'judul'		=> $val->JUDUL_INFO,
						'link'		=> 'info/' . datedb_to_tanggal($val->TANGGAL_INFO, 'dmY') . '/' . preg_replace('/[^0-9a-z]/', '-', strtolower($val->JUDUL_INFO)),
						'isi'		=> token_truncate($data, 150) . (strlen($data) > 150 ? ' ...' : ''),
						'status'	=> ($val->STATUS_INFO == '1' ? 'Aktif' : 'Nonaktif'),
						'foto'		=> $foto,
						'tag'		=> FALSE,
						'tanggal'	=> datedb_to_tanggal($val->TANGGAL_INFO, 'd/m/Y H:i')
					);
				}
			}
		}
		
		return array(
			'type'		=> TRUE,
			'berita'	=> $r,
			'numpage'	=> $numpg
		);
	}
	
	public function detail($type, $id) {
		switch ($type) {
			case 'bisnis': 	$tabel = 'berita'; break;
			case 'info':	$tabel = 'info'; break;
			default: return FALSE;
		}
		
		$id		= intval($id);
		$run 	= $this->db->query("SELECT * FROM $tabel WHERE ID_" . strtoupper($tabel) . " = '$id'", TRUE);
		if (empty($run)) return FALSE;
		$path	= 'upload/news/';
		if ($type == 'bisnis') {
			$data	= array(
				'pengantar'	=> $run->PENGANTAR_BERITA,
				'isi'		=> $run->ISI_BERITA
			);
			if ( ! empty($run->FOTO_BERITA)) {
				$foto 	= $path . $run->FOTO_BERITA;
			} else $foto = $path . 'default.png';
			$berita = array(
				'id'		=> $run->ID_BERITA,
				'judul'		=> $run->JUDUL_BERITA,
				'pengantar'	=> $data['pengantar'],
				'isi'		=> $data['isi'],
				'keyword'	=> $run->TAG_BERITA,
				'foto'		=> $foto
			);
		}
		if ($type == 'info') {
			if ( ! empty($run->FOTO_INFO)) {
				$foto 	= $path . $run->FOTO_INFO;
			} else $foto = $path . 'default.png';
			$berita = array(
				'id' 	=> $run->ID_INFO,
				'judul'	=> $run->JUDUL_INFO,
				'isi'	=> $run->ISI_INFO,
				'foto'	=> $foto
			);
		}
		
		return array(
			'type' 		=> TRUE,
			'berita' 	=> $berita
		);
	}
	
	public function add($type, $id = 0, $token = array(), $iofiles = null) {
		switch ($type) {
			case 'bisnis': 	$tabel = 'berita'; break;
			case 'info':	$tabel = 'info'; break;
			default: return FALSE;
		}
		extract($this->prepare_post(array('judul', 'pengantar', 'isi', 'keyword', 'status')));
		
		if ( ! empty($status)) {
			switch ($status) {
				case 1: case 2: break;
				default: return FALSE;
			}
			$kolom	= strtoupper('STATUS_' . $tabel);
			$idtbl	= strtoupper('ID_' . $tabel);
			$id		= intval($id);
			$run	= $this->db->query("UPDATE $tabel SET $kolom = '$status' WHERE $idtbl = '$id'");
			return array( 'type'	=> TRUE );
		}
		
		$judul	= $this->db->escape_str($judul);
		$pengtr	= strip_tags($this->db->escape_str($pengantar));
		$keywd	= $this->db->escape_str($keyword);
		$isi	= $this->db->escape_str($isi);
		if ($type == 'info') $pengtr = '';
		$query	= '';
		$akeywd	= explode(',', $keywd);
		$bkeywd = array();
		foreach ($akeywd as $val) {
			$tval = trim($val);
			if (empty($tval)) continue;
			$bkeywd[] = $tval;
		}
		$keywd	= implode(', ', $bkeywd);
		
		if (empty($id)) {
			// tambah data
			if ($type == 'bisnis')
				$query	= "INSERT INTO $tabel VALUES(0, '" . $token['id'] . "', '$judul', '$pengtr', '$isi', '', NOW(), '$keywd', '1')";
			if ($type == 'info')
				$query	= "INSERT INTO $tabel VALUES(0, '" . $token['id'] . "', '$judul', '$isi', '', NOW(), '1')";
			if ( ! empty($query)) {
				$ins	= $this->db->query($query);
				$id 	= $this->db->get_insert_id();
			}
		} else {
			// edit data
			$id		= intval($id);
			$data	= $this->db->query("SELECT * FROM $tabel WHERE ID_". strtoupper($tabel) ." = '$id'", TRUE);
			if (empty($data)) return TRUE;
			$upd	= array();
			
			if ($type == 'bisnis') {
				if ($judul != $data->JUDUL_BERITA) 	$upd[] = "JUDUL_BERITA = '$judul'";
				if ($isi != $data->ISI_BERITA) 		$upd[] = "ISI_BERITA = '$isi'";
				if ($pengtr != $data->PENGANTAR_BERITA) $upd = "PENGANTAR_BERITA = '$pengtr'";
				if ($keywd != $data->TAG_BERITA)	$upd[] = "TAG_BERITA = '$keywd'";
			}
			if ($type == 'info') {
				if ($judul != $data->JUDUL_INFO)	$upd[] = "JUDUL_INFO = '$judul'";
				if ($isi != $data->ISI_INFO)		$upd[] = "ISI_INFO = '$isi'";
			}
			if ( ! empty($upd)) {
				$run 	= $this->db->query("UPDATE $tabel SET " . implode(', ', $upd) . " WHERE ID_" . strtoupper($tabel) . " = '$id'");
			}
		}
		
		// proses file jika ada
		if (isset($_FILES['file']) && ! empty($id)) {
			$run = $this->db->query("SELECT FOTO_" . strtoupper($tabel) . " FROM $tabel WHERE ID_" . strtoupper($tabel) . " = '$id'", TRUE, FALSE);
			if ( ! empty($run)) @unlink('upload/news/' . $run['FOTO_' . strtoupper($tabel)]);
			$config['upload_path']		= 'upload/news/';
			$config['allowed_types']	= 'jpeg|jpg|png';
			$config['encrypt_name']		= TRUE;
			$config['overwrite']		= TRUE;
			$iofiles->upload_config($config);
			$iofiles->upload('file');
			$filename 					= $iofiles->upload_get_param('file_name');
			// update tabel
			$upd = $this->db->query("UPDATE $tabel SET FOTO_" . strtoupper($tabel) . " = '$filename' WHERE ID_" . strtoupper($tabel) . " = '$id'");
		}
		
		return array( 'type'	=> TRUE );
	}
	
	public function delete($type, $id) {
		switch ($type) {
			case 'bisnis':	$tabel = 'berita'; break;
			case 'info':	$tabel = 'info'; break;
			default: return FALSE;
		}
		$id 	= intval($id);
		$idtbl	= strtoupper('ID_' . $tabel);
		$run 	= $this->db->query("DELETE FROM $tabel WHERE $idtbl = '$id'");
		return array( 'type'	=> TRUE );
	}
	
	public function get_tips() {
		extract($this->prepare_get(array('cpage', 'query', 'numdt', 'status', 'jenis')));
		$cpage	= intval($cpage);
		$query	= $this->db->escape_str($query);
		$numdt	= intval($numdt);
		$status	= intval($status);
		$jenis	= intval($jenis);
		
		$where[]= "STATUS_TIPSTRIK != '0'";
		if ( ! empty($query)) 	$where[] = "ISI_TIPSTRIK LIKE '%{$query}%'";
		if ( ! empty($jenis))	$where[] = "JENIS_TIPSTRIK = '$jenis'";
		
		$run	= $this->db->query("SELECT COUNT(ID_TIPSTRIK) AS HASIL FROM tipstrik" . ( ! empty($where) ? " WHERE " . implode(" AND ", $where) : ''), TRUE);
		$numpg	= ceil($run->HASIL / $numdt);
		$start	= $cpage * $numdt;
		$r 		= array();
		$run	= $this->db->query("SELECT * FROM tipstrik" . ( ! empty($where) ? " WHERE " . implode(" AND ", $where) : '') . " LIMIT $start, $numdt");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$r[] = array(
					'id'	=> $val->ID_TIPSTRIK,
					'isi'	=> $val->ISI_TIPSTRIK,
					'jenis'	=> ($val->JENIS_TIPSTRIK == '1' ? 'DAERAH' : 'MANAJEMEN'),
					'status'=> ($val->STATUS_TIPSTRIK == '1' ? 'Aktif' : 'Nonaktif')
				);
			}
		}
		return array(
			'type'		=> TRUE,
			'tips'		=> $r,
			'numpage'	=> $numpg
		);
	}
	
	public function get_tips_detail($id) {
		$id 	= intval($id);
		$run 	= $this->db->query("SELECT * FROM tipstrik WHERE ID_TIPSTRIK = '$id'", TRUE);
		if (empty($run)) return FALSE;
		return array(
			'type' 	=> TRUE,
			'tips'	=> array(
				'id'	=> $run->ID_TIPSTRIK,
				'isi'	=> $run->ISI_TIPSTRIK,
				'jenis'	=> $run->JENIS_TIPSTRIK,
				'status'=> $run->STATUS_TIPSTRIK
			)
		);
	}
	
	public function save_tips($idtips = '') {
		extract($this->prepare_post(array('id', 'isi', 'status', 'jenis')));
		$isi	= $this->db->escape_str($isi);
		$jenis	= intval($jenis);
		if ( ! empty($idtips)) {
			$id = intval($idtips);
			$run	= $this->db->query("SELECT * FROM tipstrik WHERE ID_TIPSTRIK = '$id'", TRUE);
			
			if ($run->ISI_TIPSTRIK != $isi && strlen($isi) > 0) $upd[] = "ISI_TIPSTRIK = '$isi'";
			if ($run->STATUS_TIPSTRIK != $status)				$upd[] = "STATUS_TIPSTRIK = '$status'";
			if ($run->JENIS_TIPSTRIK != $jenis)					$upd[] = "JENIS_TIPSTRIK = '$jenis'";
			
			if ( ! empty($upd)) {
				$run = $this->db->query("UPDATE tipstrik SET " . implode(", ", $upd) . " WHERE ID_TIPSTRIK = '$id'");
			}
		} else {
			$ins	= $this->db->query("INSERT INTO tipstrik VALUES(0, '$isi', '', '$jenis', '1')");
			$id		= $this->db->get_insert_id();
		}
		
		// proses file jika ada
		if (isset($_FILES['file']) && ! empty($id)) {
			$run = $this->db->query("SELECT FOTO_TIPSTRIK FROM tipstrik WHERE ID_TIPSTRIK = '$id'", true);
			if ( ! empty($run)) @unlink('upload/news/' . $run->FOTO_TIPSTRIK);
			$config['upload_path']		= 'upload/news/';
			$config['allowed_types']	= 'jpeg|jpg|png';
			$config['encrypt_name']		= TRUE;
			$config['overwrite']		= TRUE;
			$iofiles->upload_config($config);
			$iofiles->upload('file');
			$filename 					= $iofiles->upload_get_param('file_name');
			// update tabel
			$upd = $this->db->query("UPDATE tipstrik SET FOTO_TIPSTRIK = '$filename' WHERE ID_TIPSTRIK = '$id'");
		}
		
		return array('type' => TRUE);
	}
	
	public function delete_tips($id) {
		$run	= $this->db->query("UPDATE tipstrik SET STATUS_TIPSTRIK = '0' WHERE ID_TIPSTRIK = '$id'");
		return array('type' => TRUE);
	}
}