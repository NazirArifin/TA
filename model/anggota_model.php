<?php
/**
 * Anggota Model
 */
namespace Model;

class AnggotaModel extends ModelBase {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_detail($kode) {
		$kode	= $this->db->escape_str($kode);
		$r 		= array();
		$run	= $this->db->query("SELECT ID_ANGGOTA, NAMA_ANGGOTA, ALAMAT_ANGGOTA, TELEPON_ANGGOTA, FOTO_ANGGOTA, INFO_ANGGOTA, VALID_ANGGOTA, DAFTAR_ANGGOTA, JENIS_ANGGOTA FROM anggota WHERE KODE_ANGGOTA = '$kode' AND STATUS_ANGGOTA = '1'", TRUE);
		if (empty($run)) return FALSE;
		// postanggota
		$id		= $run->ID_ANGGOTA;
		$count 	= $this->db->query("SELECT COUNT(ID_POSTANGGOTA) AS HASIL FROM postanggota WHERE ID_ANGGOTA = '$id' AND STATUS_POSTANGGOTA = '1'", TRUE);
		$post	= $count->HASIL;
		// review
		$count	= $this->db->query("SELECT COUNT(ID_REVIEWPRODUK) AS HASIL FROM reviewproduk WHERE ID_ANGGOTA = '$id' AND STATUS_REVIEWPRODUK = '2'", TRUE);
		$review	= $count->HASIL;
		// testimoni
		$count	= $this->db->query("SELECT COUNT(ID_TESTIMONI) AS HASIL FROM testimoni WHERE ID_ANGGOTA = '$id' AND STATUS_TESTIMONI = '2'", TRUE);
		$testi	= $count->HASIL;
		// apakah memiliki direktori
		$dir	= array();
		$cari	= $this->db->query("SELECT ID_DIREKTORI, NAMA_DIREKTORI FROM direktori WHERE PEMILIK_DIREKTORI = '$id'");
		if ( ! empty($cari)) { 
			foreach ($cari as $val) {
				$dir[] = array(
					'nama'	=> $val->NAMA_DIREKTORI,
					'link'	=> '/direktori/' . $val->ID_DIREKTORI . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_DIREKTORI))
				);
			}
		}
		
		$r['id']		= $id;
		$r['nama']		= $run->NAMA_ANGGOTA;
		$r['alamat']	= $run->ALAMAT_ANGGOTA;
		$r['telepon']	= $run->TELEPON_ANGGOTA;
		$r['foto']		= '/upload/member/' . (empty($run->FOTO_ANGGOTA) ? 'default.png' : str_replace('.', '_thumb.', $run->FOTO_ANGGOTA));
		$r['info']		= $run->INFO_ANGGOTA;
		$r['valid']		= ($run->VALID_ANGGOTA == '1' ? TRUE : FALSE);
		$r['jenis']		= ($run->JENIS_ANGGOTA == '1' ? 'Reguler' : 'Premium');
		$r['daftar']	= datedb_to_tanggal($run->DAFTAR_ANGGOTA, 'd F Y');
		$r['post']		= $post;
		$r['review']	= $review;
		$r['testi']		= $testi;
		$r['direktori'] = $dir;
		return $r;
	}
    
    public function get_data($nama) {
        $r = array();
        $nama   = $this->db->escape_str(strtolower($nama));
        $run    = $this->db->query("SELECT a.ID_DIREKTORI, a.NAMA_DIREKTORI, a.FOTO_DIREKTORI, a.INFO_DIREKTORI, b.ID_KATDIR, b.NAMA_KATDIR, c.ID_KOTA, c.NAMA_KOTA FROM direktori a, katdir b, kota c WHERE a.ID_KATDIR = b.ID_KATDIR AND a.ID_KOTA = c.ID_KOTA AND a.WEB_DIREKTORI = '$nama'", true);
        if (empty($run)) return false;
        
        $r['id']            = $run->ID_DIREKTORI;
        $r['nama']          = $run->NAMA_DIREKTORI;
        $r['direktori_link']= $run->ID_DIREKTORI . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($run->NAMA_DIREKTORI));
        $r['foto']          = '/upload/direktori/' . (empty($run->FOTO_DIREKTORI) ? 'default.png' : $run->FOTO_DIREKTORI);
        $r['kota']          = $run->NAMA_KOTA;
        $r['direktori_kategori']= $run->NAMA_KATDIR;
        $r['info']          = $run->INFO_DIREKTORI;
        
        // cari kategori produk
        $kategori           = array();
        $srun   = $this->db->query("SELECT a.ID_KATPRODUK, a.NAMA_KATPRODUK FROM katproduk a, produk b WHERE a.ID_KATPRODUK = b.ID_KATPRODUK AND b.ID_DIREKTORI = '{$run->ID_DIREKTORI}' GROUP BY a.NAMA_KATPRODUK ORDER BY a.NAMA_KATPRODUK");
        if ( ! empty($srun)) {
            foreach ($srun as $val) {
                $kategori[] = array(
                    'id'    => $val->ID_KATPRODUK,
                    'nama'  => $val->NAMA_KATPRODUK
                );
            }
        }
        $r['kategori']      = $kategori;
        
        // cari produk
        $param      = array();
        $where      = array();
        $produk     = array();
        // a produk, b direktori, c katproduk
        $where[]    = "a.ID_DIREKTORI = '" . $run->ID_DIREKTORI . "'";
        $where[]    = "a.STATUS_PRODUK = '1'";
        extract($this->prepare_get(array('query', 'cpage', 'order', 'kategori')));
        if ( ! empty($query)) {
            $param['query'] = $this->db->escape_str(htmlentities($query));
            $link[]         = "query={$query}";
            $where[]        = "(a.NAMA_PRODUK LIKE '%" . $query . "%' OR a.INFO_PRODUK LIKE '%" . $query . "%')";
        }
        if ( ! empty($kategori)) {
            $kategori       = intval($kategori);
            $param['kategori'] = $kategori;
            $link[]         = "kategori={$kategori}";
            $where[]        = "a.ID_KATPRODUK = '$kategori'";
        }
        // order
        $param['order'] = 'nama';
        $urut   = "a.NAMA_PRODUK";
        if ( ! empty($order)) {
            $param['order'] = $this->db->escape_str($order);
            switch ($order) {
                case 'harga':
                    $urut = "a.HARGA_PRODUK"; $param['order'] = 'harga';
                    break;
                case 'rating':
                    $urut = "RERATA DESC"; $param['order'] = 'rating'; break;
            }
        }
        // pagination
        $numdt      = 20;
        $start      = 0;
        if ( ! empty($cpage)) {
            $cpage          = intval($cpage);
            $param['cpage'] = $cpage;
            $start          = $cpage * $numdt;
        } else $cpage = 0;
        $crun = $this->db->query("SELECT COUNT(a.ID_PRODUK) AS HASIL FROM produk a, direktori b WHERE a.ID_DIREKTORI = b.ID_DIREKTORI AND " . implode(" AND ", $where), true);
        $numpg = ceil($crun->HASIL / $numdt);
        
        $crun = $this->db->query("SELECT a.*, c.NAMA_KATPRODUK, AVG(d.SKOR_REVIEWPRODUK) AS RERATA FROM produk a 
        LEFT JOIN direktori b ON a.ID_DIREKTORI = b.ID_DIREKTORI  
        LEFT JOIN katproduk c ON a.ID_KATPRODUK = c.ID_KATPRODUK 
        LEFT JOIN reviewproduk d ON a.ID_PRODUK = d.ID_PRODUK WHERE " . implode(" AND ", $where) . " GROUP BY a.ID_PRODUK ORDER BY $urut LIMIT $start, $numdt");
        if ( ! empty($crun)) {
            foreach ($crun as $val) {
                $info	= strip_tags($val->INFO_PRODUK);
				if (empty($val->FOTO_PRODUK))
					$foto 	= '/upload/produk/default.png';
				else {
					$f 		= unserialize($val->FOTO_PRODUK);
					$foto 	= '/upload/produk/' . str_replace('.', '_thumb.', $f[0]);
				}
                
                // skor review produk
                if ( ! empty($val->RERATA) && ! is_null($val->RERATA)) {
                    $skor       = floor($val->RERATA * 2) / 2;
                } else {
                    $skor       = '0';
                }
                
                if (strlen($skor) > 1) {
                    $rating = array(
                        'fill'  => floor($skor),
                        'half'  => 1,
                        'empty' => 5 - ceil($skor)
                    );
                } else {
                    $rating = array(
                        'fill'  => $skor,
                        'half'  => 0,
                        'empty' => 5 - $skor
                    );
                }
                
                $produk[]	= array(
					'id'		=> $val->ID_PRODUK,
					'kategori'	=> $val->NAMA_KATPRODUK,
					'id_kategori'=> $val->ID_KATPRODUK,
					'nama'		=> $val->NAMA_PRODUK,
					'harga'		=> ( ! empty($val->HARGA_PRODUK) ? number_format($val->HARGA_PRODUK, 0, ',', '.') : ''),
					'info'		=> $info,
					'foto'		=> $foto,
					'link'		=> '/produk/' . $val->ID_PRODUK . '/' . preg_replace('/[^a-z0-9]/', '-', strtolower($val->NAMA_PRODUK)),
					'status'	=> $val->STATUS_PRODUK,
                    'rating'    => $rating
				);
            }
        }
        $r['produk']    = $produk;
        $r['cpage']     = $cpage;
        $r['numpage']   = $numpg;
        $r['param']     = $param;
        $r['url']       = '/' . $nama;
        $link           = array();
        if ( ! empty($query)) $link[] = "query=$query"; else $link[] = "query=";
        if ( ! empty($order)) $link[] = "order=$order"; else $link[] = "order=nama";
        if ( ! empty($kategori)) $link[] = "kategori=$kategori"; else $link[] = "kategori=";
        $r['link']      = implode('&', $link);
        return $r;
    }
}