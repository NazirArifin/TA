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
	
	public function get_direktori_list($kode) {
		$r 		= array();
		// cari id
		$kode	= $this->db->escape_str($kode);
		$run	= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode'", TRUE);
		if (empty($run)) return FALSE;
		// cari direktori
		$idmember	= $run->ID_ANGGOTA;
		$run	= $this->db->query("SELECT ID_DIREKTORI, NAMA_DIREKTORI FROM direktori WHERE PEMILIK_DIREKTORI = '$idmember' AND STATUS_DIREKTORI = '1' ORDER BY NAMA_DIREKTORI");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$r[] = array(
					'id'	=> $val->ID_DIREKTORI,
					'nama'	=> str_replace(array("'", '"'), '`', $val->NAMA_DIREKTORI)
				);
			}
		}
		return $r;
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
			$where[] 	= "(a.NAMA_DIREKTORI LIKE '%{$nama}%' OR a.INFO_DIREKTORI LIKE '%{$nama}%')";
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
		$run 		= $this->db->query("SELECT a.ID_DIREKTORI, a.NAMA_DIREKTORI, a.ALAMAT_DIREKTORI, a.TELEPON_DIREKTORI, a.INFO_DIREKTORI, a.FOTO_DIREKTORI, a.PEMILIK_DIREKTORI, a.WEB_DIREKTORI, b.ID_KATDIR, b.NAMA_KATDIR, c.NAMA_KOTA FROM direktori a, katdir b, kota c WHERE " . implode(" AND ", $where) . " ORDER BY a.NAMA_DIREKTORI LIMIT $start, $numdt");
		if ( ! empty($run)) {
			foreach ($run as $val) {
				$alamat = json_decode($val->ALAMAT_DIREKTORI);
				$telepon = json_decode($val->TELEPON_DIREKTORI);
				if ( ! empty($alamat[1])) $alamat = implode('<br>', $alamat);
				else $alamat = $alamat[0];
				if ( ! empty($telepon[1])) $telepon = implode('<br>', $telepon);
				else $telepon = $telepon[0];
                
                // cari pemilik
                $pemilik = array();
                if ( ! empty($val->PEMILIK_DIREKTORI)) {
                    $srun = $this->db->query("SELECT NAMA_ANGGOTA, KODE_ANGGOTA, VALID_ANGGOTA FROM anggota WHERE ID_ANGGOTA = '" . $val->PEMILIK_DIREKTORI . "'", true);
                    $pemilik = array(
                        'link'  => '/anggota/' . $srun->KODE_ANGGOTA,
                        'nama'  => $srun->NAMA_ANGGOTA,
                        'valid' => ($srun->VALID_ANGGOTA == '1')
                    );
                }
				
				$r['data'][] = array(
					'link'		=> '/direktori/' . $val->ID_DIREKTORI . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_DIREKTORI)),
					'nama'		=> $val->NAMA_DIREKTORI,
					'kategori'	=> $val->NAMA_KATDIR,
                    'kategori_id' => $val->ID_KATDIR,
					'info'		=> $val->INFO_DIREKTORI,
					'kota'		=> $val->NAMA_KOTA,
					'foto'		=> '/upload/direktori/' . (empty($val->FOTO_DIREKTORI) ? 'default.png' : str_replace('.', '_thumb.', $val->FOTO_DIREKTORI)),
					'alamat'	=> $alamat,
					'telepon'	=> $telepon,
                    'pemilik'   => ( ! empty($pemilik) ? $pemilik : ''),
                    'web'       => $val->WEB_DIREKTORI
				);
			}
		}
		$r['numpage'] 	= $numpg;
		$r['cpage']		= $cpage;
		$r['link']		= preg_replace('/&cpage=[0-9]+/', '', http_build_query($r['param']));
		return $r;
	}
	
	public function get_name($id) {
		$run	= $this->db->query("SELECT NAMA_DIREKTORI FROM direktori WHERE ID_DIREKTORI = '$id'", TRUE);
		if (empty($run)) return FALSE;
		return $run->NAMA_DIREKTORI;
	}
	
	public function get_detail($id, $nama) {
		$r 		= array();
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$run	= $this->db->query("SELECT a.*, b.ID_KATDIR, b.NAMA_KATDIR, c.NAMA_KOTA FROM direktori a, katdir b, kota c WHERE a.ID_KATDIR = b.ID_KATDIR AND a.ID_KOTA = c.ID_KOTA AND a.ID_DIREKTORI = '$id' AND STATUS_DIREKTORI = '1'", TRUE);
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
       
        $website        = '';
        if ( ! empty($run->WEB_DIREKTORI)) {
            $website    = '/' . $run->WEB_DIREKTORI;
        }
        
		
		$r['id']		= $run->ID_DIREKTORI;
		$r['nama']		= $run->NAMA_DIREKTORI;
		$r['kategori']	= $run->NAMA_KATDIR;
        $r['id_kategori']= $run->ID_KATDIR;
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
		$r['website']	= $website;
		$r['chat']		= json_decode($run->CHAT_DIREKTORI);
		$r['socmed']	= json_decode($run->SOCMED_DIREKTORI);
		$r['foto']		= '/upload/direktori/' . (empty($run->FOTO_DIREKTORI) ? 'default.png' : $run->FOTO_DIREKTORI);
		return $r;
	}
	
	public function save_direktori($id, $iofiles, $member) {
		$member		= $this->db->escape_str($member);
		$run		= $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$member'", TRUE);
		if (empty($run)) return FALSE;
		$idmember	= $run->ID_ANGGOTA;
		// cek post
		$run		= $this->db->query("SELECT COUNT(ID_DIREKTORI) AS HASIL FROM direktori WHERE ID_DIREKTORI = '$id' AND PEMILIK_DIREKTORI = '$idmember'", TRUE);
		if ($run->HASIL == 0) return FALSE;
		
		$r 			= array( 'type' => TRUE );
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
		
		if ( ! $v) return array( 'type' => FALSE );;
		
		// kumpulkan
		$calamat 	= array($alamat, $alamat2);
		$ctelepon 	= array($telepon, $telepon2);
		$ckoordinat = array($koordinat, $koordinat2);
		
		$getid 		= $id;
		$upd		= array();
		$jalamat	= json_encode($calamat);
		$jtelepon	= json_encode($ctelepon);
		$jkoordinat	= json_encode($ckoordinat);
		$jim		= json_encode($im);
		$jsm		= json_encode($sm);
		$run 		= $this->db->query("SELECT * FROM direktori WHERE ID_DIREKTORI = '$id'", TRUE);
		if (empty($run)) return FALSE;
		
		$ubahnama		= FALSE;
		if ($nama != $run->NAMA_DIREKTORI) {
			$upd[] 		= "NAMA_DIREKTORI = '$nama'";
			$ubahnama	= TRUE; 
		}
		if ($kategori != $run->ID_KATDIR) 				$upd[] = "ID_KATDIR = '$kategori'";
		if ($kota != $run->ID_KOTA) 					$upd[] = "ID_KOTA = '$kota'";
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
				$config['max_size']		    = 1024 * 1024;
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
				$config['width']			= 200;
				$config['height']			= 200;
				$iofiles->image_config($config);
				$iofiles->image_resize();
				
				// update tabel
				$upd = $this->db->query("UPDATE direktori SET FOTO_DIREKTORI = '$filename' WHERE ID_DIREKTORI = '$getid'");
			}
		}
		
		// jika ubah nama
		if ($ubahnama)	$r['data']	= $nama;
		return $r;
	}
    
    public function validate_subdomain($state) {
        extract($this->prepare_get(array('subdomain')));
        $subdomain = preg_replace('/[^a-z0-9\.]/', '', strtolower($subdomain));
        $run    = $this->db->query("SELECT COUNT(ID_DIREKTORI) AS HASIL FROM direktori WHERE WEB_DIREKTORI = '$subdomain'", true);
        return array(
            'type' => true, 'valid' => ($run->HASIL == 0), 'accept' => $subdomain
        );
    }
}