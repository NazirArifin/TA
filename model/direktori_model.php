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
	
	public function get_direktori_list($kode, $fstore = false) {
		$r 		= array();
		
		// jika cari direktori bukan toko
		if ($fstore) {
			$run = $this->db->query("SELECT ID_DIREKTORI, NAMA_DIREKTORI FROM direktori WHERE PEMILIK_DIREKTORI = '' AND STATUS_DIREKTORI = '1' ORDER BY NAMA_DIREKTORI");
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
        
        // periksa di reserved word
        $resword    = array(
            'admin', 'administrator', 'member', 'anggota', 'madura.bz', 'data', 'ongkir', 'pesan', 'daftar', 'katalog', 'logout', 'home', 'email', 'berita', 'info', 'direktori', 'testimoni', 'post', 'kiriman', 'review', 'fproduk', 'order', 'produk', 'jual', 'beli', 'komentar', 'invoice', 'tos', 'help', 'bantuan', 'fpass', 'fuck', 'anjing', 'sex', 'seks'
        );
        if (in_array($subdomain, $resword)) {
            return array(
                'type' => true, 'valid' => false, 'accept' => $subdomain
            );
        }
        
        $run    = $this->db->query("SELECT COUNT(ID_DIREKTORI) AS HASIL FROM direktori WHERE WEB_DIREKTORI = '$subdomain'", true);
        return array(
            'type' => true, 'valid' => ($run->HASIL == 0), 'accept' => $subdomain
        );
    }
	
	public function get_data($id) {
		$id		= filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		$run	= $this->db->query("SELECT a.ID_DIREKTORI, a.NAMA_DIREKTORI, a.INFO_DIREKTORI, a.FOTO_DIREKTORI, b.NAMA_KATDIR FROM direktori a, katdir b WHERE a.ID_KATDIR = b.ID_KATDIR AND a.ID_DIREKTORI = '$id'", true);
		if (empty($run)) return array('type' => true, 'data' => array());
		$foto = '/upload/direktori/' . str_replace('.', '_thumb.', $run->FOTO_DIREKTORI);
		return array(
			'type' => true,
			'data' => array(
				'nama' => $run->NAMA_DIREKTORI,
				'info' => $run->INFO_DIREKTORI,
				'kategori' => $run->NAMA_KATDIR,
				'link' => '/direktori/' . $run->ID_DIREKTORI . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($run->NAMA_DIREKTORI)),
				'foto' => $foto
			)
		);
	}
	
	public function new_direktori($member, $iofiles) {
		extract($this->prepare_post(array('direktori', 'kategori', 'nama', 'alamat', 'telepon', 'kota')));
		$cari = $this->db->query("SELECT ID_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '{$member['member_kode']}'", true);
		$idanggota = $cari->ID_ANGGOTA;
		
		// apapun tipenya jika sudah ada di proses direktori maka batalkan
		$cari = $this->db->query("SELECT COUNT(ID_PROSESDIREKTORI) AS HASIL FROM prosesdirektori WHERE ID_ANGGOTA = '$idanggota'", true);
		if ($cari->HASIL > 0) return false;
		
		// tipe 1
		if ( ! empty($direktori)) {
			$direktori = filter_var($direktori, FILTER_SANITIZE_NUMBER_INT);
			// data direktori
			$cari = $this->db->query("SELECT a.NAMA_DIREKTORI, a.ALAMAT_DIREKTORI, a.TELEPON_DIREKTORI, b.NAMA_KOTA FROM direktori a, kota b WHERE a.ID_KOTA = b.ID_KOTA AND a.ID_DIREKTORI = '$direktori'", true);
			$namadirektori = $cari->NAMA_DIREKTORI;
			$alamatdirektori = json_decode($cari->ALAMAT_DIREKTORI);
			$telepondirektori = json_decode($cari->TELEPON_DIREKTORI);
			$kota = $cari->NAMA_KOTA;
			$linkdirektori = '/direktori/' . $direktori . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($cari->NAMA_DIREKTORI));
			
			// masukkan ke proses direktori
			$ins = $this->db->query("INSERT INTO prosesdirektori VALUES(0, '$direktori', '$idanggota', '')");
			$id = $this->db->get_insert_id();
			
			if (isset($_FILES['file'])) {
				$config['upload_path']		= 'upload/direktori/';
				$config['allowed_types']	= 'jpeg|jpg|png';
				$config['encrypt_name']		= TRUE;
				$config['overwrite']		= false;
				$config['max_size']		    = 1024 * 1024;
				$iofiles->upload_config($config);
				$iofiles->upload('file');
				$filename 					= $iofiles->upload_get_param('file_name');
				$upd = $this->db->query("UPDATE prosesdirektori SET FOTO_PROSESDIREKTORI = '$filename' WHERE ID_PROSESDIREKTORI = '$id'");
			}
			
			// pesan pemberitahuan
			$pesan = "Anggota dengan nama <a href=\"/anggota/" . $member['member_kode'] . "\" target=\"_blank\">" . $member['member_nama'] . "</a> telah mengakui sebuah direktori:<br>Nama: <a href=\"$linkdirektori\" target=\"_blank\">$namadirektori</a><br>Alamat: $alamatdirektori[0] &mdash; $kota<br>Telepon: $telepondirektori[0]<br>Foto Bukti: <a href=\"/upload/direktori/$filename\" target=\"_blank\">$filename</a> !====! $id";
			$ins = $this->db->query("INSERT INTO pemberitahuan VALUES(0, '4', '$pesan', NOW(), '1')");
		}
		
		// tipe 2
		if ( ! empty($nama)) {
			// insert ke direktori dengan status 3 (baru)
			// cari id anggota
			$nama = $this->db->escape_str(strip_tags($nama));
			$kategori = intval($kategori);
			$alamat = $this->db->escape_str($alamat);
			$telepon = $this->db->escape_str($telepon);
			$kota = intval($kota);
			
			$cari = $this->db->query("SELECT NAMA_KOTA FROM kota WHERE ID_KOTA = '$kota'", true);
			$namakota = $cari->NAMA_KOTA;
			
			$koordinat 	= '["",""]';
			$stelepon 	= '["' . $telepon . '",""]';
			$salamat 	= '["' . $alamat . '",""]';
			$chat 		= '{"wa":"","bbm":"","line":"","wechat":""}';
			$socmed 	= '{"fb":"","twitter":"","gplus":"","ig":""}';
			$ins 		= $this->db->query("INSERT INTO direktori VALUES(0, '$kategori', '$kota', '$nama', '', '', '$salamat', '$stelepon', '$idanggota', '$koordinat', '', '', '$chat', '$socmed', '3')");
			$id 		= $this->db->get_insert_id();
			
			if (isset($_FILES['file'])) {
				$config['upload_path']		= 'upload/direktori/';
				$config['allowed_types']	= 'jpeg|jpg|png';
				$config['encrypt_name']		= TRUE;
				$config['overwrite']		= false;
				$config['max_size']		    = 1024 * 1024;
				$iofiles->upload_config($config);
				$iofiles->upload('file');
				$filename 					= $iofiles->upload_get_param('file_name');
				$upd = $this->db->query("UPDATE direktori SET FOTO_DIREKTORI = '$filename' WHERE ID_DIREKTORI = '$id'");
			}
			
			// masukkan ke proses direktori
			$ins = $this->db->query("INSERT INTO prosesdirektori VALUES(0, '$id', '$idanggota', '')");
			$idproses = $this->db->get_insert_id();
			
			// masukkan ke pemberitahuan
			$pesan = "Anggota dengan nama <a href=\"/anggota/" . $member['member_kode'] . "\" target=\"_blank\">" . $member['member_nama'] . "</a> telah mendaftarkan direktori baru dengan rincian:<br>Nama Direktori: $nama<br>Alamat: $alamat &mdash; $namakota<br>Telepon: $telepon<br>Foto Bukti: <a href=\"/upload/direktori/$filename\" target=\"_blank\">$filename</a> !====! $idproses";
			$ins = $this->db->query("INSERT INTO pemberitahuan VALUES(0, '4', '$pesan', NOW(), '1')");
		}
		
		return true;
	}
	
	public function get_inprocess_direktori($kode) {
		$cari = $this->db->query("SELECT COUNT(a.ID_PROSESDIREKTORI) AS HASIL FROM prosesdirektori a, anggota b WHERE a.ID_ANGGOTA = b.ID_ANGGOTA AND b.KODE_ANGGOTA = '$kode'", true);
		return ($cari->HASIL > 0);
	}
}