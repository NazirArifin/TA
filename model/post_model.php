<?php
/**
 * Post Model
 */
namespace Model;

class PostModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_post() {
		extract($this->prepare_get(array('member', 'page', 'type')));
		if ( ! empty($type)) $type 	= ($type == 'jual' ? 1 : 2);
		$member	= $this->db->escape_str($member);
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$member'", TRUE);
		if (empty($run)) return FALSE;
		$id		= $run->ID_ANGGOTA;
		$page	= filter_var($page, FILTER_SANITIZE_NUMBER_INT);
		if (empty($page)) $page = 0;
		$where[]= "a.ID_ANGGOTA = '$id'";
		$where[]= "a.STATUS_POSTANGGOTA != '0'";
		$where[]= "a.ID_KATPRODUK = c.ID_KATPRODUK";
		if ( ! empty($type)) $where[]= "a.TIPE_POSTANGGOTA = '$type'";
		$r 		= array();
		$numdt	= 50;
		// hitung halaman
		$run	= $this->db->query("SELECT COUNT(a.ID_POSTANGGOTA) AS HASIL FROM postanggota a, katproduk c WHERE " . implode(" AND ", $where), TRUE);
		$numpg	= ceil($run->HASIL / $numdt);
		$start	= $page * $numdt;
		
		$run	= $this->db->query("SELECT a.*, c.ID_KATPRODUK, c.NAMA_KATPRODUK, COUNT(b.ID_KOMENTAR) AS KOMENTAR FROM katproduk c, postanggota a LEFT JOIN komentar b ON b.ID_POSTANGGOTA = a.ID_POSTANGGOTA WHERE " . implode(" AND ", $where) . " GROUP BY a.ID_POSTANGGOTA ORDER BY a.TANGGAL_POSTANGGOTA DESC LIMIT $start, $numdt");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				if ( ! empty($val->FOTO_POSTANGGOTA)) {
					$f 		= unserialize($val->FOTO_POSTANGGOTA);
					$foto 	= '/upload/post/' . str_replace('.', '_thumb.', $f[0]);
				} else $foto = '/upload/post/default.png';
				
				$isi 		= strip_tags($val->ISI_POSTANGGOTA);
				$ptisi		= token_truncate($isi, 150);
				if (strlen($isi) > 150) $ptisi .= '...';
				
				$r[] = array(
					'id'		=> $val->ID_POSTANGGOTA,
					'kategori'	=> $val->NAMA_KATPRODUK,
					'id_kategori' => $val->ID_KATPRODUK,
					'komentar'	=> $val->KOMENTAR,
					'judul'		=> str_replace(array('&nbsp;', '&amp;'), array(' ', '&'), $val->JUDUL_POSTANGGOTA),
					'isi'		=> str_replace(array('&nbsp;', '&amp;'), array(' ', '&'), $ptisi),
					'tipe'		=> ($val->TIPE_POSTANGGOTA == '1' ? 'jual' : 'beli'),
					'status'	=> $val->STATUS_POSTANGGOTA,
					'tanggal'	=> datedb_to_tanggal($val->TANGGAL_POSTANGGOTA, 'd M Y H:i'),
					'foto'		=> $foto,
					'link'		=> '/' . ($val->TIPE_POSTANGGOTA == '1' ? 'jual' : 'beli') . '/' . $val->ID_POSTANGGOTA . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->JUDUL_POSTANGGOTA))
				);
			}
		}
		return array(
			'type'		=> TRUE,
			'kiriman'	=> $r,
			'numpage'	=> $numpg
		);
	}
	
	public function get_all_post($type) {
		extract($this->prepare_get(array('cpage', 'query', 'kategori')));
		$cpage	= filter_var($cpage, FILTER_SANITIZE_NUMBER_INT);
		if (empty($cpage)) $cpage = 0;
		$where	= array();
		$r 		= array();
		if ( ! empty($query)) {
			$query		= $this->db->escape_str(strip_tags($query));
			$where[]	= "(a.JUDUL_POSTANGGOTA LIKE '%{$query}%' OR a.ISI_POSTANGGOTA LIKE '%{$query}%')";
			$r['param']['query'] = stripslashes($query);
		} else $r['param']['query'] = '';
		if ( ! empty($kategori)) {
			$kategori	= filter_var($kategori, FILTER_SANITIZE_NUMBER_INT);
			$where[]	= "a.ID_KATPRODUK = '$kategori'";
			$r['param']['kategori'] = $kategori;
		} else $r['param']['kategori'] = '';
		$where[]	= "a.STATUS_POSTANGGOTA = '1'";
		$where[]	= "a.ID_ANGGOTA = c.ID_ANGGOTA";
		$where[]	= "a.TIPE_POSTANGGOTA = '$type'";
		$where[]	= "a.ID_KATPRODUK = d.ID_KATPRODUK";
		// cari jumlah halaman
		$numdt		= 30;
		$r['data']	= array();
		$run		= $this->db->query("SELECT COUNT(a.ID_POSTANGGOTA) AS HASIL FROM postanggota a, anggota c, katproduk d WHERE " . implode(" AND ", $where), TRUE);
		$numpg		= ceil($run->HASIL / $numdt);
		if ($numpg == 0) $numpg = 1;
		if ($cpage < 0) $cpage = 0;
		if ($cpage > $numpg - 1) $cpage = $numpg - 1;
		$start		= $cpage * $numdt;
		$run		= $this->db->query("SELECT a.*, d.NAMA_KATPRODUK, c.KODE_ANGGOTA, c.NAMA_ANGGOTA, c.VALID_ANGGOTA, COUNT(b.ID_KOMENTAR) AS KOMENTAR FROM postanggota a LEFT JOIN komentar b ON b.ID_POSTANGGOTA = a.ID_POSTANGGOTA, anggota c, katproduk d WHERE " . implode(" AND ", $where) . " GROUP BY a.ID_POSTANGGOTA ORDER BY a.TANGGAL_POSTANGGOTA DESC LIMIT $start, $numdt");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$isi 		= strip_tags($val->ISI_POSTANGGOTA);
				$ptisi		= token_truncate($isi, 150);
				if (strlen($isi) > 150) $ptisi .= '...';
				
				if ( ! empty($val->FOTO_POSTANGGOTA)) {
					$f 		= unserialize($val->FOTO_POSTANGGOTA);
					$foto	= '/upload/post/' . str_replace('.', '_thumb.', $f[0]);
				} else $foto = '/upload/post/default.png';
				
				$r['data'][] = array(
					'link'		=> '/' . ($type == 1 ? 'jual' : 'beli') . '/' . $val->ID_POSTANGGOTA . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->JUDUL_POSTANGGOTA)),
					'id'		=> $val->ID_POSTANGGOTA,
					'kategori'	=> $val->NAMA_KATPRODUK,
					'judul'		=> $val->JUDUL_POSTANGGOTA,
					'tanggal'	=> datedb_to_tanggal($val->TANGGAL_POSTANGGOTA, 'd M Y H:i'),
					'isi'		=> $ptisi,
					'foto'		=> $foto,
					'komentar'	=> $val->KOMENTAR,
					'anggota_link'	=> '/anggota/' . $val->KODE_ANGGOTA,
					'anggota_nama'	=> $val->NAMA_ANGGOTA,
					'anggota_valid'	=> ($val->VALID_ANGGOTA == '1'),
				);
			}
		}
		$r['numpage'] 	= $numpg;
		$r['cpage']		= $cpage;
		$r['type']		= ($type == 1 ? 'jual' : 'beli');
		$r['link']		= preg_replace('/&cpage=[0-9]+/', '', http_build_query($r['param']));
		return $r;
	}
	
	private function replace_spaces($string) { 
		for( $i = 0, $in_tag = false; $i < strlen($string); $i++ ) { 
			if(( $string{$i} == ' ' ) && !$in_tag ) $string = substr_replace($string, '&nbsp;', $i, 1);
			else if( $string{$i} == '<' ) $in_tag = true; 
			else if( $string{$i} == '>' ) $in_tag = false; 
		}
		$string = preg_replace('/(&nbsp;){1,1}/', ' ', $string);
		return $string; 
	}
	
	public function get_detail($type, $id, $nama) {
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$run	= $this->db->query("SELECT a.*, b.KODE_ANGGOTA, b.NAMA_ANGGOTA, c.ID_KATPRODUK, c.NAMA_KATPRODUK FROM postanggota a, anggota b, katproduk c WHERE a.ID_ANGGOTA = b.ID_ANGGOTA AND a.STATUS_POSTANGGOTA = '1' AND a.ID_POSTANGGOTA = '$id' AND a.ID_KATPRODUK = c.ID_KATPRODUK", TRUE);
		if (empty($run)) return FALSE;
		if ($nama != preg_replace('/[^a-z0-9]/', '-', strtolower($run->JUDUL_POSTANGGOTA))) return FALSE;
		$r['type']		= ($type == 1 ? 'Jual' : 'Beli');
		$r['id']		= $run->ID_POSTANGGOTA;
		$r['kategori']	= $run->NAMA_KATPRODUK;
		$r['id_kategori'] = $run->ID_KATPRODUK;
		$r['judul']		= $run->JUDUL_POSTANGGOTA;
		$r['poster_nama']= $run->NAMA_ANGGOTA;
		$r['poster_kode']= $run->KODE_ANGGOTA;
		$r['poster_link']= '/anggota/' . $run->KODE_ANGGOTA;
		$r['isi']		= nl2br($this->replace_spaces($run->ISI_POSTANGGOTA), FALSE);
		$r['tanggal']	= datedb_to_tanggal($run->TANGGAL_POSTANGGOTA, 'd M Y H:i');
		if ( ! empty($run->FOTO_POSTANGGOTA)) {
			$f = unserialize($run->FOTO_POSTANGGOTA);
			foreach ($f as $key => $val) $foto[$key] = '/upload/post/' . $val;
			$r['foto']	= $foto;
		} else $r['foto'] = array('/upload/post/default.png');
		return $r;
	}
	
	public function get_post_detail($id, $member) {
		$id 	= filter_var($id, FILTER_SANITIZE_NUMBER_FLOAT);
		$member	= $this->db->escape_str($member);
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$member'", TRUE);
		$member	= $run->ID_ANGGOTA;
		if (empty($run)) return FALSE;
		$run	= $this->db->query("SELECT * FROM postanggota WHERE ID_ANGGOTA = '$member' AND ID_POSTANGGOTA = '$id' AND STATUS_POSTANGGOTA = '1'", TRUE);
		if (empty($run)) return FALSE;
		if (empty($run->FOTO_POSTANGGOTA)) $foto = array('/upload/post/default.png');
		else {
			$foto = unserialize($run->FOTO_POSTANGGOTA);
			foreach ($foto as $key => $val) $foto[$key] = '/upload/post/' . $val;
		}
		$kiriman = array(
			'id'	=> $run->ID_POSTANGGOTA,
			'kategori'=> $run->ID_KATPRODUK,
			'judul'	=> $run->JUDUL_POSTANGGOTA,
			'tipe'	=> $run->TIPE_POSTANGGOTA,
			'isi'	=> $run->ISI_POSTANGGOTA,
			'foto'	=> $foto
		);
		return array(
			'type'		=> TRUE,
			'kiriman'	=> $kiriman
		);
	}
	
	public function save_post($member, $iofiles, $postid = 0) {
		extract($this->prepare_post(array('id', 'tipe', 'judul', 'kategori', 'isi', 'foto', 'status')));
		if ( ! empty($id)) {
			$id	= filter_var($id, FILTER_SANITIZE_NUMBER_FLOAT);
			if (empty($id)) $id = '';
		}
		
		// hanya ubah status
		if ( ! empty($status)) {
			$status = ($status == 2 ? 2 : 1);
			$upd	= $this->db->query("UPDATE postanggota SET STATUS_POSTANGGOTA = '$status' WHERE ID_POSTANGGOTA = '$postid'");
			return array('type' => TRUE);
		}
		
		$kategori= filter_var($kategori, FILTER_SANITIZE_NUMBER_INT);
		$tipe	= ($tipe == '1' ? 1 : 2);
		$judul	= $this->db->escape_str(strip_tags($judul));
		$data	= $this->db->escape_str(strip_tags($isi));
		// validasi
		if (empty($judul) || empty($data)) return FALSE;
		// id anggota
		$run		= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '{$member['member_kode']}'", TRUE);
		$idmember	= $run->ID_ANGGOTA;
		if (empty($id)) {
			// periksa apakah hari ini sudah mengirim data untuk anggota belum valid
			if ( ! $member['member_valid']) {
				$run	= $this->db->query("SELECT TANGGAL_POSTANGGOTA FROM postanggota WHERE ID_ANGGOTA = '$idmember' ORDER BY TANGGAL_POSTANGGOTA DESC LIMIT 0, 1", TRUE);
				if ( ! empty($run)) {
					$lastpost	= datedb_to_tanggal($run->TANGGAL_POSTANGGOTA, 'U');
					if (time() - $lastpost < 24 * 60 * 60) {
						return array(
							'type'	=> FALSE,
							'data'	=> 'Anda hanya dapat mengirimkan satu kali dalam satu hari'
						);
					}
				}
			}
			$run 	= $this->db->query("INSERT INTO postanggota VALUES(0, '$idmember', '$kategori', '$judul', '$data', NOW(), '$tipe', '1', '')");
			$id		= $this->db->get_insert_id();
			
			// jika post 50 dan belum valid, maka jadikan valid
			if ( ! $member['member_valid']) {
				$run	= $this->db->query("SELECT COUNT(ID_POSTANGGOTA) AS HASIL FROM postanggota WHERE ID_ANGGOTA = '$idmember'", TRUE);
				if ($run->HASIL == 50) {
					$run = $this->db->query("UPDATE anggota SET VALID_ANGGOTA = '1' WHERE ID_ANGGOTA = '$idmember'");
				}
			}
		} else {
			$run	= $this->db->query("SELECT * FROM postanggota WHERE ID_POSTANGGOTA = '$id' AND ID_ANGGOTA = '$idmember'", TRUE);
			if (empty($run)) return FALSE;
			$upd	= array();
			if ($run->JUDUL_POSTANGGOTA != $judul) 	$upd[] = "JUDUL_POSTANGGOTA = '$judul'";
			if ($run->ISI_POSTANGGOTA != $data)		$upd[] = "ISI_POSTANGGOTA = '$isi'";
			if ($run->TIPE_POSTANGGOTA != $tipe)	$upd[] = "TIPE_POSTANGGOTA = '$tipe'";
			if ($run->ID_KATPRODUK != $kategori)	$upd[] = "ID_KATPRODUK = '$kategori'";
			
			// analisa perubahan foto
			$ofoto	= (empty($run->FOTO_POSTANGGOTA) ? array() : unserialize($run->FOTO_POSTANGGOTA));
			$foto	= (empty($foto) ? array() : $foto);
			if ( ! empty($foto)) {
				foreach ($foto as $key => $val) $foto[$key] = str_replace('/upload/post/', '', $val);
			}
			
			// dihapus
			if (count($foto) < count($ofoto)) {
				foreach ($ofoto as $val) {
					if (array_search($val, $foto) === FALSE) {
						$fpath 		= 'upload/post/' . $val;
						$fpath_thumb= 'upload/post/' . str_replace('.', '_thumb.', $val);
						@unlink($fpath);
						if (is_file($fpath_thumb)) @unlink($fpath_thumb);
					}
				}
				$upd[] = "FOTO_POSTANGGOTA = '" . (empty($foto) ? '' : serialize($foto)) . "'";
			}
			// ditukar
			if (count($foto) == count($ofoto) && count($foto) > 0) {
				// jika index 0 tidak sama
				if ($ofoto[0] != $foto[0]) {
					// hapus thumb yang lama
					$ofpath_thumb 	= 'upload/post/' . str_replace('.', '_thumb.', $ofoto[0]);
					@unlink($ofpath_thumb);
					// buat thumb yang baru
					$config						= array();
					$config['source_image']		= 'upload/post/' . $foto[0];
					$config['new_image']		= 'upload/post/' . str_replace('.', '_thumb.', $foto[0]);
					$config['maintain_ratio']	= TRUE;
					$config['width']			= 120;
					$config['height']			= 120;
					$iofiles->image_config($config);
					$iofiles->image_resize();
				}
				$upd[] = "FOTO_POSTANGGOTA = '" . (empty($foto) ? '' : serialize($foto)) . "'";
			}
			
			if ( ! empty($upd)) 
				$run = $this->db->query("UPDATE postanggota SET " . implode(", ", $upd) . " WHERE ID_POSTANGGOTA = '$id' AND ID_ANGGOTA = '$idmember'");
		}
		
		// handle file image
		if (isset($_FILES) && ! empty($_FILES)) {
			$run = $this->db->query("SELECT FOTO_POSTANGGOTA FROM postanggota WHERE ID_POSTANGGOTA = '$id'", TRUE);
			if (empty($run)) return FALSE;
			$fotos	= (empty($run->FOTO_POSTANGGOTA) ? array() : unserialize($run->FOTO_POSTANGGOTA));
			
			// maksimal 5
			$nmax	= ($member['member_valid'] ? 5 : 3);
			$max 	= ($nmax - count($fotos));
			$path	= 'upload/post/';
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
					$config['width']			= 120;
					$config['height']			= 120;
					$iofiles->image_config($config);
					$iofiles->image_resize();
				}
			}
			
			// merge fotos dengan fotos2
			$afotos	= array_merge($fotos, $fotos2);
			$upd	= $this->db->query("UPDATE postanggota SET FOTO_POSTANGGOTA = '" . serialize($afotos) . "' WHERE ID_POSTANGGOTA = '$id'");
		}
		
		return array( 'type'	=> TRUE );
	}
	
	public function delete_post($member, $iofiles, $postid) {
		$postid		= filter_var($postid, FILTER_SANITIZE_NUMBER_FLOAT);
		if (empty($postid)) $postid = '';
		$run		= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '{$member['member_kode']}'", TRUE);
		$idmember	= $run->ID_ANGGOTA;
		$run		= $this->db->query("SELECT FOTO_POSTANGGOTA FROM postanggota WHERE ID_ANGGOTA = '$idmember' AND ID_POSTANGGOTA = '$postid'", TRUE);
		if (empty($run)) return FALSE;
		if ( ! empty($run->FOTO_POSTANGGOTA)) {
			$foto = unserialize($run->FOTO_POSTANGGOTA);
			foreach ($foto as $val) {
				@unlink('upload/post/' . $val);
				@unlink('upload/post/' . str_replace('.', '_thumb.', $val));
			}
		}
		$run		= $this->db->query("UPDATE postanggota SET STATUS_POSTANGGOTA = '0' WHERE ID_POSTANGGOTA = '$postid'");
		return array('type' => TRUE);
	}
	
	public function get_other($type, $kode = '', $post = 0) {
		$where[]	= "TIPE_POSTANGGOTA = '$type'";
		$where[]	= "STATUS_POSTANGGOTA = '1'";
		if ( ! empty($kode)) {
			$run 	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode'", TRUE);
			if ( ! empty($run))
				$where[]	= "ID_ANGGOTA = '{$run->ID_ANGGOTA}'";
		}
		if ( ! empty($post)) {
			$where[] = "ID_POSTANGGOTA != '$post'";
		}
		$run 	= $this->db->query("SELECT ID_POSTANGGOTA, JUDUL_POSTANGGOTA, TANGGAL_POSTANGGOTA, FOTO_POSTANGGOTA, TIPE_POSTANGGOTA FROM postanggota WHERE " . implode(' AND ', $where) . " ORDER BY RAND() LIMIT 0, 5");
		$r 		= array(); 
		if ( ! empty($run)) {
			foreach ($run as $val) {
				if ( ! empty($val->FOTO_POSTANGGOTA)) {
					$f 		= unserialize($val->FOTO_POSTANGGOTA);
					$foto 	= '/upload/post/' . str_replace('.', '_thumb.', $f[0]);
				} else $foto = '/upload/post/default.png';
				$r[] = array(
					'link'		=> '/' . ($val->TIPE_POSTANGGOTA == '1' ? 'jual' : 'beli') . '/' . $val->ID_POSTANGGOTA . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->JUDUL_POSTANGGOTA)),
					'judul'		=> $val->JUDUL_POSTANGGOTA,
					'foto'		=> $foto,
					'tanggal'	=> datedb_to_tanggal($val->TANGGAL_POSTANGGOTA, 'd/m/Y')
				);
			}
		}
		return $r;
	}
	
	public function get_komentar() {
		extract($this->prepare_get(array('post', 'member', 'poster')));
		$id		= filter_var($post, FILTER_SANITIZE_NUMBER_INT);
		$member	= $this->db->escape_str($member);
		$poster	= $this->db->escape_str($poster);
		$run	= $this->db->query("SELECT a.*, b.KODE_ANGGOTA, b.NAMA_ANGGOTA, b.FOTO_ANGGOTA, b.VALID_ANGGOTA FROM komentar a, anggota b WHERE a.ID_POSTANGGOTA = '$id' AND a.ID_ANGGOTA = b.ID_ANGGOTA AND a.STATUS_KOMENTAR = '1'");
		$r 		= array();
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$r[] = array(
					'id'	=> $val->ID_KOMENTAR,
					'nama'	=> $val->NAMA_ANGGOTA,
					'link'	=> '/anggota/' . $val->KODE_ANGGOTA,
					'valid' => ($val->VALID_ANGGOTA == '1'),
					'isi'	=> nl2br($val->ISI_KOMENTAR, FALSE),
					'tanggal'=> datedb_to_tanggal($val->TANGGAL_KOMENTAR, 'd M Y H:i'),
					'foto'	=> '/upload/member/' . (empty($val->FOTO_ANGGOTA) ? 'default.png' : str_replace('.', '_thumb.', $val->FOTO_ANGGOTA)),
					'hapus'	=> ($member == $val->KODE_ANGGOTA || $poster == $val->KODE_ANGGOTA || $poster == $member)
				);
			}
		}
		return array(
			'type'		=> TRUE,
			'komentar'	=> $r
		);
	}
	
	public function save_komentar() {
		extract($this->prepare_post(array('sender', 'post', 'data')));
		$id		= filter_var($post, FILTER_SANITIZE_NUMBER_FLOAT);
		$sender	= $this->db->escape_str($sender);
		$data	= $this->db->escape_str(htmlentities($data));
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$sender' AND STATUS_ANGGOTA = '1'", TRUE);
		if (empty($run)) return FALSE;
		$run	= $this->db->query("INSERT INTO komentar VALUES(0, '$id', '{$run->ID_ANGGOTA}', '$data', NOW(), '1')");
		return array(
			'type' => TRUE, 'data' => ''
		);
	}
	
	public function delete_komentar($id) {
		$id 	= filter_var($id, FILTER_SANITIZE_NUMBER_FLOAT);
		$run	= $this->db->query("UPDATE komentar SET STATUS_KOMENTAR = '0' WHERE ID_KOMENTAR = '$id'");
		return array('type' => TRUE);
	}
	
	public function save_aduan($member) {
		extract($this->prepare_post(array('post', 'reason')));
		$post		= filter_var($post, FILTER_SANITIZE_NUMBER_FLOAT);
		$reason		= $this->db->escape_str($reason);
		$run		= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '" . $member['member_kode'] . "'", true);
		$idmember	= $run->ID_ANGGOTA;
		// masukkan ke aduan jika belum ada
		$run		= $this->db->query("SELECT COUNT(ID_ADUANPOST) AS HASIL FROM aduanpost WHERE ID_ANGGOTA = '$idmember' AND ID_POSTANGGOTA = '$post'", true);
		$data		= '';
		if ($run->HASIL == 0) {
			$ins	= $this->db->query("INSERT INTO aduanpost VALUES(0, '$post', '$idmember', '$reason', NOW(), '1')");
		} else {
			$data 	= 'Anda sudah memasukkan aduan pada kiriman ini';
		}
		return array('type' => true, 'data' => $data);
	}
}