-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 19, 2015 at 04:17 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `maduradotbz`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `ID_ADMIN` smallint(6) NOT NULL AUTO_INCREMENT,
  `EMAIL_ADMIN` varchar(20) DEFAULT NULL,
  `PASSWORD_ADMIN` varchar(40) DEFAULT NULL,
  `NAMA_ADMIN` varchar(40) DEFAULT NULL,
  `FOTO_ADMIN` varchar(60) DEFAULT NULL,
  `LEVEL_ADMIN` char(1) DEFAULT NULL,
  `STATUS_ADMIN` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_ADMIN`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID_ADMIN`, `EMAIL_ADMIN`, `PASSWORD_ADMIN`, `NAMA_ADMIN`, `FOTO_ADMIN`, `LEVEL_ADMIN`, `STATUS_ADMIN`) VALUES
(1, 'admin@madura.bz', 'mdekND9WvTSqo', 'Administrator', '6546ee6d29d4ea08a23efb954003b127.jpg', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `aduanpost`
--

CREATE TABLE IF NOT EXISTS `aduanpost` (
  `ID_ADUANPOST` int(11) NOT NULL AUTO_INCREMENT,
  `ID_POSTANGGOTA` bigint(20) NOT NULL,
  `ID_ANGGOTA` int(11) NOT NULL,
  `ALASAN_ADUANPOST` varchar(80) NOT NULL,
  `TANGGAL_ADUANPOST` datetime NOT NULL,
  `STATUS_ADUANPOST` char(1) NOT NULL,
  PRIMARY KEY (`ID_ADUANPOST`),
  KEY `FK_POST_ADUANPOST` (`ID_POSTANGGOTA`),
  KEY `FK_ANGGOTA_ADUANPOST` (`ID_ANGGOTA`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `aduanpost`
--

INSERT INTO `aduanpost` (`ID_ADUANPOST`, `ID_POSTANGGOTA`, `ID_ANGGOTA`, `ALASAN_ADUANPOST`, `TANGGAL_ADUANPOST`, `STATUS_ADUANPOST`) VALUES
(1, 8, 2, 'sara', '2015-04-19 22:26:44', '1'),
(2, 4, 2, 'offense', '2015-06-02 19:43:36', '1'),
(3, 4, 2, 'offense', '2015-06-02 19:43:36', '1');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE IF NOT EXISTS `anggota` (
  `ID_ANGGOTA` int(11) NOT NULL AUTO_INCREMENT,
  `KODE_ANGGOTA` varchar(30) DEFAULT NULL,
  `EMAIL_ANGGOTA` varchar(40) DEFAULT NULL,
  `PASSWORD_ANGGOTA` varchar(30) DEFAULT NULL,
  `NAMA_ANGGOTA` varchar(40) DEFAULT NULL,
  `ALAMAT_ANGGOTA` varchar(120) DEFAULT NULL,
  `TELEPON_ANGGOTA` varchar(20) DEFAULT NULL,
  `FOTO_ANGGOTA` varchar(60) DEFAULT NULL,
  `INFO_ANGGOTA` varchar(120) DEFAULT NULL,
  `VALID_ANGGOTA` char(1) DEFAULT NULL,
  `DAFTAR_ANGGOTA` datetime DEFAULT NULL,
  `JENIS_ANGGOTA` char(1) DEFAULT NULL,
  `STATUS_ANGGOTA` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_ANGGOTA`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`ID_ANGGOTA`, `KODE_ANGGOTA`, `EMAIL_ANGGOTA`, `PASSWORD_ANGGOTA`, `NAMA_ANGGOTA`, `ALAMAT_ANGGOTA`, `TELEPON_ANGGOTA`, `FOTO_ANGGOTA`, `INFO_ANGGOTA`, `VALID_ANGGOTA`, `DAFTAR_ANGGOTA`, `JENIS_ANGGOTA`, `STATUS_ANGGOTA`) VALUES
(1, 'member', 'member@madura.bz', '', 'Anggota', '', NULL, '', 'Anggota Default', '0', '2015-02-19 00:00:00', '0', '0'),
(2, 'mdbz552b361c02757', 'dyiela_sweet@yahoo.co.id', 'mdWQ.PJoKPXw6', 'Hosniyah', 'Jl. Dirgahayu No. 3 Pamekasan', '+62-9854543432', 'a93d8ab7610861c1b8dbcf0966a1d857.jpg', 'Wirausahawan sejati', '1', '2015-04-13 10:21:00', '2', '1'),
(3, 'mdbz552b450220561', 'ceylon.rizan@gmail.com', 'mdVgUfOMymZis', 'Amirul Mukminin', '', '+62-984034064', '', '', '1', '2015-04-13 11:24:34', '1', '1'),
(4, 'mdbz553067ee14ec6', 'greenchonk@yahoo.co.id', 'md04qzXES8QdY', 'Tyieka Imoetz', 'Jl. Stadion No. 15 Pamekasan', '+62-8939832993', '8ae7f3bc908a4faac5f91318320896a3.jpg', 'Harus sukses dan berhasil', '1', '2015-04-17 08:54:54', '1', '1'),
(5, 'mdbz556295eed6ee2', 'fajsfdl@hfdaf.com', 'mdQBEgkETFzPU', 'nazir arifin', '', '+62-984934374', '', '', '0', '2015-05-25 10:24:30', '1', '1'),
(6, 'mdbz5562973bd79c8', 'rizan@gmail.com', 'mdTyH1l4J7ivY', 'haji muhidin', '', '+62-98398439534', '', '', '0', '2015-05-25 10:30:03', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE IF NOT EXISTS `berita` (
  `ID_BERITA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ADMIN` smallint(6) DEFAULT NULL,
  `JUDUL_BERITA` varchar(120) DEFAULT NULL,
  `PENGANTAR_BERITA` mediumtext,
  `ISI_BERITA` text,
  `FOTO_BERITA` varchar(60) DEFAULT NULL,
  `TANGGAL_BERITA` datetime DEFAULT NULL,
  `TAG_BERITA` varchar(120) DEFAULT NULL,
  `STATUS_BERITA` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_BERITA`),
  KEY `FK_BERITA_ADMIN` (`ID_ADMIN`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`ID_BERITA`, `ID_ADMIN`, `JUDUL_BERITA`, `PENGANTAR_BERITA`, `ISI_BERITA`, `FOTO_BERITA`, `TANGGAL_BERITA`, `TAG_BERITA`, `STATUS_BERITA`) VALUES
(1, 1, 'Tanaman Membusuk, Harga Cabai Terjun Bebas Rp 6.000 Sekilo', 'Selain harga turun, cabai membusuk akibat tanaman terus menerus diguyur hujan. ''Pendapatan anjlok, tanaman juga rusak,'' kata petani cabai, Ansori, Sabtu 11 April 2015.', '<div><br></div><div>Saat harga cabai mahal, katanya, tanaman cabai sebanyak 2.800 batang di lahan seluas 500 meter persegi mampu memanen setiap batang menghasilkan 1,5 kilogram. Setelah diguyur hujan tanaman membusuk dan hanya mampu menghasilkan setengah kilogram. Namun ia tetap mempertahankan tanaman cabai di lahannya.</div><div><br></div><div>Menurutnya, harga cabai pernah anjlok sampai Rp 3 ribu kilogram. Namun, Ansori tetap semangat memanam cabai. Harga cabai, katanya, tak bisa diprediksi. Harga meroket saat pasokan di pasar rendah. Sedangkan harga anjlok ketika cabai membanjiri pasar.&nbsp;</div><div><br></div><div>''Petani latah, menanam cabai saat harga mahal. Dampaknya pasokan melimpah harga terjun bebas,'' ujarnya.&nbsp;</div><div><br></div><div>Untuk itu, pemerintah harus turun tangan untuk mengatur pola tanam. Sehingga harga cabai stabil tak langsung meroket atau terjun bebas. Saat harga mahal, sekali panen Ansori mengantongi uang sampai Rp 40 juta. Saat harga cabai murah seperti sekarang hasil penjualan cabai sebesar Rp 8,5 juta.&nbsp;</div><div><br></div><div>Saat harga cabai murah, katanya, petani merugi. Penjualan cabai tak sebanding dengan biaya produksi. Rata-rata panen cabai yakni pada April-Mei dan September. Cabai dari Batu dipasok ke sejumlah pasar tradisional di Malang dan Batu.&nbsp;</div>', 'c8f52781dc11ea16f5bb33ec7499b420.jpg', '2015-04-13 09:03:22', '', '1'),
(2, 1, 'Bandara Soekarno-Hatta Tak Penuhi Standar Keamanan', '"Penerbangan dari Soekarno-Hatta yang tiba di Changi, Singapura, itu selalu ditunggui oleh petugas keamanan di sana," kata Sekretaris Jenderal INACA Tengku Burhanuddin saat dihubungi, Jumat, 10 April 2015.&nbsp;', '<div><br></div><div>Menurut Tengku, kondisi itu membuktikan Singapura belum mempercayai keamanan Soekarno-Hatta. Sebab Bandara Soekarno-Hatta belum mengantongi sertifikat standar keamanan global sesuai Organisasi Penerbangan Sipil Internasional (International Civil Aviation Organization/ ICAO) seperti Ngurah Rai.&nbsp;</div><div><br></div><div>"Kementerian Perhubungan tak boleh tawar-menawar. Bandara internasional paling tidak harus TSA level (lolos standar keamanan Badan Keamanan Transportasi Amerika Serikat atau Transportation Security Administration)," katanya.&nbsp;</div><div><br></div><div>Tak adanya sertifikat keamanan global di Soekarno-Hatta itu, kata Tengku, merupakan gambaran betapa bandara di Indonesia belum memenuhi standar keamanan. Apalagi, kata Tengku, bandara-bandara di wilayah timur Indonesia dan wilayah barat lainnya. Padahal, bandara-bandara itu sudah dikelola oleh PT Angkasa Pura I dan PT Angkasa Pura II.&nbsp;</div><div><br></div><div>"Di daerah timur itu, masyarakatnya kurang perhatian. Dibikin pagar, pagarnya dilobangi. Ketika diusir petugas, mereka marah dan melawan," kata Burhanuddin.&nbsp;</div><div><br></div><div>Burhanuddin mendesak Menteri Perhubungan Ignasius Jonan tak hanya mengaudit maskapai. Audit itu juga harus dilakukan terhadap pengelola bandara. "Pernah diaudit apa tidak itu bandara, nggak tahu kami," katanya.&nbsp;</div><div><br></div><div>Standar keamanan bandara menjadi sorotan setelah kasus penyusupan oleh Mario Steven Ambarita, 21 tahun, Selasa, 7 April 2015. Pemuda asal Rokan Hilir, Riau, itu berhasil masuk ke rongga roda pesawat Garuda Indonesia GA 177 tujuan Pekanbaru-Jakarta ketika pesawat hendak takeoff dari runaway Bandara Sultan Syarif Kasim II, Pekanbaru. Atas penyusupan itu, Bandara SSK II akan diaudit khusus dan diperkirakan selesai pekan depan.&nbsp;</div><div><br></div><div>Sebelumnya, pada Oktober 2007 lampau, Bandara Ngurah Rai, Bali, akhirnya mengantongi standar keamanan penerbangan internasional. Badan Keamanan Transportasi Amerika Serikat (TSA) menilai keamanan Ngurah Rai telah memenuhi standar organisasi penerbangan sipil Internasional (ICAO). Pada Desember 2005, TSA sempat menyatakan Ngurah Rai tak memenuhi standar ICAO sehingga mengeluarkan travel warning kepada warga Amerika yang hendak ke Bali. Tak hanya Amerika, Australia juga mengeluarkan travel warning serupa.</div>', 'eae80cfdf3cecd9904f4d254bcfb2535.jpg', '2015-04-13 09:14:24', '', '1'),
(3, 1, 'Salip ExxonMobil, PetroChina Jadi Perusahaan Minyak Terbesar', 'Pada perdagangan Kamis, 9 April 2015, kapitalisasi ExxonMobil ditutup US$ 352,6 miliar di Shanghai. Kapitalisasi pasar PetroChina telah naik 13,81 persen dalam 12 bulan terakhir, sementara nilai pasar ExxonMobil telah turun 14 persen akibat turunnya harga minyak.&nbsp;', '<div><br></div><div>Selain itu, harga saham perusahaan Cina kelas A ini telah melonjak 61 persen sejak awal April. Terakhir kali, PetroChina berada di atas ExxonMobil pada penutupan perdagangan 25 Juni 2010.</div><div><br></div><div>Menurut ekonom, hal ini bisa terjadi karena Cina berani meliberalisasi pasarnya. "PetroChina mengalami nilai positif saat ini karena reformasi ekonomi yang pemerintah Cina lakukan. Pemerintah Cina memberikan kebebasan yang seluas-luasnya bagi pengaturan investasi mereka," kata Mark Matthews, Kepala Penelitian Asia di Bank Julius Baer &amp; Co Singapura, seperti dilansir RT News, Kamis, 9 April 2015.&nbsp;</div><div><br></div><div>Perusahaan minyak di seluruh dunia telah menghadapi masa sulit karena harga minyak mentah mulai jatuh pada musim panas lalu.&nbsp;</div><div><br></div><div>PetroChina adalah perusahaan terdaftar milik China National Petroleum Corporation (CNPC) dengan hampir semua keuntungan operasi berasal dari sektor eksplorasi dan produksi. Juga, dari sedikit kontribusi pada unit gas alam dan jaringan pipa.</div>', '37ede1a29ef3753e1e3ada0d40413b14.jpg', '2015-04-13 09:19:53', '', '1'),
(4, 1, 'Penunjukan Pertamina di Blok Mahakam Dinilai Terlambat', '"Pemerintah harus resmi menunjuk Pertamina sebagai pengelola Blok Mahakam," kata Ketua Komisi Energi DPR RI, Kardaya Wamika di Balikpapan, Kamis malam, 9 April 2015. Kardaya berpendapat suatu perusahaan migas setidaknya butuh waktu lima tahun untuk mempersiapkan Blok Mahakam.&nbsp;', '<div><br></div><div>Menurutnya Pertamina saat ini sudah sangat terlambat dalam mempersiapkan diri menerima tongkat estafet pengelolaan Blok Mahakam. "Sudah sangat terlambat penunjukan Pertamina saat ini. Semestinya jauh hari sebelum ini," ia menuturkan.&nbsp;</div><div><br></div><div>Pemerintah, kata Kardaya punya hak penuh untuk menunjuk langsung operator blok migas yang habis masa kontraknya. Menurutnya sudah saatnya pemerintah mempercayai Pertamina mengelola blok kaya potensi migas seperti sudah terjadi di Madura, Jawa dan Sumatera.&nbsp;</div><div>"Ada aturannya dalam Undang-Undang Migas," ujarnya.&nbsp;</div><div><br></div><div>Pertamina tentunya sudah punya kewenangan dalam menjalin kerja sama dengan swasta maupun pemerintah daerah dalam pengelolaan Blok Mahakam. Dalam kasus ini, Kardaya menilai operator terdahulu yakni Total dan Inpex yang paling berpengalaman dalam pengelolaan Blok Mahakam.&nbsp;</div><div><br></div><div>"Seperti contohnya terjadi di Sumatera, produksi migas Pertamina menurun drastis dari sebelumnya 60 ribu menjadi hanya 12 ribu barel minyak bumi," kata dia. Kardaya menyatakan Pertamina harus tetap memperoleh participating interest mayoritas dalam pengelolaan Blok Mahakam. Sisanya diberikan pada swasta dan pemerintah daerah.&nbsp;</div><div><br></div><div>"Misalkan dapat 70 hingga 80 persen. Sisanya untuk swasta dan pemerintah daerah," kata dia.&nbsp;</div><div><br></div><div>Hak partisipasi pemda, menurut Kardaya, juga harus dimanfaatkan sepenuhnya guna kemakmuran masyarakat Kutai Kartanegara dan Kalimantan Timur yang menjadi lokasi Blok Mahakam. Pemerintah pusat harus memastikan agar kepemilikan pemda tidak beralih pada pihak swasta. "Jangan sampai kemudian dijual pada pihak swasta dan asing," tuturnya.</div><div><br></div><div>Produksi gas Blok Mahakam mencapai 1.750 juta kaki kubik per hari (MMCFD) dan minyak 66.400 barel per hari. Produksi ini menurun dibandingkan realisasi tahun sebelumnya yaitu 1.757 MMCFD dan 67.800 barel per hari.&nbsp;</div><div><br></div><div>Blok Mahakam terdiri 107 sumur lama serta 111 sumur baru yang di antaranya yang masih dalam pengembangan. Setidaknya terdapat 20 ribu karyawan. Total E&amp;P Indonesie menyumbangkan penerimaan negara sebesar Rp 830 triliun.</div>', 'c7aa4fea2b1b755951e0d9ec91c2f836.jpg', '2015-04-13 09:24:46', '', '1'),
(5, 1, 'Lima Produk Unik di Inacraft 2015', '', '<div>1. Lampion Kertas Singkong</div><div><br></div><div>Lampu yang berasal dari budaya Cina ini diproduksi oleh L&amp;D Art Lamp, badan usaha asal Bandung. Dimiliki oleh Lisye Diana, perusahaan ini kerap memproduksi lampion dari barang tak terpakai, seperti kulit singkong, serat belimbing, ataupun daun bambu.</div><div>"Tahun ini spesial di lampion kertas singkong," ujar Septi, anak Lisye Diana, Jumat, 10 April 2015.</div><div><br></div><div>Lampion berada di kisaran harga Rp 40.000 hingga 800.000. Ukurannya juga bermacam-macam. Ada yang berbentuk bulat seperti lampion festival, hingga lampion interior besar yang dibalut kain brukat berukuran hingga 1,5 meter.</div><div><br></div><div>2. Bantal Buatan Tangan Segala Rupa</div><div><br></div><div>Bosan dengan bantal yang berbentuk kotak atau persegi panjang? Kali ini di Inacraft, pengusaha asal Kota Kembang, Rika Marli, memamerkan bantal buatannya yang berbentuk gitar, ukulele, ataupun lego.</div><div><br></div><div>Yang unik dari bantal ini, aksesoris pendukung bantal menggunakan kain perca yang disulam menggunakan tangan (hand made). Warna yang diusung bantal ini juga sebagian besar bercitra pastel atau lembut.</div><div><br></div><div>Selain bantal, Rina juga membawa hasil karyanya, yakni sofa bulat berbahan water resist bean. "Jadi kalau terkena air, sofa ini tidak lembab dan ringan bobotnya," kata Rika. Untuk bantal, Rika mematok harga Rp 100.000-375.000. Sementara sofa dibanderol harga Rp 1 juta.</div><div><br></div><div>3. Karpet "Star Wars"</div><div><br></div><div>Menjumpai karpet dengan motif Timur Tengah atau polkadot mungkin gampang ditemukan di pasaran. Namun bagaimana dengan karpet yang bergambar tokoh film dan kartun?&nbsp;</div><div><br></div><div>Inilah yang menjadi motivasi Tinton Satrio, pemilik CV Leoni Handmade. Tinton yang merupakan penggemar sekuel film Star Wars dan serial kartun Amerika Serikat ini mengkombinasikan dua kesukaannya itu menjadi motif utama karpet.</div><div><br></div><div>Uniknya, warna yang terjahit di karpet adalah warna pastel sehingga membuat motif Star Wars tidak terasa serius. Selain karpet, beragam sajadah juga dijual di toko ini.</div><div><br></div><div>Harga karpet Tinton dimulai dari Rp 450.000 untuk yang berukuran kecil ataupun sajadah. Untuk karpet sedang ukuran 1,5x2 meter, harganya mencapai Rp 2,2 juta.</div><div><br></div><div>4. Meja Langka Mozaik Maroko</div><div><br></div><div>Pernah melihat meja yang tampak atasnya dihiasi ornamen keramik yang disusun seperti mozaik? Hiasan itu yang disebut mozaik Maroko (Moroccan Mozaik).</div><div><br></div><div>Teknik menyusun mozaik ini dinamakan Zellige. Di Indonesia, hanya ada satu orang yang mampu menguasai teknik ini, yakni Gene Turangan. Bahkan, dia menciptakan zellige model baru melalui penyusunan mozaik yang lebih rapi dan longgar.</div><div><br></div><div>Pria paruh baya ini memboyong hasilnya karyanya untuk dipamerkan di Inacraft. Meja unik ini berbentuk persegi, persegi panjang, dan melingkar.</div><div><br></div><div>Gene menghargai meja buatannya dengan kisaran Rp 4-5 juta untuk meja ukuran di bawah 1x2 meter. Sementara ukuran yang lebih besar berkisar pada harga RP 5-10 juta.</div><div><br></div><div>"Kalau beli di luar negeri, harganya bisa Rp 20 juta. Itupun hanya panelnya saja, belum dengan rangka mejanya," Gene berujar.</div><div><br></div><div>5. Lampu Katun Gatot Kaca</div><div><br></div><div>Lampu ini membawa konsep rupa-rupa ala pahlawan. Bentuk dasarnya lingkaran berbahan plastik dan dijahit dengan benang katun warna-warni. Hasilnya, lampu tidur beragam rupa seperti tokoh wayang Gatot Kaca, tokoh kartun Spiderman, bahkan polisi lalu lintas.</div><div><br></div><div>Penyusun konsep ini adalah Guntoro Rusli dan Yenny Wibowo, pasangan asal Surabaya. Mereka menawarkan konsep lampu mini yang menjadi "teman" sebelum tidur.</div><div><br></div><div>Harga lampu tidak tergolong mahal karena yang berdiameter 15 cm saja berharga Rp 50.000. Sedangkan lampu Gatot Kaca yang dinamai boli ini dibanderol seharga Rp 150.000.</div><div><br></div><div>Inacraft berlangsung dari 8-12 April 2015 di Jakarta Convention Center, Jakarta Pusat. Dalam siaran pers yang diterima Tempo, penyelenggara menyatakan pameran ke-17 ini diikuti lebih dari 1.450 peserta dengan jumlah stan lebih dari 1.300 stan. Pameran yang diselenggarakan Asosiasi Eksportir dan Produsen Handicraft ini menargetkan omset transaksi penjualan untuk ritel sebesar Rp 127 miliar dan kontrak dagang US$ 10 juta (sekitar Rp 129,54 miliar).</div><div><br></div>', '6efcea643d7ed9f61a6320ac569a4ac4.jpg', '2015-04-13 09:29:41', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `biayakurir`
--

CREATE TABLE IF NOT EXISTS `biayakurir` (
  `ID_BIAYAKURIR` int(11) NOT NULL AUTO_INCREMENT,
  `ID_KURIR` tinyint(4) NOT NULL,
  `ID_KOTA` smallint(6) NOT NULL,
  `BIAYA_BIAYAKURIR` float NOT NULL,
  `LANJUTAN_BIAYAKURIR` float DEFAULT NULL,
  PRIMARY KEY (`ID_BIAYAKURIR`),
  KEY `FK_KURIR_BIAYA` (`ID_KURIR`),
  KEY `FK_KURIR_KOTA` (`ID_KOTA`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=777 ;

--
-- Dumping data for table `biayakurir`
--

INSERT INTO `biayakurir` (`ID_BIAYAKURIR`, `ID_KURIR`, `ID_KOTA`, `BIAYA_BIAYAKURIR`, `LANJUTAN_BIAYAKURIR`) VALUES
(1, 3, 5, 20000, 10700),
(2, 3, 6, 39800, 16100),
(3, 3, 7, 39800, 16100),
(4, 3, 8, 39800, 16100),
(5, 3, 9, 39800, 16100),
(6, 3, 10, 20000, 10700),
(7, 3, 11, 39800, 16100),
(8, 3, 12, 39800, 16100),
(9, 3, 13, 20000, 10700),
(10, 3, 14, 34700, 14400),
(11, 3, 15, 34700, 14400),
(12, 3, 16, 34700, 14400),
(13, 3, 17, 34700, 14400),
(14, 3, 18, 34700, 14400),
(15, 3, 19, 34700, 14400),
(16, 3, 20, 34700, 14400),
(17, 3, 21, 34700, 14400),
(18, 3, 22, 34700, 14400),
(19, 3, 23, 34700, 14400),
(20, 3, 24, 34700, 14400),
(21, 3, 25, 34700, 14400),
(22, 3, 26, 34700, 14400),
(23, 3, 27, 34700, 14400),
(24, 3, 28, 34700, 14400),
(25, 3, 29, 20000, 10700),
(26, 3, 30, 20000, 10700),
(27, 3, 31, 39800, 16100),
(28, 3, 32, 39800, 16100),
(29, 3, 33, 39800, 16100),
(30, 3, 34, 39800, 16100),
(31, 3, 35, 39800, 16100),
(32, 3, 36, 39800, 16100),
(33, 3, 37, 39800, 16100),
(34, 3, 38, 20000, 10700),
(35, 3, 39, 39800, 16100),
(36, 3, 40, 39800, 16100),
(37, 3, 41, 39800, 16100),
(38, 3, 42, 39800, 16100),
(39, 3, 43, 39800, 16100),
(40, 3, 44, 20000, 10700),
(41, 3, 45, 39800, 16100),
(42, 3, 46, 39800, 16100),
(43, 3, 47, 39800, 16100),
(44, 3, 48, 39800, 16100),
(45, 3, 49, 39800, 16100),
(46, 3, 50, 39800, 16100),
(47, 3, 51, 39800, 16100),
(48, 3, 52, 39800, 16100),
(49, 3, 53, 39800, 16100),
(50, 3, 54, 39800, 16100),
(51, 3, 55, 39800, 16100),
(52, 3, 56, 20000, 10700),
(53, 3, 57, 39800, 16100),
(54, 3, 58, 39800, 16100),
(55, 3, 59, 39800, 16100),
(56, 3, 60, 39800, 16100),
(57, 3, 61, 39800, 16100),
(58, 3, 62, 39800, 16100),
(59, 3, 63, 39800, 16100),
(60, 3, 64, 39800, 16100),
(61, 3, 65, 39800, 16100),
(62, 3, 66, 20000, 10700),
(63, 3, 67, 39800, 16100),
(64, 3, 68, 39800, 16100),
(65, 3, 69, 39800, 16100),
(66, 3, 70, 39800, 16100),
(67, 3, 71, 39800, 16100),
(68, 3, 72, 39800, 16100),
(69, 3, 73, 39800, 16100),
(70, 3, 74, 39800, 16100),
(71, 3, 75, 39800, 16100),
(72, 3, 76, 39800, 16100),
(73, 3, 77, 39800, 16100),
(74, 3, 78, 39800, 16100),
(75, 3, 79, 39800, 16100),
(76, 3, 80, 39800, 16100),
(77, 3, 81, 39800, 16100),
(78, 3, 82, 39800, 16100),
(79, 3, 83, 39800, 16100),
(80, 3, 84, 39800, 16100),
(81, 3, 85, 39800, 16100),
(82, 3, 86, 39800, 16100),
(83, 3, 87, 39800, 16100),
(84, 3, 88, 39800, 16100),
(85, 3, 89, 39800, 16100),
(86, 3, 90, 39800, 16100),
(87, 3, 91, 39800, 16100),
(88, 3, 92, 39800, 16100),
(89, 3, 93, 39800, 16100),
(90, 3, 94, 39800, 16100),
(91, 3, 95, 39800, 16100),
(92, 3, 96, 39800, 16100),
(93, 3, 97, 39800, 16100),
(94, 3, 98, 20000, 10700),
(95, 3, 99, 39800, 16100),
(96, 3, 100, 39800, 16100),
(97, 3, 101, 39800, 16100),
(98, 3, 102, 39800, 16100),
(99, 3, 103, 39800, 16100),
(100, 3, 104, 39800, 16100),
(101, 3, 105, 39800, 16100),
(102, 3, 106, 39800, 16100),
(103, 3, 107, 16000, 10700),
(104, 3, 108, 39800, 16100),
(105, 3, 109, 39800, 16100),
(106, 3, 110, 39800, 16100),
(107, 3, 111, 39800, 16100),
(108, 3, 112, 39800, 16100),
(109, 3, 113, 39800, 16100),
(110, 3, 114, 39800, 16100),
(111, 3, 115, 39800, 16100),
(112, 3, 116, 39800, 16100),
(113, 3, 117, 39800, 16100),
(114, 3, 118, 39800, 16100),
(115, 3, 119, 39800, 16100),
(116, 3, 120, 39800, 16100),
(117, 3, 121, 20000, 10700),
(118, 3, 122, 39800, 16100),
(119, 3, 123, 39800, 16100),
(120, 3, 124, 39800, 16100),
(121, 3, 125, 39800, 16100),
(122, 3, 126, 39800, 16100),
(123, 3, 127, 39800, 16100),
(124, 3, 128, 39800, 16100),
(125, 3, 129, 39800, 16100),
(126, 3, 130, 39800, 16100),
(127, 3, 131, 20000, 10700),
(128, 3, 132, 39800, 16100),
(129, 3, 133, 39800, 16100),
(130, 3, 134, 39800, 16100),
(131, 3, 135, 39800, 16100),
(132, 3, 136, 39800, 16100),
(133, 3, 137, 39800, 16100),
(134, 3, 138, 39800, 16100),
(135, 3, 139, 39800, 16100),
(136, 3, 140, 39800, 16100),
(137, 3, 141, 39800, 16100),
(138, 3, 142, 39800, 16100),
(139, 3, 143, 39800, 16100),
(140, 3, 144, 39800, 16100),
(141, 3, 145, 39800, 16100),
(142, 3, 146, 39800, 16100),
(143, 3, 147, 39800, 16100),
(144, 3, 148, 39800, 16100),
(145, 3, 149, 39800, 16100),
(146, 3, 150, 15000, 4500),
(147, 3, 151, 28200, 5200),
(148, 3, 152, 28200, 5200),
(149, 3, 153, 28200, 5200),
(150, 3, 154, 28200, 5200),
(151, 3, 155, 28200, 5200),
(152, 3, 156, 28200, 5200),
(153, 3, 157, 28200, 5200),
(154, 3, 158, 28200, 5200),
(155, 3, 159, 28200, 5200),
(156, 3, 160, 28200, 5200),
(157, 3, 161, 28200, 5200),
(158, 3, 162, 28200, 5200),
(159, 3, 163, 28200, 5200),
(160, 3, 164, 28200, 5200),
(161, 3, 165, 28200, 5200),
(162, 3, 166, 28200, 5200),
(163, 3, 167, 28200, 5200),
(164, 3, 168, 28200, 5200),
(165, 3, 169, 15000, 4500),
(166, 3, 170, 28200, 5200),
(167, 3, 171, 28200, 5200),
(168, 3, 172, 28200, 5200),
(169, 3, 173, 28200, 5200),
(170, 3, 174, 28200, 5200),
(171, 3, 175, 28200, 5200),
(172, 3, 176, 28200, 5200),
(173, 3, 177, 28200, 5200),
(174, 3, 178, 28200, 5200),
(175, 3, 179, 28200, 5200),
(176, 3, 180, 28200, 5200),
(177, 3, 181, 28200, 5200),
(178, 3, 182, 28200, 5200),
(179, 3, 183, 28200, 5200),
(180, 3, 184, 28200, 5200),
(181, 3, 185, 28200, 5200),
(182, 3, 186, 28200, 5200),
(183, 3, 187, 28200, 5200),
(184, 3, 188, 28200, 5200),
(185, 3, 189, 15000, 4500),
(186, 3, 190, 28200, 5200),
(187, 3, 191, 28200, 5200),
(188, 3, 192, 28200, 5200),
(189, 3, 193, 28200, 5200),
(190, 3, 194, 28200, 5200),
(191, 3, 195, 28200, 5200),
(192, 3, 196, 28200, 5200),
(193, 3, 197, 28200, 5200),
(194, 3, 198, 15000, 4500),
(195, 3, 199, 28200, 5200),
(196, 3, 200, 15000, 4500),
(197, 3, 201, 28200, 5200),
(198, 3, 202, 28200, 5200),
(199, 3, 203, 28200, 5200),
(200, 3, 204, 28200, 5200),
(201, 3, 205, 28200, 5200),
(202, 3, 206, 28200, 5200),
(203, 3, 207, 15000, 4500),
(204, 3, 208, 28200, 5200),
(205, 3, 209, 28200, 5200),
(206, 3, 210, 28200, 5200),
(207, 3, 211, 28200, 5200),
(208, 3, 212, 28200, 5200),
(209, 3, 213, 28200, 5200),
(210, 3, 214, 28200, 5200),
(211, 3, 215, 28200, 5200),
(212, 3, 216, 28200, 5200),
(213, 3, 217, 15000, 4500),
(214, 3, 218, 28200, 5200),
(215, 3, 219, 28200, 5200),
(216, 3, 220, 28200, 5200),
(217, 3, 221, 15000, 4500),
(218, 3, 222, 28200, 5200),
(219, 3, 223, 28200, 5200),
(220, 3, 224, 28200, 5200),
(221, 3, 225, 28200, 5200),
(222, 3, 226, 28200, 5200),
(223, 3, 227, 28200, 5200),
(224, 3, 228, 28200, 5200),
(225, 3, 229, 28200, 5200),
(226, 3, 230, 28200, 5200),
(227, 3, 231, 28200, 5200),
(228, 3, 232, 28200, 5200),
(229, 3, 233, 15000, 4500),
(230, 3, 234, 28200, 5200),
(231, 3, 235, 28200, 5200),
(232, 3, 236, 28200, 5200),
(233, 3, 237, 28200, 5200),
(234, 3, 238, 28200, 5200),
(235, 3, 239, 28200, 5200),
(236, 3, 240, 28200, 5200),
(237, 3, 241, 28200, 5200),
(238, 3, 242, 28200, 5200),
(239, 3, 243, 15000, 4500),
(240, 3, 244, 28200, 5200),
(241, 3, 245, 28200, 5200),
(242, 3, 246, 28200, 5200),
(243, 3, 247, 28200, 5200),
(244, 3, 248, 15000, 4500),
(245, 3, 249, 15000, 4500),
(246, 3, 250, 28200, 5200),
(247, 3, 251, 28200, 5200),
(248, 3, 252, 28200, 5200),
(249, 3, 253, 28200, 5200),
(250, 3, 254, 28200, 5200),
(251, 3, 255, 15000, 4500),
(252, 3, 256, 28200, 5200),
(253, 3, 257, 28200, 5200),
(254, 3, 258, 28200, 5200),
(255, 3, 259, 28200, 5200),
(256, 3, 260, 28200, 5200),
(257, 3, 261, 28200, 5200),
(258, 3, 262, 28200, 5200),
(259, 3, 263, 28200, 5200),
(260, 3, 264, 28200, 5200),
(261, 3, 265, 28200, 5200),
(262, 3, 266, 15000, 4500),
(263, 3, 267, 15000, 4500),
(264, 3, 268, 15000, 4500),
(265, 3, 269, 28200, 5200),
(266, 3, 270, 28200, 5200),
(267, 3, 271, 28200, 5200),
(268, 3, 272, 28200, 5200),
(269, 3, 273, 28200, 5200),
(270, 3, 274, 28200, 5200),
(271, 3, 275, 28200, 5200),
(272, 3, 276, 28200, 5200),
(273, 3, 277, 28200, 5200),
(274, 3, 278, 28200, 5200),
(275, 3, 279, 28200, 5200),
(276, 3, 280, 28200, 5200),
(277, 3, 281, 28200, 5200),
(278, 3, 282, 28200, 5200),
(279, 3, 283, 28200, 5200),
(280, 3, 284, 28200, 5200),
(281, 3, 285, 28200, 5200),
(282, 3, 286, 28200, 5200),
(283, 3, 287, 8300, 3000),
(284, 3, 288, 19800, 3000),
(285, 3, 289, 19800, 3000),
(286, 3, 290, 19800, 3000),
(287, 3, 291, 19800, 3000),
(288, 3, 292, 19800, 3000),
(289, 3, 293, 19800, 3000),
(290, 3, 294, 19800, 3000),
(291, 3, 295, 19800, 3000),
(292, 3, 296, 12000, 3000),
(293, 3, 297, 19800, 3000),
(294, 3, 298, 19800, 3000),
(295, 3, 299, 12000, 3000),
(296, 3, 300, 19800, 3000),
(297, 3, 301, 19800, 3000),
(298, 3, 302, 19800, 3000),
(299, 3, 303, 19800, 3000),
(300, 3, 304, 19800, 3000),
(301, 3, 305, 12000, 3000),
(302, 3, 306, 19800, 3000),
(303, 3, 307, 19800, 3000),
(304, 3, 308, 12000, 3000),
(305, 3, 309, 19800, 3000),
(306, 3, 310, 19800, 3000),
(307, 3, 311, 19800, 3000),
(308, 3, 312, 19800, 3000),
(309, 3, 313, 19800, 3000),
(310, 3, 314, 19800, 3000),
(311, 3, 315, 19800, 3000),
(312, 3, 316, 12000, 3000),
(313, 3, 317, 12000, 3000),
(314, 3, 318, 12000, 3000),
(315, 3, 319, 12000, 3000),
(316, 3, 320, 12000, 3000),
(317, 3, 321, 12000, 3000),
(318, 3, 322, 19800, 3000),
(319, 3, 323, 19800, 3000),
(320, 3, 324, 19800, 3000),
(321, 3, 325, 12000, 3000),
(322, 3, 326, 19800, 3000),
(323, 3, 327, 19800, 3000),
(324, 3, 328, 19800, 3000),
(325, 3, 329, 19800, 3000),
(326, 3, 330, 19800, 3000),
(327, 3, 331, 19800, 3000),
(328, 3, 332, 12000, 3000),
(329, 3, 333, 19800, 3000),
(330, 3, 334, 19800, 3000),
(331, 3, 335, 19800, 3000),
(332, 3, 336, 19800, 3000),
(333, 3, 337, 12000, 3000),
(334, 3, 338, 19800, 3000),
(335, 3, 339, 19800, 3000),
(336, 3, 340, 19800, 3000),
(337, 3, 5, 20000, 10700),
(338, 3, 6, 39800, 16100),
(339, 3, 7, 39800, 16100),
(340, 3, 8, 39800, 16100),
(341, 3, 9, 39800, 16100),
(342, 3, 10, 20000, 10700),
(343, 3, 11, 39800, 16100),
(344, 3, 12, 39800, 16100),
(345, 3, 13, 20000, 10700),
(346, 3, 14, 34700, 14400),
(347, 3, 15, 34700, 14400),
(348, 3, 16, 34700, 14400),
(349, 3, 17, 34700, 14400),
(350, 3, 18, 34700, 14400),
(351, 3, 19, 34700, 14400),
(352, 3, 20, 34700, 14400),
(353, 3, 21, 34700, 14400),
(354, 3, 22, 34700, 14400),
(355, 3, 23, 34700, 14400),
(356, 3, 24, 34700, 14400),
(357, 3, 25, 34700, 14400),
(358, 3, 26, 34700, 14400),
(359, 3, 27, 34700, 14400),
(360, 3, 28, 34700, 14400),
(361, 3, 29, 20000, 10700),
(362, 3, 30, 20000, 10700),
(363, 3, 31, 39800, 16100),
(364, 3, 32, 39800, 16100),
(365, 3, 33, 39800, 16100),
(366, 3, 34, 39800, 16100),
(367, 3, 35, 39800, 16100),
(368, 3, 36, 39800, 16100),
(369, 3, 37, 39800, 16100),
(370, 3, 38, 20000, 10700),
(371, 3, 39, 39800, 16100),
(372, 3, 40, 39800, 16100),
(373, 3, 41, 39800, 16100),
(374, 3, 42, 39800, 16100),
(375, 3, 43, 39800, 16100),
(376, 3, 44, 20000, 10700),
(377, 3, 45, 39800, 16100),
(378, 3, 46, 39800, 16100),
(379, 3, 47, 39800, 16100),
(380, 3, 48, 39800, 16100),
(381, 3, 49, 39800, 16100),
(382, 3, 50, 39800, 16100),
(383, 3, 51, 39800, 16100),
(384, 3, 52, 39800, 16100),
(385, 3, 53, 39800, 16100),
(386, 3, 54, 39800, 16100),
(387, 3, 55, 39800, 16100),
(388, 3, 56, 20000, 10700),
(389, 3, 57, 39800, 16100),
(390, 3, 58, 39800, 16100),
(391, 3, 59, 39800, 16100),
(392, 3, 60, 39800, 16100),
(393, 3, 61, 39800, 16100),
(394, 3, 62, 39800, 16100),
(395, 3, 63, 39800, 16100),
(396, 3, 64, 39800, 16100),
(397, 3, 65, 39800, 16100),
(398, 3, 66, 20000, 10700),
(399, 3, 67, 39800, 16100),
(400, 3, 68, 39800, 16100),
(401, 3, 69, 39800, 16100),
(402, 3, 70, 39800, 16100),
(403, 3, 71, 39800, 16100),
(404, 3, 72, 39800, 16100),
(405, 3, 73, 39800, 16100),
(406, 3, 74, 39800, 16100),
(407, 3, 75, 39800, 16100),
(408, 3, 76, 39800, 16100),
(409, 3, 77, 39800, 16100),
(410, 3, 78, 39800, 16100),
(411, 3, 79, 39800, 16100),
(412, 3, 80, 39800, 16100),
(413, 3, 81, 39800, 16100),
(414, 3, 82, 39800, 16100),
(415, 3, 83, 39800, 16100),
(416, 3, 84, 39800, 16100),
(417, 3, 85, 39800, 16100),
(418, 3, 86, 39800, 16100),
(419, 3, 87, 39800, 16100),
(420, 3, 88, 39800, 16100),
(421, 3, 89, 39800, 16100),
(422, 3, 90, 39800, 16100),
(423, 3, 91, 39800, 16100),
(424, 3, 92, 39800, 16100),
(425, 3, 93, 39800, 16100),
(426, 3, 94, 39800, 16100),
(427, 3, 95, 39800, 16100),
(428, 3, 96, 39800, 16100),
(429, 3, 97, 39800, 16100),
(430, 3, 98, 20000, 10700),
(431, 3, 99, 39800, 16100),
(432, 3, 100, 39800, 16100),
(433, 3, 101, 39800, 16100),
(434, 3, 102, 39800, 16100),
(435, 3, 103, 39800, 16100),
(436, 3, 104, 39800, 16100),
(437, 3, 105, 39800, 16100),
(438, 3, 106, 39800, 16100),
(439, 3, 107, 16000, 10700),
(440, 3, 108, 39800, 16100),
(441, 3, 109, 39800, 16100),
(442, 3, 110, 39800, 16100),
(443, 3, 111, 39800, 16100),
(444, 3, 112, 39800, 16100),
(445, 3, 113, 39800, 16100),
(446, 3, 114, 39800, 16100),
(447, 3, 115, 39800, 16100),
(448, 3, 116, 39800, 16100),
(449, 3, 117, 39800, 16100),
(450, 3, 118, 39800, 16100),
(451, 3, 119, 39800, 16100),
(452, 3, 120, 39800, 16100),
(453, 3, 121, 20000, 10700),
(454, 3, 122, 39800, 16100),
(455, 3, 123, 39800, 16100),
(456, 3, 124, 39800, 16100),
(457, 3, 125, 39800, 16100),
(458, 3, 126, 39800, 16100),
(459, 3, 127, 39800, 16100),
(460, 3, 128, 39800, 16100),
(461, 3, 129, 39800, 16100),
(462, 3, 130, 39800, 16100),
(463, 3, 131, 20000, 10700),
(464, 3, 132, 39800, 16100),
(465, 3, 133, 39800, 16100),
(466, 3, 134, 39800, 16100),
(467, 3, 135, 39800, 16100),
(468, 3, 136, 39800, 16100),
(469, 3, 137, 39800, 16100),
(470, 3, 138, 39800, 16100),
(471, 3, 139, 39800, 16100),
(472, 3, 140, 39800, 16100),
(473, 3, 141, 39800, 16100),
(474, 3, 142, 39800, 16100),
(475, 3, 143, 39800, 16100),
(476, 3, 144, 39800, 16100),
(477, 3, 145, 39800, 16100),
(478, 3, 146, 39800, 16100),
(479, 3, 147, 39800, 16100),
(480, 3, 148, 39800, 16100),
(481, 3, 149, 39800, 16100),
(482, 3, 150, 15000, 4500),
(483, 3, 151, 28200, 5200),
(484, 3, 152, 28200, 5200),
(485, 3, 153, 28200, 5200),
(486, 3, 154, 28200, 5200),
(487, 3, 155, 28200, 5200),
(488, 3, 156, 28200, 5200),
(489, 3, 157, 28200, 5200),
(490, 3, 158, 28200, 5200),
(491, 3, 159, 28200, 5200),
(492, 3, 160, 28200, 5200),
(493, 3, 161, 28200, 5200),
(494, 3, 162, 28200, 5200),
(495, 3, 163, 28200, 5200),
(496, 3, 164, 28200, 5200),
(497, 3, 165, 28200, 5200),
(498, 3, 166, 28200, 5200),
(499, 3, 167, 28200, 5200),
(500, 3, 168, 28200, 5200),
(501, 3, 169, 15000, 4500),
(502, 3, 170, 28200, 5200),
(503, 3, 171, 28200, 5200),
(504, 3, 172, 28200, 5200),
(505, 3, 173, 28200, 5200),
(506, 3, 174, 28200, 5200),
(507, 3, 175, 28200, 5200),
(508, 3, 176, 28200, 5200),
(509, 3, 177, 28200, 5200),
(510, 3, 178, 28200, 5200),
(511, 3, 179, 28200, 5200),
(512, 3, 180, 28200, 5200),
(513, 3, 181, 28200, 5200),
(514, 3, 182, 28200, 5200),
(515, 3, 183, 28200, 5200),
(516, 3, 184, 28200, 5200),
(517, 3, 185, 28200, 5200),
(518, 3, 186, 28200, 5200),
(519, 3, 187, 28200, 5200),
(520, 3, 188, 28200, 5200),
(521, 3, 189, 15000, 4500),
(522, 3, 190, 28200, 5200),
(523, 3, 191, 28200, 5200),
(524, 3, 192, 28200, 5200),
(525, 3, 193, 28200, 5200),
(526, 3, 194, 28200, 5200),
(527, 3, 195, 28200, 5200),
(528, 3, 196, 28200, 5200),
(529, 3, 197, 28200, 5200),
(530, 3, 198, 15000, 4500),
(531, 3, 199, 28200, 5200),
(532, 3, 200, 15000, 4500),
(533, 3, 201, 28200, 5200),
(534, 3, 202, 28200, 5200),
(535, 3, 203, 28200, 5200),
(536, 3, 204, 28200, 5200),
(537, 3, 205, 28200, 5200),
(538, 3, 206, 28200, 5200),
(539, 3, 207, 15000, 4500),
(540, 3, 208, 28200, 5200),
(541, 3, 209, 28200, 5200),
(542, 3, 210, 28200, 5200),
(543, 3, 211, 28200, 5200),
(544, 3, 212, 28200, 5200),
(545, 3, 213, 28200, 5200),
(546, 3, 214, 28200, 5200),
(547, 3, 215, 28200, 5200),
(548, 3, 216, 28200, 5200),
(549, 3, 217, 15000, 4500),
(550, 3, 218, 28200, 5200),
(551, 3, 219, 28200, 5200),
(552, 3, 220, 28200, 5200),
(553, 3, 221, 15000, 4500),
(554, 3, 222, 28200, 5200),
(555, 3, 223, 28200, 5200),
(556, 3, 224, 28200, 5200),
(557, 3, 225, 28200, 5200),
(558, 3, 226, 28200, 5200),
(559, 3, 227, 28200, 5200),
(560, 3, 228, 28200, 5200),
(561, 3, 229, 28200, 5200),
(562, 3, 230, 28200, 5200),
(563, 3, 231, 28200, 5200),
(564, 3, 232, 28200, 5200),
(565, 3, 233, 15000, 4500),
(566, 3, 234, 28200, 5200),
(567, 3, 235, 28200, 5200),
(568, 3, 236, 28200, 5200),
(569, 3, 237, 28200, 5200),
(570, 3, 238, 28200, 5200),
(571, 3, 239, 28200, 5200),
(572, 3, 240, 28200, 5200),
(573, 3, 241, 28200, 5200),
(574, 3, 242, 28200, 5200),
(575, 3, 243, 15000, 4500),
(576, 3, 244, 28200, 5200),
(577, 3, 245, 28200, 5200),
(578, 3, 246, 28200, 5200),
(579, 3, 247, 28200, 5200),
(580, 3, 248, 15000, 4500),
(581, 3, 249, 15000, 4500),
(582, 3, 250, 28200, 5200),
(583, 3, 251, 28200, 5200),
(584, 3, 252, 28200, 5200),
(585, 3, 253, 28200, 5200),
(586, 3, 254, 28200, 5200),
(587, 3, 255, 15000, 4500),
(588, 3, 256, 28200, 5200),
(589, 3, 257, 28200, 5200),
(590, 3, 258, 28200, 5200),
(591, 3, 259, 28200, 5200),
(592, 3, 260, 28200, 5200),
(593, 3, 261, 28200, 5200),
(594, 3, 262, 28200, 5200),
(595, 3, 263, 28200, 5200),
(596, 3, 264, 28200, 5200),
(597, 3, 265, 28200, 5200),
(598, 3, 266, 15000, 4500),
(599, 3, 267, 15000, 4500),
(600, 3, 268, 15000, 4500),
(601, 3, 269, 28200, 5200),
(602, 3, 270, 28200, 5200),
(603, 3, 271, 28200, 5200),
(604, 3, 272, 28200, 5200),
(605, 3, 273, 28200, 5200),
(606, 3, 274, 28200, 5200),
(607, 3, 275, 28200, 5200),
(608, 3, 276, 28200, 5200),
(609, 3, 277, 28200, 5200),
(610, 3, 278, 28200, 5200),
(611, 3, 279, 28200, 5200),
(612, 3, 280, 28200, 5200),
(613, 3, 281, 28200, 5200),
(614, 3, 282, 28200, 5200),
(615, 3, 283, 28200, 5200),
(616, 3, 284, 28200, 5200),
(617, 3, 285, 28200, 5200),
(618, 3, 286, 28200, 5200),
(619, 3, 287, 8300, 3000),
(620, 3, 288, 19800, 3000),
(621, 3, 289, 19800, 3000),
(622, 3, 290, 19800, 3000),
(623, 3, 291, 19800, 3000),
(624, 3, 292, 19800, 3000),
(625, 3, 293, 19800, 3000),
(626, 3, 294, 19800, 3000),
(627, 3, 295, 19800, 3000),
(628, 3, 296, 12000, 3000),
(629, 3, 297, 19800, 3000),
(630, 3, 298, 19800, 3000),
(631, 3, 299, 12000, 3000),
(632, 3, 300, 19800, 3000),
(633, 3, 301, 19800, 3000),
(634, 3, 302, 19800, 3000),
(635, 3, 303, 19800, 3000),
(636, 3, 304, 19800, 3000),
(637, 3, 305, 12000, 3000),
(638, 3, 306, 19800, 3000),
(639, 3, 307, 19800, 3000),
(640, 3, 308, 12000, 3000),
(641, 3, 309, 19800, 3000),
(642, 3, 310, 19800, 3000),
(643, 3, 311, 19800, 3000),
(644, 3, 312, 19800, 3000),
(645, 3, 313, 19800, 3000),
(646, 3, 314, 19800, 3000),
(647, 3, 315, 19800, 3000),
(648, 3, 316, 12000, 3000),
(649, 3, 317, 12000, 3000),
(650, 3, 318, 12000, 3000),
(651, 3, 319, 12000, 3000),
(652, 3, 320, 12000, 3000),
(653, 3, 321, 12000, 3000),
(654, 3, 322, 19800, 3000),
(655, 3, 323, 19800, 3000),
(656, 3, 324, 19800, 3000),
(657, 3, 325, 12000, 3000),
(658, 3, 326, 19800, 3000),
(659, 3, 327, 19800, 3000),
(660, 3, 328, 19800, 3000),
(661, 3, 329, 19800, 3000),
(662, 3, 330, 19800, 3000),
(663, 3, 331, 19800, 3000),
(664, 3, 332, 12000, 3000),
(665, 3, 333, 19800, 3000),
(666, 3, 334, 19800, 3000),
(667, 3, 335, 19800, 3000),
(668, 3, 336, 19800, 3000),
(669, 3, 337, 12000, 3000),
(670, 3, 338, 19800, 3000),
(671, 3, 339, 19800, 3000),
(672, 3, 340, 19800, 3000),
(673, 3, 341, 19800, 3000),
(674, 3, 342, 19800, 3000),
(675, 3, 343, 12000, 3000),
(676, 3, 344, 19800, 3000),
(677, 3, 345, 19800, 3000),
(678, 3, 346, 19800, 3000),
(679, 3, 347, 19800, 3000),
(680, 3, 348, 19800, 3000),
(681, 3, 2, 8300, 1800),
(682, 3, 349, 19800, 3000),
(683, 3, 4, 12000, 3000),
(684, 3, 350, 19800, 3000),
(685, 3, 351, 19800, 3000),
(686, 3, 352, 19800, 3000),
(687, 3, 1, 12000, 3000),
(688, 3, 353, 19800, 3000),
(689, 3, 354, 19800, 3000),
(690, 3, 3, 12000, 3000),
(691, 3, 355, 19800, 3000),
(692, 3, 356, 12000, 3000),
(693, 3, 357, 19800, 3000),
(694, 3, 358, 19800, 3000),
(695, 3, 359, 19800, 3000),
(696, 3, 360, 19800, 3000),
(697, 3, 361, 19800, 3000),
(698, 3, 362, 19800, 3000),
(699, 3, 363, 19800, 3000),
(700, 3, 364, 19800, 3000),
(701, 3, 365, 12000, 3000),
(702, 3, 366, 19800, 3000),
(703, 3, 367, 19800, 3000),
(704, 3, 368, 19800, 3000),
(705, 3, 369, 19800, 3000),
(706, 3, 370, 19800, 3000),
(707, 3, 371, 19800, 3000),
(708, 3, 372, 19800, 3000),
(709, 3, 373, 19800, 3000),
(710, 3, 374, 19800, 3000),
(711, 3, 375, 12000, 3000),
(712, 3, 376, 19800, 3000),
(713, 3, 377, 19800, 3000),
(714, 3, 378, 19800, 3000),
(715, 3, 379, 19800, 3000),
(716, 3, 380, 19800, 3000),
(717, 3, 381, 19800, 3000),
(718, 3, 382, 19800, 3000),
(719, 3, 383, 19800, 3000),
(720, 3, 384, 12000, 3000),
(721, 3, 385, 19800, 3000),
(722, 3, 386, 19800, 3000),
(723, 3, 387, 19800, 3000),
(724, 3, 388, 19800, 3000),
(725, 3, 389, 19800, 3000),
(726, 3, 390, 19800, 3000),
(727, 3, 391, 19800, 3000),
(728, 3, 392, 19800, 3000),
(729, 3, 393, 12000, 3000),
(730, 3, 394, 19800, 3000),
(731, 3, 395, 19800, 3000),
(732, 3, 396, 19800, 3000),
(733, 3, 397, 19800, 3000),
(734, 3, 398, 19800, 3000),
(735, 3, 399, 19800, 3000),
(736, 3, 400, 19800, 3000),
(737, 3, 401, 12000, 3000),
(738, 3, 402, 19800, 3000),
(739, 3, 403, 19800, 3000),
(740, 3, 404, 19800, 3000),
(741, 3, 405, 19800, 3000),
(742, 3, 406, 19800, 3000),
(743, 3, 407, 12000, 3000),
(744, 3, 408, 19800, 3000),
(745, 3, 409, 19800, 3000),
(746, 3, 410, 19800, 3000),
(747, 3, 411, 12000, 3000),
(748, 3, 412, 19800, 3000),
(749, 3, 413, 19800, 3000),
(750, 3, 414, 19800, 3000),
(751, 3, 415, 19800, 3000),
(752, 3, 416, 19800, 3000),
(753, 3, 417, 12000, 3000),
(754, 3, 418, 19800, 3000),
(755, 3, 419, 19800, 3000),
(756, 3, 420, 19800, 3000),
(757, 3, 421, 19800, 3000),
(758, 3, 422, 19800, 3000),
(759, 3, 423, 19800, 3000),
(760, 3, 424, 19800, 3000),
(761, 3, 425, 19800, 3000),
(762, 3, 426, 19800, 3000),
(763, 3, 427, 19800, 3000),
(764, 3, 428, 12000, 3000),
(765, 3, 429, 19800, 3000),
(766, 3, 430, 19800, 3000),
(767, 3, 431, 19800, 3000),
(768, 3, 432, 19800, 3000),
(769, 3, 433, 12000, 3000),
(770, 3, 434, 19800, 3000),
(771, 3, 435, 19800, 3000),
(772, 3, 436, 19800, 3000),
(773, 3, 437, 19800, 3000),
(774, 3, 438, 19800, 3000),
(775, 3, 439, 19800, 3000),
(776, 3, 440, 19800, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `caridirektori`
--

CREATE TABLE IF NOT EXISTS `caridirektori` (
  `ID_CARIDIREKTORI` bigint(20) NOT NULL,
  `ID_ANGGOTA` int(11) DEFAULT NULL,
  `KATA_CARIDIREKTORI` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`ID_CARIDIREKTORI`),
  KEY `FK_ANGGOTA_CARIDIREKTORI` (`ID_ANGGOTA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cariproduk`
--

CREATE TABLE IF NOT EXISTS `cariproduk` (
  `ID_CARIPRODUK` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_ANGGOTA` int(11) DEFAULT NULL,
  `KATA_CARIPRODUK` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`ID_CARIPRODUK`),
  KEY `FK_PENCARIAN_ANGGOTA` (`ID_ANGGOTA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `direktori`
--

CREATE TABLE IF NOT EXISTS `direktori` (
  `ID_DIREKTORI` int(11) NOT NULL AUTO_INCREMENT,
  `ID_KATDIR` smallint(6) DEFAULT NULL,
  `ID_KOTA` smallint(6) DEFAULT NULL,
  `NAMA_DIREKTORI` varchar(80) DEFAULT NULL,
  `EMAIL_DIREKTORI` varchar(60) DEFAULT NULL,
  `FOTO_DIREKTORI` varchar(60) DEFAULT NULL,
  `ALAMAT_DIREKTORI` varchar(120) DEFAULT NULL,
  `TELEPON_DIREKTORI` varchar(60) DEFAULT NULL,
  `PEMILIK_DIREKTORI` varchar(60) DEFAULT NULL,
  `KOORDINAT_DIREKTORI` varchar(120) DEFAULT NULL,
  `INFO_DIREKTORI` text,
  `WEB_DIREKTORI` varchar(120) NOT NULL,
  `CHAT_DIREKTORI` varchar(80) DEFAULT NULL,
  `SOCMED_DIREKTORI` varchar(120) DEFAULT NULL,
  `STATUS_DIREKTORI` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_DIREKTORI`),
  KEY `FK_DIREKTORI_KATEGORI` (`ID_KATDIR`),
  KEY `FK_DIREKTORI_KOTA` (`ID_KOTA`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `direktori`
--

INSERT INTO `direktori` (`ID_DIREKTORI`, `ID_KATDIR`, `ID_KOTA`, `NAMA_DIREKTORI`, `EMAIL_DIREKTORI`, `FOTO_DIREKTORI`, `ALAMAT_DIREKTORI`, `TELEPON_DIREKTORI`, `PEMILIK_DIREKTORI`, `KOORDINAT_DIREKTORI`, `INFO_DIREKTORI`, `WEB_DIREKTORI`, `CHAT_DIREKTORI`, `SOCMED_DIREKTORI`, `STATUS_DIREKTORI`) VALUES
(1, 17, 2, 'Mahardika', '', '3aa361860011d0a01ac0a5db88d17959.jpg', '["Padelegan Pademawu",""]', '["+62-8785041177","+62-87750503755"]', '', '["",""]', 'Memproduksi baling-baling kapal dengan kapasitas produksi 54000 unit / tahun', '', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(2, 8, 2, 'Arrohmah', '', '53110031081f54cdb5fa5a9e682eeb24.jpg', '["Blumbungan Larangan",""]', '["+62-81939045336",""]', '', '["",""]', 'Kripik singkong beraneka rasa', '', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(3, 8, 2, 'Barokah Jaya', '', 'edd2a849b29034ab5830b2b95324d808.jpg', '["Larangan Tokol Tlanakan",""]', '["+62-87750588599",""]', '', '["",""]', 'Memproduksi kopi mengkudu 3600 kg / tahun', '', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(4, 8, 2, 'Global Mandiri', '', '8359ebf565dfcfabd6222feeb5dbc653.jpg', '["Branta Pesisir Tlanakan",""]', '["+62-81939295450",""]', '', '["",""]', 'Memproduksi kripik ikan capung 160 bungkus / minggu', '', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(5, 8, 2, 'Dinny Home Industri', '', '00c4350be87bb35f4124ac438426de9f.jpg', '["Branta Pesisir Tlanakan",""]', '["+62-817399577","+62-8525889011"]', '', '["",""]', 'Abon Ikan, Kripik Ikan dan Emping Jagung, Rambak Ikan 2600 bungkus / minggu', '', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(6, 7, 2, 'Hosniyah Batik', '', '40ebba474ed7cc39457db71374c5bfa1.jpg', '["Toket Proppo",""]', '["+62-87850971881",""]', '2', '["",""]', 'Memproduksi batik tulis dan cetak', '', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(7, 7, 2, 'Ahmad Batik', 'ahmadbatik@gmail.com', '32e51166858016987d7b5489af76f485.jpg', '["Toket Proppo",""]', '["+62-81939309400",""]', '2', '["",""]', 'Batik Tulis dengan produksi 25 lembar per minggu', 'ahmad.batik', '{"wa":"","bbm":"a3aa733","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(8, 7, 2, 'Group Podhek', '', '460fb8cdbdfa1fde1677c5537b8ad97d.jpg', '["Rang Perang Daya Proppo",""]', '["+62-87850443636",""]', '', '["",""]', 'Memproduksi Batik Tulis 75 Lembar / Minggu', '', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(9, 18, 2, 'Sumber Barokah (KUB)', '', '8db6b2df2473f6b61d29eae6d266b9bb.jpg', '["Rek-kerrek Palengaan",""]', '["+62-81935117147",""]', '', '["",""]', 'Memproduksi Anyaman Lidi 2000 unit / tahun', '', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(10, 18, 2, 'Rihana Handicraft', '', '0b32ed679b27eb4f6dfe779ba3e4ce46.jpg', '["Tobungan Galis",""]', '["+62-87750414332",""]', '', '["",""]', 'Memproduksi Tas Batik 450 unit / tahun', '', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(11, 7, 2, 'FaceBook Collection Batik', '', '944067457e5043b72f95f56e352de0fd.jpg', '["Toket Proppo",""]', '["+62-87850555599",""]', '2', '["",""]', 'Memproduksi Batik Tulis 720 unit / tahun', 'fbcollection', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1'),
(12, 7, 2, 'Tradisional Batik Pamekasan', 'tbatikpamek@gmail.com', '2e42f63d748f7b53314b62f11473b975.jpg', '["Rang Perang Daya Proppo",""]', '["+62-87850443636","+62-000003435"]', '', '["",""]', 'Memproduksi Batik Tulis 60 unit / tahun', '["http://batikmadura.blogspot.com"]', '{"wa":"","bbm":"","line":"","wechat":""}', '{"fb":"","twitter":"","gplus":"","ig":""}', '1');

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `ID_INFO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ADMIN` smallint(6) DEFAULT NULL,
  `JUDUL_INFO` varchar(120) DEFAULT NULL,
  `ISI_INFO` text,
  `FOTO_INFO` varchar(60) DEFAULT NULL,
  `TANGGAL_INFO` datetime DEFAULT NULL,
  `STATUS_INFO` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_INFO`),
  KEY `FK_INFO_ADMIN` (`ID_ADMIN`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`ID_INFO`, `ID_ADMIN`, `JUDUL_INFO`, `ISI_INFO`, `FOTO_INFO`, `TANGGAL_INFO`, `STATUS_INFO`) VALUES
(1, 1, 'Tentang Madura', '<div>Madura adalah nama pulau yang terletak di sebelah timur laut Jawa Timur. Pulau Madura besarnya kurang lebih 5.250 km2 (lebih kecil daripada pulau Bali), dengan penduduk sekitar 4 juta jiwa.</div><div><br></div><div>Madura dibagi menjadi empat kabupaten, yaitu:</div><div><br></div><div>1. Bangkalan</div><div>2. Sampang</div><div>3. Pamekasan</div><div>4. Sumenep</div><div><br></div><div>Pulau ini termasuk provinsi Jawa Timur dan memiliki nomor kendaraan bermotor sendiri, yaitu â€œMâ€.</div><div><br></div><div>Sejarah</div><div>Secara politis, Madura selama berabad-abad telah menjadi subordinat daerah kekuasaan yang berpusat di Jawa. Sekitar tahun 900-1500, pulau ini berada di bawah pengaruh kekuasaan kerajaan Hindu Jawa timur seperti Kediri, Singhasari, dan Majapahit. Di antara tahun 1500 dan 1624, para penguasa Madura pada batas tertentu bergantung pada kerajaan-kerajaan Islam di pantai utara Jawa seperti Demak, Gresik, dan Surabaya. Pada tahun 1624, Madura ditaklukkan oleh Mataram. Sesudah itu, pada paruh pertama abad kedelapan belas Madura berada di bawah kekuasaan kolonial Belanda (mulai 1882), mula-mula oleh VOC, kemudian oleh pemerintah Hindia-Belanda. Pada saat pembagian provinsi pada tahun 1920-an, Madura menjadi bagian dari provinsi Jawa Timur.</div><div><br></div><div>Ekonomi</div><div>Secara keseluruhan, Madura termasuk salah satu daerah miskin di provinsi Jawa Timur. Tidak seperti Pulau Jawa, tanah di Madura kurang cukup subur untuk dijadikan tempat pertanian. Kesempatan ekonomi lain yang terbatas telah mengakibatkan pengangguran dan kemiskinan. Faktor-faktor ini telah mengakibatkan emigrasi jangka panjang dari Madura sehingga saat ini banyak masyarakat suku Madura tidak tinggal di Madura. Penduduk Madura termasuk peserta program transmigrasi terbanyak.</div><div><br></div><div>Pertanian subsisten (skala kecil untuk bertahan hidup) merupakan kegiatan ekonomi utama. Jagung dan singkong merupakan tanaman budi daya utama dalam pertanian subsisten di Madura, tersebar di banyak lahan kecil. Ternak sapi juga merupakan bagian penting ekonomi pertanian di pulau ini dan memberikan pemasukan tambahan bagi keluarga petani selain penting untuk kegiatan karapan sapi. Perikanan skala kecil juga penting dalam ekonomi subsisten di sana.</div><div><br></div><div>Tanaman budi daya yang paling komersial di Madura ialah tembakau. Tanah di pulau ini membantu menjadikan Madura sebagai produsen penting tembakau dan cengkeh bagi industri kretek domestik. Sejak zaman kolonial Belanda, Madura juga telah menjadi penghasil dan pengekspor utama garam.</div><div><br></div><div>Bangkalan yang terletak di ujung barat Madura telah mengalami industrialisasi sejak tahun 1980-an. Daerah ini mudah dijangkau dari Surabaya, kota terbesar kedua di Indonesia, dan dengan demikian berperan menjadi daerah suburban bagi para penglaju ke Surabaya, dan sebagai lokasi industri dan layanan yang diperlukan dekat dengan Surabaya. Jembatan Suramadu yang lama direncanakan dan kini sedang dalam tahap pembangunan diharapkan meningkatkan interaksi daerah Bangkalan dengan ekonomi regional.</div>', 'a6a8e4dcb8b9eadb70acf9c095cff414.jpg', '2015-04-13 09:55:37', '1'),
(2, 1, 'SIUP ( SURAT IJIN USAHA PERDAGANGAN )', '<p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">SIUP ( SURAT IJIN USAHA PERDAGANGAN )</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">PERSYARATAN :</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">A. PERORANGAN</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">1. Surat Keterangan Kades</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">2. Foto Copy KTP</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">3. Pas photo uk. 4 x 6</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">4. Foto Copy Bukti Tempat Usaha</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">5. Materai @ Rp. 6000,-</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">6. Stop Map</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">7. Foto Copy HO ( apabila mengganggu lingkungan )</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">B. BADAN HUKUM</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">1 s/d 6 sama dengan atas</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">7. foto copy Akte Notaris</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">8. Neraca Awal</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">9. Struktur Organisasi</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">10. Susunan Kepemilikan Modal</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">SARANA DAN PRASARANA :</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">1. Formulir SPI</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">2. Blanko SIUP</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">3. Loket</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">4. Ruang Tunggu</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">5. Peralatan Kantor ( komputer , dll )</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">WAKTU PENYELESAIAN :</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">5 ( lima ) hari kerja</span></p><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;">BIAYA PELAYANAN :</span></p><table class="table table-bordered"><tbody><tr><td>SIUP Besar</td><td>Rp. 400.000,-</td></tr><tr><td>SIUP Menengah</td><td>Rp. 200.000,-</td></tr><tr><td>SIUP Kecil</td><td>Rp. 100.000,-</td></tr></tbody></table><p style="text-align: justify; "><span style="color: rgb(0, 0, 0); font-family: ''Lucida Grande'', ''Lucida Sans Unicode'', Arial, sans-serif; font-size: 11.6639995574951px; line-height: normal;"><br></span></p>', 'fb0f84c943ec6d1a41dd3065358f163e.jpg', '2015-04-13 09:58:00', '1'),
(3, 1, 'Peluang Investasi', '<p style="text-align: justify; ">Mengapa Harus Berinvestasi Di Pamekasan?</p><p style="text-align: justify;">Kabupaten yang terletak di tengah-tengah Pulau Madura ini mempunyai potensi yang sangat besar untuk berkembang menjadi kawasan industri sebagai penyokong sentra bisnis dan perdagangan di Wilayah Jawa Timur.</p><p style="text-align: justify; ">Penyelesaian Jembatan Suramadu pada tahun 2009 mempermudah jalur trsansportasi darat sehingga otomatis dapat mempercepat laju perekonomian masyarakat Madura pada umumnya, dan masyarakat Pamekasan pada khususnya. Hal ini didukung dengan potensi alam yang bisa dikembangkan secara luas dan profesional, juga ditunjang oleh tenaga kerja yang memedai tingkat pendidikannya dan etos kerja serta budaya kerja yang dikenal keuletannya.</p><p style="text-align: justify;">Untuk menjemput investasi, Pamekasan telah bertekad memberikan kemudahan dalam perijinan, oleh karena itu semua permohonan pelayanan perijinan telah dilayani lewat satu pintu yaitu UPT ( Unit Pelayanan Terpadu ). Dengan demikian, pelayanan sangat transparan, baik ragam perijinanyang dilayani maupun biaya serta rentang waktu penyelesaian perijinan.</p><p style="text-align: justify;">Untu itu Jangan Ragu Untuk Berinvestasi Di Pamekasan.</p>', 'de0ef13246402798e256ae716384e1ed.jpg', '2015-04-13 10:03:49', '1');

-- --------------------------------------------------------

--
-- Table structure for table `katdir`
--

CREATE TABLE IF NOT EXISTS `katdir` (
  `ID_KATDIR` smallint(6) NOT NULL AUTO_INCREMENT,
  `NAMA_KATDIR` varchar(60) DEFAULT NULL,
  `STATUS_KATDIR` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_KATDIR`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `katdir`
--

INSERT INTO `katdir` (`ID_KATDIR`, `NAMA_KATDIR`, `STATUS_KATDIR`) VALUES
(1, 'Uncategorized', '1'),
(2, 'Periklanan, Promosi & Penerbitan', '1'),
(3, 'Pertanian, Kehutanan & Perikanan', '1'),
(4, 'Otomotif', '1'),
(5, 'Kimia', '1'),
(6, 'Kelistrikan & Elektronik', '1'),
(7, 'Pakaian', '1'),
(8, 'Makanan & Minuman', '1'),
(9, 'Pemerintah', '1'),
(10, 'Rumah & Kantor', '1'),
(11, 'Hotel & Penginapan', '1'),
(12, 'Teknologi Informasi', '1'),
(13, 'Pertambangan', '1'),
(14, 'Pelayanan', '1'),
(15, 'Belanja', '1'),
(16, 'Transportasi & Komunikasi', '1'),
(17, 'Industri', '1'),
(18, 'Kesenian & Hadiah', '1'),
(19, 'Pendidikan', '1'),
(20, 'Keuangan', '1'),
(21, 'Kesehatan & Perawatan', '1'),
(22, 'Properti & Bahan Bangunan', '1'),
(23, 'Olahraga, Rekreasi & Hiburan', '1'),
(24, 'Cerutu, Rokok & Tembakau', '1');

-- --------------------------------------------------------

--
-- Table structure for table `katproduk`
--

CREATE TABLE IF NOT EXISTS `katproduk` (
  `ID_KATPRODUK` smallint(6) NOT NULL AUTO_INCREMENT,
  `NAMA_KATPRODUK` varchar(60) DEFAULT NULL,
  `STATUS_KATPRODUK` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_KATPRODUK`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `katproduk`
--

INSERT INTO `katproduk` (`ID_KATPRODUK`, `NAMA_KATPRODUK`, `STATUS_KATPRODUK`) VALUES
(1, 'Alat Musik', '1'),
(2, 'Alat Olahraga', '1'),
(3, 'Antik', '1'),
(4, 'Bisnis', '1'),
(5, 'Buku', '1'),
(6, 'CD & DVD', '1'),
(7, 'Elektronik', '1'),
(8, 'Fashion & Mode', '1'),
(9, 'Flora & Fauna', '1'),
(10, 'Furniture', '1'),
(11, 'Gratisan', '1'),
(12, 'Handphone Dan Tablet', '1'),
(13, 'Industri & Supplier', '1'),
(14, 'Jasa', '1'),
(15, 'Karya Seni & Desain', '1'),
(16, 'Kamera & Aksesoris', '1'),
(17, 'Kerajinan Tangan', '1'),
(18, 'Koleksi, Hobi & Mainan', '1'),
(19, 'Makanan & Minuman', '1'),
(20, 'Obat-Obatan', '1'),
(21, 'Online Gaming', '1'),
(22, 'Otomotif', '1'),
(23, 'Perawatan Tubuh & Wajah', '1'),
(24, 'Perkakas', '1'),
(25, 'Perlengkapan Anak & Bayi', '1'),
(26, 'Perlengkapan Kantor', '1'),
(27, 'Perlengkapan Rumah Tangga', '1'),
(28, 'Properti', '1'),
(29, 'Komputer', '1'),
(30, 'Serba Serbi', '1'),
(31, 'Tiket', '1'),
(32, 'Video Games', '1');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE IF NOT EXISTS `komentar` (
  `ID_KOMENTAR` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_POSTANGGOTA` bigint(20) DEFAULT NULL,
  `ID_ANGGOTA` int(11) DEFAULT NULL,
  `ISI_KOMENTAR` text,
  `TANGGAL_KOMENTAR` datetime DEFAULT NULL,
  `STATUS_KOMENTAR` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_KOMENTAR`),
  KEY `FK_KOMENTAR_ANGGOTA` (`ID_ANGGOTA`),
  KEY `FK_KOMENTAR_POSTANGGOTA` (`ID_POSTANGGOTA`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`ID_KOMENTAR`, `ID_POSTANGGOTA`, `ID_ANGGOTA`, `ISI_KOMENTAR`, `TANGGAL_KOMENTAR`, `STATUS_KOMENTAR`) VALUES
(1, 4, 2, 'asdgasdf dafdasfsdf', '2015-06-02 17:07:43', '0'),
(2, 4, 2, 'posting macam apa ini?', '2015-06-02 18:12:30', '1');

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE IF NOT EXISTS `kota` (
  `ID_KOTA` smallint(6) NOT NULL AUTO_INCREMENT,
  `KODE_KOTA` varchar(12) DEFAULT NULL,
  `NAMA_KOTA` varchar(80) DEFAULT NULL,
  `STATUS_KOTA` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_KOTA`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=441 ;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`ID_KOTA`, `KODE_KOTA`, `NAMA_KOTA`, `STATUS_KOTA`) VALUES
(1, 'DIR', 'Bangkalan', '1'),
(2, 'DIR', 'Pamekasan', '1'),
(3, 'DIR', 'Sampang', '1'),
(4, 'DIR', 'Sumenep', '1'),
(5, 'NOT', 'Cilegon', '1'),
(6, 'NOT', 'Cilegon - Cigading', '1'),
(7, 'NOT', 'Cilegon - Labuhan', '1'),
(8, 'NOT', 'Cilegon - Merak', '1'),
(9, 'NOT', 'Cilegon - Suralaya', '1'),
(10, 'NOT', 'Serang', '1'),
(11, 'NOT', 'Serang - Pandeglang', '1'),
(12, 'NOT', 'Serang - Rangkas Bitung', '1'),
(13, 'NOT', 'Jakarta', '1'),
(14, 'NOT', 'Jakarta - Bintaro', '1'),
(15, 'NOT', 'Jakarta - Ciledug', '1'),
(16, 'NOT', 'Jakarta - Cimanggis', '1'),
(17, 'NOT', 'Jakarta - Cinere', '1'),
(18, 'NOT', 'Jakarta - Ciputat', '1'),
(19, 'NOT', 'Jakarta - Ciracas', '1'),
(20, 'NOT', 'Jakarta - Depok', '1'),
(21, 'NOT', 'Jakarta - Gandul', '1'),
(22, 'NOT', 'Jakarta - Jatiwaringin', '1'),
(23, 'NOT', 'Jakarta - Jurangmangu', '1'),
(24, 'NOT', 'Jakarta - Kelapa Dua', '1'),
(25, 'NOT', 'Jakarta - Kramat Jati', '1'),
(26, 'NOT', 'Jakarta - Pondok Gede', '1'),
(27, 'NOT', 'Jakarta - Pondok Kelapa', '1'),
(28, 'NOT', 'Jakarta - Pulo Gadung', '1'),
(29, 'NOT', 'Jakarta Kota', '1'),
(30, 'NOT', 'Karawang', '1'),
(31, 'NOT', 'Karawang - Cikampek', '1'),
(32, 'NOT', 'Karawang - Cimalaya', '1'),
(33, 'NOT', 'Karawang - Curug', '1'),
(34, 'NOT', 'Karawang - Dawuan', '1'),
(35, 'NOT', 'Karawang - Pamanukan', '1'),
(36, 'NOT', 'Karawang - Rengas Dengklok', '1'),
(37, 'NOT', 'Karawang - Sukamandi', '1'),
(38, 'NOT', 'Bekasi', '1'),
(39, 'NOT', 'Bekasi - Cibarusah', '1'),
(40, 'NOT', 'Bekasi - Cibitung', '1'),
(41, 'NOT', 'Bekasi - Cikarang', '1'),
(42, 'NOT', 'Bekasi - Jaka Sampurna', '1'),
(43, 'NOT', 'Bekasi - Narogong', '1'),
(44, 'NOT', 'Tangerang', '1'),
(45, 'NOT', 'Tangerang - Balaraja', '1'),
(46, 'NOT', 'Tangerang - Bintaro Regency', '1'),
(47, 'NOT', 'Tangerang - Cikupa', '1'),
(48, 'NOT', 'Tangerang - Ciledug', '1'),
(49, 'NOT', 'Tangerang - Curug', '1'),
(50, 'NOT', 'Tangerang - Kresek', '1'),
(51, 'NOT', 'Tangerang - Kronjo', '1'),
(52, 'NOT', 'Tangerang - Legok', '1'),
(53, 'NOT', 'Tangerang - Mauk', '1'),
(54, 'NOT', 'Tangerang - Pamulang II/III', '1'),
(55, 'NOT', 'Tangerang - Serpong', '1'),
(56, 'NOT', 'Bogor', '1'),
(57, 'NOT', 'Bogor - Ciawi', '1'),
(58, 'NOT', 'Bogor - Cibinong', '1'),
(59, 'NOT', 'Bogor - Cileungsi', '1'),
(60, 'NOT', 'Bogor - Cipayung', '1'),
(61, 'NOT', 'Bogor - Citeurep', '1'),
(62, 'NOT', 'Bogor - Jisanga', '1'),
(63, 'NOT', 'Bogor - Leuwi Liang', '1'),
(64, 'NOT', 'Bogor - Parung', '1'),
(65, 'NOT', 'Bogor - Reni Jaya', '1'),
(66, 'NOT', 'Bandung', '1'),
(67, 'NOT', 'Bandung - Banjaran', '1'),
(68, 'NOT', 'Bandung - Batu Jajap', '1'),
(69, 'NOT', 'Bandung - Cimahi', '1'),
(70, 'NOT', 'Bandung - Ciwidey', '1'),
(71, 'NOT', 'Bandung - Lembang', '1'),
(72, 'NOT', 'Bandung - Majalaya', '1'),
(73, 'NOT', 'Bandung - Maribaya', '1'),
(74, 'NOT', 'Bandung - Padalarang', '1'),
(75, 'NOT', 'Bandung - Rancaekek', '1'),
(76, 'NOT', 'Bandung - Soreang', '1'),
(77, 'NOT', 'Sumedang', '1'),
(78, 'NOT', 'Sumedang - Buahdua', '1'),
(79, 'NOT', 'Sumedang - Cikeruh', '1'),
(80, 'NOT', 'Sumedang - Darmaraja', '1'),
(81, 'NOT', 'Sumedang - Jatinangor', '1'),
(82, 'NOT', 'Sumedang - Ranca Kalong', '1'),
(83, 'NOT', 'Sumedang - Rancaekek KM...', '1'),
(84, 'NOT', 'Sumedang - Situraja', '1'),
(85, 'NOT', 'Sumedang - Tanjung Sari', '1'),
(86, 'NOT', 'Sumedang - Tomo', '1'),
(87, 'NOT', 'Purwakarta', '1'),
(88, 'NOT', 'Purwakarta - Cikopo', '1'),
(89, 'NOT', 'Purwakarta - Cilangkap', '1'),
(90, 'NOT', 'Purwakarta - Cipenduy', '1'),
(91, 'NOT', 'Purwakarta - Jatiluhur', '1'),
(92, 'NOT', 'Purwakarta - Kawasan BIC', '1'),
(93, 'NOT', 'Purwakarta - Pabuaran', '1'),
(94, 'NOT', 'Purwakarta - Pasawahan', '1'),
(95, 'NOT', 'Purwakarta - Plered', '1'),
(96, 'NOT', 'Purwakarta - Sawit', '1'),
(97, 'NOT', 'Purwakarta - Ubrug', '1'),
(98, 'NOT', 'Tasikmalaya', '1'),
(99, 'NOT', 'Tasikmalaya - Banjaran', '1'),
(100, 'NOT', 'Tasikmalaya - Ciamis', '1'),
(101, 'NOT', 'Tasikmalaya - Ciawi', '1'),
(102, 'NOT', 'Tasikmalaya - Manonjaya', '1'),
(103, 'NOT', 'Tasikmalaya - Singaparna', '1'),
(104, 'NOT', 'Garut', '1'),
(105, 'NOT', 'Garut - Bayongbong ', '1'),
(106, 'NOT', 'Garut - Cibatu', '1'),
(107, 'NOT', 'Sukabumi', '1'),
(108, 'NOT', 'Sukabumi - Cibadak', '1'),
(109, 'NOT', 'Sukabumi - Cicurug', '1'),
(110, 'NOT', 'Sukabumi - Nyalindung', '1'),
(111, 'NOT', 'Sukabumi - Parung Kuda', '1'),
(112, 'NOT', 'Sukabumi - Pelabuhan Ratu', '1'),
(113, 'NOT', 'Cianjur', '1'),
(114, 'NOT', 'Cianjur - Cibeber', '1'),
(115, 'NOT', 'Cianjur - Cilaku', '1'),
(116, 'NOT', 'Cianjur - Cipanas', '1'),
(117, 'NOT', 'Cianjur - Ciranjang', '1'),
(118, 'NOT', 'Cianjur - Karangtengah', '1'),
(119, 'NOT', 'Cianjur - Mande', '1'),
(120, 'NOT', 'Cianjur - Warung Kondang', '1'),
(121, 'NOT', 'Cirebon', '1'),
(122, 'NOT', 'Cirebon - Anjarwinagun', '1'),
(123, 'NOT', 'Cirebon - Ciledug', '1'),
(124, 'NOT', 'Cirebon - Kapetakan', '1'),
(125, 'NOT', 'Cirebon - Karang Sembung', '1'),
(126, 'NOT', 'Cirebon - Maja', '1'),
(127, 'NOT', 'Cirebon - Majalengka', '1'),
(128, 'NOT', 'Cirebon - Palimanan', '1'),
(129, 'NOT', 'Cirebon - Sindang Laut', '1'),
(130, 'NOT', 'Cirebon - Sumber', '1'),
(131, 'NOT', 'Kuningan', '1'),
(132, 'NOT', 'Kuningan - Ancaran', '1'),
(133, 'NOT', 'Kuningan - Ciawigebang', '1'),
(134, 'NOT', 'Kuningan - Cidahu', '1'),
(135, 'NOT', 'Kuningan - Cikijing', '1'),
(136, 'NOT', 'Kuningan - Cilimus', '1'),
(137, 'NOT', 'Kuningan - Garawangi', '1'),
(138, 'NOT', 'Kuningan - Kadugede', '1'),
(139, 'NOT', 'Kuningan - Lebakwangi', '1'),
(140, 'NOT', 'Kuningan - Luragung', '1'),
(141, 'NOT', 'Kuningan - Maniskidul', '1'),
(142, 'NOT', 'Indramayu', '1'),
(143, 'NOT', 'Indramayu - Bangodua', '1'),
(144, 'NOT', 'Indramayu - Cikedung', '1'),
(145, 'NOT', 'Indramayu - Eretan', '1'),
(146, 'NOT', 'Indramayu - Haurgeulis', '1'),
(147, 'NOT', 'Indramayu - Jatibarang', '1'),
(148, 'NOT', 'Indramayu - Karangampel', '1'),
(149, 'NOT', 'Indramayu - Kertasemaya', '1'),
(150, 'NOT', 'Tegal', '1'),
(151, 'NOT', 'Tegal - Balapulang', '1'),
(152, 'NOT', 'Tegal - Banjaratma', '1'),
(153, 'NOT', 'Tegal - Bantar Bolang', '1'),
(154, 'NOT', 'Tegal - Brebes', '1'),
(155, 'NOT', 'Tegal - Bulakamba', '1'),
(156, 'NOT', 'Tegal - Jatibarang', '1'),
(157, 'NOT', 'Tegal - Ketanggungan', '1'),
(158, 'NOT', 'Tegal - Lebaksiu', '1'),
(159, 'NOT', 'Tegal - Margasari', '1'),
(160, 'NOT', 'Tegal - Moga', '1'),
(161, 'NOT', 'Tegal - Pemalang', '1'),
(162, 'NOT', 'Tegal - Prupuk', '1'),
(163, 'NOT', 'Tegal - Randu Dongkal', '1'),
(164, 'NOT', 'Tegal - Slawi', '1'),
(165, 'NOT', 'Tegal - Sumberharjo', '1'),
(166, 'NOT', 'Tegal - Taman', '1'),
(167, 'NOT', 'Tegal - Tanjung', '1'),
(168, 'NOT', 'Tegal - Watukumpul', '1'),
(169, 'NOT', 'Pekalongan', '1'),
(170, 'NOT', 'Pekalongan - Bandar', '1'),
(171, 'NOT', 'Pekalongan - Batang', '1'),
(172, 'NOT', 'Pekalongan - Blado', '1'),
(173, 'NOT', 'Pekalongan - Bojong', '1'),
(174, 'NOT', 'Pekalongan - Comal', '1'),
(175, 'NOT', 'Pekalongan - Gringsing', '1'),
(176, 'NOT', 'Pekalongan - Kajen', '1'),
(177, 'NOT', 'Pekalongan - Kesesi', '1'),
(178, 'NOT', 'Pekalongan - Lebakbarang', '1'),
(179, 'NOT', 'Pekalongan - Limpung', '1'),
(180, 'NOT', 'Pekalongan - Pekajangan', '1'),
(181, 'NOT', 'Pekalongan - Petarukan', '1'),
(182, 'NOT', 'Pekalongan - Purwoharjo', '1'),
(183, 'NOT', 'Pekalongan - Sambong', '1'),
(184, 'NOT', 'Pekalongan - Samborejo', '1'),
(185, 'NOT', 'Pekalongan - Sragi', '1'),
(186, 'NOT', 'Pekalongan - Subah', '1'),
(187, 'NOT', 'Pekalongan - Wiradesa', '1'),
(188, 'NOT', 'Pekalongan - Wonopringgo', '1'),
(189, 'NOT', 'Purwokerto', '1'),
(190, 'NOT', 'Purwokerto - Ajibarang', '1'),
(191, 'NOT', 'Purwokerto - Banjarnegara', '1'),
(192, 'NOT', 'Purwokerto - Banyumas', '1'),
(193, 'NOT', 'Purwokerto - Bobot Sari', '1'),
(194, 'NOT', 'Purwokerto - Bukateja', '1'),
(195, 'NOT', 'Purwokerto - Bumiayu', '1'),
(196, 'NOT', 'Purwokerto - Majenang', '1'),
(197, 'NOT', 'Purwokerto - Purbalingga', '1'),
(198, 'NOT', 'Gombong', '1'),
(199, 'NOT', 'Gombong - Kebumen', '1'),
(200, 'NOT', 'Cilacap', '1'),
(201, 'NOT', 'Cilacap - Adipala', '1'),
(202, 'NOT', 'Cilacap - Kawung Nganten', '1'),
(203, 'NOT', 'Cilacap - Kroya', '1'),
(204, 'NOT', 'Cilacap - Maos', '1'),
(205, 'NOT', 'Cilacap - Sampang', '1'),
(206, 'NOT', 'Cilacap - Sidareja', '1'),
(207, 'NOT', 'Semarang', '1'),
(208, 'NOT', 'Semarang - Bawen', '1'),
(209, 'NOT', 'Semarang - Boja', '1'),
(210, 'NOT', 'Semarang - Demak', '1'),
(211, 'NOT', 'Semarang - Grobogan', '1'),
(212, 'NOT', 'Semarang - Karangjati', '1'),
(213, 'NOT', 'Semarang - Kendal', '1'),
(214, 'NOT', 'Semarang - Purwodadi', '1'),
(215, 'NOT', 'Semarang - Sukorejo', '1'),
(216, 'NOT', 'Semarang - Ungaran', '1'),
(217, 'NOT', 'Cepu', '1'),
(218, 'NOT', 'Cepu - Blora', '1'),
(219, 'NOT', 'Cepu - Jepon', '1'),
(220, 'NOT', 'Cepu - Padangan', '1'),
(221, 'NOT', 'Kudus', '1'),
(222, 'NOT', 'Kudus - Bangsri', '1'),
(223, 'NOT', 'Kudus - Gebog', '1'),
(224, 'NOT', 'Kudus - Jepara', '1'),
(225, 'NOT', 'Kudus - Juwana', '1'),
(226, 'NOT', 'Kudus - Lasem', '1'),
(227, 'NOT', 'Kudus - Mayong', '1'),
(228, 'NOT', 'Kudus - Pati', '1'),
(229, 'NOT', 'Kudus - Pecangaan', '1'),
(230, 'NOT', 'Kudus - Rembang', '1'),
(231, 'NOT', 'Kudus - Runting', '1'),
(232, 'NOT', 'Kudus - Tayu', '1'),
(233, 'NOT', 'Yogyakarta', '1'),
(234, 'NOT', 'Yogyakarta - Bantul', '1'),
(235, 'NOT', 'Yogyakarta - Godean', '1'),
(236, 'NOT', 'Yogyakarta - Imogiri', '1'),
(237, 'NOT', 'Yogyakarta - Kalasan', '1'),
(238, 'NOT', 'Yogyakarta - Pakem', '1'),
(239, 'NOT', 'Yogyakarta - Prambanan', '1'),
(240, 'NOT', 'Yogyakarta - Sleman', '1'),
(241, 'NOT', 'Yogyakarta - Wates', '1'),
(242, 'NOT', 'Yogyakarta - Wonosari', '1'),
(243, 'NOT', 'Magelang', '1'),
(244, 'NOT', 'Magelang - Kutoarjo', '1'),
(245, 'NOT', 'Magelang - Muntilan', '1'),
(246, 'NOT', 'Magelang - Purworejo', '1'),
(247, 'NOT', 'Magelang - Secang', '1'),
(248, 'NOT', 'Temanggung', '1'),
(249, 'NOT', 'Klaten', '1'),
(250, 'NOT', 'Klaten - Bayat', '1'),
(251, 'NOT', 'Klaten - Gawas', '1'),
(252, 'NOT', 'Klaten - Ceper', '1'),
(253, 'NOT', 'Klaten - Jatinom', '1'),
(254, 'NOT', 'Klaten - Pedan', '1'),
(255, 'NOT', 'Solo', '1'),
(256, 'NOT', 'Solo - Bekonang', '1'),
(257, 'NOT', 'Solo - Jaten', '1'),
(258, 'NOT', 'Solo - Kacangan', '1'),
(259, 'NOT', 'Solo - Karang Anyar', '1'),
(260, 'NOT', 'Solo - Karang Pandan', '1'),
(261, 'NOT', 'Solo - Metesih', '1'),
(262, 'NOT', 'Solo - Pacitan', '1'),
(263, 'NOT', 'Solo - Tasik Madu PG', '1'),
(264, 'NOT', 'Solo - Tawangmangu', '1'),
(265, 'NOT', 'Solo - Tegalgondo', '1'),
(266, 'NOT', 'Sragen', '1'),
(267, 'NOT', 'Wonogiri', '1'),
(268, 'NOT', 'Salatiga', '1'),
(269, 'NOT', 'Salatiga - Ambarawa', '1'),
(270, 'NOT', 'Salatiga - Ampel', '1'),
(271, 'NOT', 'Salatiga - Bandungan', '1'),
(272, 'NOT', 'Salatiga - Banyubiru', '1'),
(273, 'NOT', 'Salatiga - Bedono', '1'),
(274, 'NOT', 'Salatiga - Boyolali', '1'),
(275, 'NOT', 'Salatiga - Bringin', '1'),
(276, 'NOT', 'Salatiga - Cepogo', '1'),
(277, 'NOT', 'Salatiga - Getas', '1'),
(278, 'NOT', 'Salatiga - Jambu', '1'),
(279, 'NOT', 'Salatiga - Karanggede', '1'),
(280, 'NOT', 'Salatiga - Kopeng', '1'),
(281, 'NOT', 'Salatiga - Nepen', '1'),
(282, 'NOT', 'Salatiga - Simo', '1'),
(283, 'NOT', 'Salatiga - Sumowono', '1'),
(284, 'NOT', 'Salatiga - Suruh', '1'),
(285, 'NOT', 'Salatiga - Teras', '1'),
(286, 'NOT', 'Salatiga - Tuntang', '1'),
(287, 'NOT', 'Madiun', '1'),
(288, 'NOT', 'Madiun - Caruban', '1'),
(289, 'NOT', 'Madiun - Magetan', '1'),
(290, 'NOT', 'Madiun - Ngawi', '1'),
(291, 'NOT', 'Madiun - Ponorogo', '1'),
(292, 'NOT', 'Madiun - Purwodadi', '1'),
(293, 'NOT', 'Madiun - Rejosari', '1'),
(294, 'NOT', 'Madiun - Saradan', '1'),
(295, 'NOT', 'Madiun - Sudono', '1'),
(296, 'NOT', 'Nganjuk', '1'),
(297, 'NOT', 'Nganjuk - Kertosono', '1'),
(298, 'NOT', 'Nganjuk - Lestari', '1'),
(299, 'NOT', 'Kediri', '1'),
(300, 'NOT', 'Kediri - Gringgih', '1'),
(301, 'NOT', 'Kediri - Minggiran', '1'),
(302, 'NOT', 'Kediri - Ngadirejo', '1'),
(303, 'NOT', 'Kediri - Pare', '1'),
(304, 'NOT', 'Kediri - Purwosari', '1'),
(305, 'NOT', 'Tulungagung', '1'),
(306, 'NOT', 'Tulungagung - Ngunut', '1'),
(307, 'NOT', 'Tulungagung - Trenggalek', '1'),
(308, 'NOT', 'Surabaya', '1'),
(309, 'NOT', 'Surabaya - Benowo', '1'),
(310, 'NOT', 'Surabaya - Citra Land', '1'),
(311, 'NOT', 'Surabaya - Domas', '1'),
(312, 'NOT', 'Surabaya - Driyorejo', '1'),
(313, 'NOT', 'Surabaya - Krian', '1'),
(314, 'NOT', 'Surabaya - Lakarsantri', '1'),
(315, 'NOT', 'Surabaya - Menganti', '1'),
(316, 'NOT', 'Sidoarjo', '1'),
(317, 'NOT', 'Sidoarjo - Porong', '1'),
(318, 'NOT', 'Sidoarjo - Sukodono', '1'),
(319, 'NOT', 'Sidoarjo - Toelangan', '1'),
(320, 'NOT', 'Sidoarjo - Wonoayu', '1'),
(321, 'NOT', 'Gresik', '1'),
(322, 'NOT', 'Gresik - Duduk Sampeyan', '1'),
(323, 'NOT', 'Gresik - Sedayu', '1'),
(324, 'NOT', 'Lamongan', '1'),
(325, 'NOT', 'Mojokerto', '1'),
(326, 'NOT', 'Mojokerto - Balongbendo', '1'),
(327, 'NOT', 'Mojokerto - Mojosari', '1'),
(328, 'NOT', 'Mojokerto - Ngoro', '1'),
(329, 'NOT', 'Mojokerto - Pacet', '1'),
(330, 'NOT', 'Mojokerto - Trowulan', '1'),
(331, 'NOT', 'Mojokerto - Wringinanom', '1'),
(332, 'NOT', 'Jombang', '1'),
(333, 'NOT', 'Jombang - Cukir', '1'),
(334, 'NOT', 'Jombang - Mojoagung', '1'),
(335, 'NOT', 'Jombang - Peterongan', '1'),
(336, 'NOT', 'Jombang - Ploso', '1'),
(337, 'NOT', 'Bojonegoro', '1'),
(338, 'NOT', 'Bojonegoro - Babat', '1'),
(339, 'NOT', 'Bojonegoro - Baoreno', '1'),
(340, 'NOT', 'Bojonegoro - Kalitidu', '1'),
(341, 'NOT', 'Bojonegoro - Purwosari', '1'),
(342, 'NOT', 'Bojonegoro - Sumberejo', '1'),
(343, 'NOT', 'Tuban', '1'),
(344, 'NOT', 'Tuban - Jenu', '1'),
(345, 'NOT', 'Tuban - Kerek', '1'),
(346, 'NOT', 'Tuban - Palang', '1'),
(347, 'NOT', 'Tuban - Tambakboyo', '1'),
(348, 'NOT', 'Tuban - Widang', '1'),
(349, 'NOT', 'Pamekasan - Tlanakan', '1'),
(350, 'NOT', 'Sumenep - Bluto', '1'),
(351, 'NOT', 'Sumenep - Kalianget', '1'),
(352, 'NOT', 'Sumenep - Marengan', '1'),
(353, 'NOT', 'Bangkalan - Burneh', '1'),
(354, 'NOT', 'Bangkalan - Kamal', '1'),
(355, 'NOT', 'Sampang - Camplong', '1'),
(356, 'NOT', 'Malang', '1'),
(357, 'NOT', 'Malang - Batu', '1'),
(358, 'NOT', 'Malang - Bululawang', '1'),
(359, 'NOT', 'Malang - Gondanglegi', '1'),
(360, 'NOT', 'Malang - Kebon Agung', '1'),
(361, 'NOT', 'Malang - Kepanjen', '1'),
(362, 'NOT', 'Malang - Lawang', '1'),
(363, 'NOT', 'Malang - Pakis Aji', '1'),
(364, 'NOT', 'Malang - Singosari', '1'),
(365, 'NOT', 'Pandaan', '1'),
(366, 'NOT', 'Pandaan - Beji', '1'),
(367, 'NOT', 'Pandaan - Carat', '1'),
(368, 'NOT', 'Pandaan - Gempol', '1'),
(369, 'NOT', 'Pandaan - Japanan', '1'),
(370, 'NOT', 'Pandaan - Ledok', '1'),
(371, 'NOT', 'Pandaan - Prigen', '1'),
(372, 'NOT', 'Pandaan - Sukorejo', '1'),
(373, 'NOT', 'Pandaan - Tretes', '1'),
(374, 'NOT', 'Pandaan - Watukosek', '1'),
(375, 'NOT', 'Pasuruan', '1'),
(376, 'NOT', 'Pasuruan - Bangil', '1'),
(377, 'NOT', 'Pasuruan - Grati', '1'),
(378, 'NOT', 'Pasuruan - Kedawung', '1'),
(379, 'NOT', 'Pasuruan - Kejayan', '1'),
(380, 'NOT', 'Pasuruan - Lekok', '1'),
(381, 'NOT', 'Pasuruan - Pasrepan', '1'),
(382, 'NOT', 'Pasuruan - Winongan', '1'),
(383, 'NOT', 'Pasuruan - Wonorejo', '1'),
(384, 'NOT', 'Blitar', '1'),
(385, 'NOT', 'Blitar - Garum', '1'),
(386, 'NOT', 'Blitar - Kademangan', '1'),
(387, 'NOT', 'Blitar - Kanigoro', '1'),
(388, 'NOT', 'Blitar - Kesamben', '1'),
(389, 'NOT', 'Blitar - Lodoyo', '1'),
(390, 'NOT', 'Blitar - Srengat', '1'),
(391, 'NOT', 'Blitar - Talun', '1'),
(392, 'NOT', 'Blitar - Wlingi', '1'),
(393, 'NOT', 'Jember', '1'),
(394, 'NOT', 'Jember - Ambulu', '1'),
(395, 'NOT', 'Jember - Jelbuk', '1'),
(396, 'NOT', 'Jember - Kalisat', '1'),
(397, 'NOT', 'Jember - Pakusari', '1'),
(398, 'NOT', 'Jember - Rambipuji', '1'),
(399, 'NOT', 'Jember - Rowotamtu', '1'),
(400, 'NOT', 'Jember - Tanggul', '1'),
(401, 'NOT', 'Situbondo', '1'),
(402, 'NOT', 'Situbondo - Asembagus', '1'),
(403, 'NOT', 'Situbondo - Besuki', '1'),
(404, 'NOT', 'Situbondo - Kalibagor', '1'),
(405, 'NOT', 'Situbondo - Olean', '1'),
(406, 'NOT', 'Situbondo - Panarukan', '1'),
(407, 'NOT', 'Bondowoso', '1'),
(408, 'NOT', 'Bondowoso - Prajekan', '1'),
(409, 'NOT', 'Bondowoso - Sumberpandan', '1'),
(410, 'NOT', 'Bondowoso - Wonosari', '1'),
(411, 'NOT', 'Probolinggo', '1'),
(412, 'NOT', 'Probolinggo - Gending', '1'),
(413, 'NOT', 'Probolinggo - Kraksaan', '1'),
(414, 'NOT', 'Probolinggo - Leces', '1'),
(415, 'NOT', 'Probolinggo - Paiton', '1'),
(416, 'NOT', 'Probolinggo - Pajarakan', '1'),
(417, 'NOT', 'Banyuwangi', '1'),
(418, 'NOT', 'Banyuwangi - Benculuk', '1'),
(419, 'NOT', 'Banyuwangi - Jajag', '1'),
(420, 'NOT', 'Banyuwangi - Kabat', '1'),
(421, 'NOT', 'Banyuwangi - Ketapang', '1'),
(422, 'NOT', 'Banyuwangi - Meneng', '1'),
(423, 'NOT', 'Banyuwangi - Muncar', '1'),
(424, 'NOT', 'Banyuwangi - Purwoharjo', '1'),
(425, 'NOT', 'Banyuwangi - Rogojampi', '1'),
(426, 'NOT', 'Banyuwangi - Srono', '1'),
(427, 'NOT', 'Banyuwangi - Tegal Dlimo', '1'),
(428, 'NOT', 'Genteng', '1'),
(429, 'NOT', 'Genteng - Kalibaru', '1'),
(430, 'NOT', 'Genteng - Kalisetail', '1'),
(431, 'NOT', 'Genteng - Krikilan', '1'),
(432, 'NOT', 'Genteng - Temuguruh', '1'),
(433, 'NOT', 'Lumajang', '1'),
(434, 'NOT', 'Lumajang - Jatiroto', '1'),
(435, 'NOT', 'Lumajang - Klakah', '1'),
(436, 'NOT', 'Lumajang - Pasirian', '1'),
(437, 'NOT', 'Lumajang - Senduro', '1'),
(438, 'NOT', 'Lumajang - Tempeh', '1'),
(439, 'NOT', 'Lumajang - Wonorejo', '1'),
(440, 'NOT', 'Lumajang - Yosowilangun', '1');

-- --------------------------------------------------------

--
-- Table structure for table `kurir`
--

CREATE TABLE IF NOT EXISTS `kurir` (
  `ID_KURIR` tinyint(4) NOT NULL AUTO_INCREMENT,
  `NAMA_KURIR` varchar(80) DEFAULT NULL,
  `STATUS_KURIR` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_KURIR`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `kurir`
--

INSERT INTO `kurir` (`ID_KURIR`, `NAMA_KURIR`, `STATUS_KURIR`) VALUES
(1, 'PT. JNE', '1'),
(2, 'PT. Pos Indonesia', '1'),
(3, 'Kerta Gaya Pusaka', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pencarian`
--

CREATE TABLE IF NOT EXISTS `pencarian` (
  `ID_PENCARIAN` int(11) NOT NULL,
  `KATA_PENCARIAN` varchar(40) DEFAULT NULL,
  `HITUNG_PENCARIAN` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_PENCARIAN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE IF NOT EXISTS `penjualan` (
  `ID_PENJUALAN` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ANGGOTA` int(11) DEFAULT NULL,
  `NAMA_PENJUALAN` varchar(60) DEFAULT NULL,
  `ALAMAT_PENJUALAN` varchar(120) DEFAULT NULL,
  `TELEPON_PENJUALAN` varchar(20) DEFAULT NULL,
  `ONGKIR_PENJUALAN` float DEFAULT NULL,
  `TANGGAL_PENJUALAN` datetime DEFAULT NULL,
  `AKHIR_PENJUALAN` datetime DEFAULT NULL,
  `KIRIM_PENJUALAN` datetime DEFAULT NULL,
  `INFO_PENJUALAN` text,
  `STATUS_PENJUALAN` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_PENJUALAN`),
  KEY `FK_PENJUALAN_ANGGOTA` (`ID_ANGGOTA`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`ID_PENJUALAN`, `ID_ANGGOTA`, `NAMA_PENJUALAN`, `ALAMAT_PENJUALAN`, `TELEPON_PENJUALAN`, `ONGKIR_PENJUALAN`, `TANGGAL_PENJUALAN`, `AKHIR_PENJUALAN`, `KIRIM_PENJUALAN`, `INFO_PENJUALAN`, `STATUS_PENJUALAN`) VALUES
(1, 2, 'Dian Fadilawati', 'Jl. Bengawan Solo No. 3 Pamekasan', '+62-9854543432', 6000, '2015-04-23 13:07:19', '2015-04-30 13:07:19', '0000-00-00 00:00:00', '', '2'),
(2, 4, 'Tyieka Imoetz', 'Jl. Stadion No. 15 Pamekasan', '+62-8939832993', 6000, '2015-04-27 13:17:10', '2015-05-04 13:17:10', '0000-00-00 00:00:00', '', '0'),
(3, 4, 'Tyieka Imoetz', 'Jl. Stadion No. 15 Pamekasan', '+62-8939832993', 6000, '2015-04-27 13:17:10', '2015-05-04 13:17:10', '0000-00-00 00:00:00', '', '0'),
(4, 4, 'Tyieka Imoetz', 'Jl. Stadion No. 15 Pamekasan', '+62-8939832993', 7000, '2015-04-27 13:22:22', '2015-05-04 13:22:22', '0000-00-00 00:00:00', '', '0'),
(5, 4, 'Tyieka Imoetz', 'Jl. Stadion No. 15 Pamekasan', '+62-8939832993', 6000, '2015-04-27 13:23:31', '2015-05-04 13:23:31', '0000-00-00 00:00:00', '', '0'),
(6, 4, 'Tyieka Imoetz', 'Jl. Stadion No. 15 Pamekasan', '+62-8939832993', 4000, '2015-04-27 13:24:51', '2015-05-04 13:24:51', '0000-00-00 00:00:00', '', '0'),
(7, 4, 'Tyieka Imoetz', 'Jl. Stadion No. 15 Pamekasan', '+62-8939832993', 4000, '2015-04-27 13:24:51', '2015-05-04 13:24:51', '0000-00-00 00:00:00', '', '0'),
(8, 4, 'Tyieka Imoetz', 'Jl. Stadion No. 15 Pamekasan', '+62-8939832993', 6000, '2015-04-28 20:35:18', '2015-05-05 20:35:18', '0000-00-00 00:00:00', '', '0'),
(9, 2, 'Hosniyah', 'Jl. Dirgahayu No. 3 Pamekasan', '+62-9854543432', 0, '2015-06-04 12:56:26', '2015-06-11 12:56:26', '0000-00-00 00:00:00', '', '0'),
(10, 2, 'Hosniyah', 'Jl. Dirgahayu No. 3 Pamekasan', '+62-9854543432', 0, '2015-06-04 14:33:06', '2015-06-11 14:33:06', '0000-00-00 00:00:00', '', '0'),
(11, 2, 'Hosniyah', 'Jl. Dirgahayu No. 3 Pamekasan', '+62-9854543432', 0, '2015-06-04 14:38:24', '2015-06-11 14:38:24', '0000-00-00 00:00:00', 'KONFIRMASI PEMBAYARAN\r\n<br>REKENING: BCA KC Pamekasan / 033.5342.40000 / Zulkifli Lubis\r\n<br>BAYAR: Rp. 500000,-\r\n<br>PESAN: ', '7');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE IF NOT EXISTS `pesan` (
  `ID_PESAN` bigint(20) NOT NULL AUTO_INCREMENT,
  `PENGIRIM_PESAN` int(11) DEFAULT NULL,
  `PENERIMA_PESAN` int(11) DEFAULT NULL,
  `TANGGAL_PESAN` datetime DEFAULT NULL,
  `ISI_PESAN` text,
  `STATUS_PESAN` char(1) DEFAULT NULL,
  `JENIS_PESAN` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_PESAN`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pesan`
--

INSERT INTO `pesan` (`ID_PESAN`, `PENGIRIM_PESAN`, `PENERIMA_PESAN`, `TANGGAL_PESAN`, `ISI_PESAN`, `STATUS_PESAN`, `JENIS_PESAN`) VALUES
(1, 4, 2, '2015-04-27 13:53:43', 'bisa gak saya beli produk ini', '2', '4'),
(2, 2, 4, '2015-06-03 10:43:31', 'dsagdgd fasfd fasdf fasdgdafdsadfds', '1', '4'),
(3, 2, 4, '2015-06-04 09:43:58', 'keren ini, aq suka banget...', '1', '4'),
(4, 2, 4, '2015-06-15 21:33:04', 'dfsdf dsfad ds', '1', '4');

-- --------------------------------------------------------

--
-- Table structure for table `postanggota`
--

CREATE TABLE IF NOT EXISTS `postanggota` (
  `ID_POSTANGGOTA` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_ANGGOTA` int(11) DEFAULT NULL,
  `ID_KATPRODUK` smallint(6) DEFAULT NULL,
  `JUDUL_POSTANGGOTA` varchar(120) DEFAULT NULL,
  `ISI_POSTANGGOTA` text,
  `TANGGAL_POSTANGGOTA` datetime DEFAULT NULL,
  `TIPE_POSTANGGOTA` char(1) DEFAULT NULL,
  `STATUS_POSTANGGOTA` char(1) DEFAULT NULL,
  `FOTO_POSTANGGOTA` text,
  PRIMARY KEY (`ID_POSTANGGOTA`),
  KEY `FK_POSTING_ANGGOTA` (`ID_ANGGOTA`),
  KEY `FK_KATEGORI_POST` (`ID_KATPRODUK`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `postanggota`
--

INSERT INTO `postanggota` (`ID_POSTANGGOTA`, `ID_ANGGOTA`, `ID_KATPRODUK`, `JUDUL_POSTANGGOTA`, `ISI_POSTANGGOTA`, `TANGGAL_POSTANGGOTA`, `TIPE_POSTANGGOTA`, `STATUS_POSTANGGOTA`, `FOTO_POSTANGGOTA`) VALUES
(1, 2, 8, 'Jersey bola grade ori & player issue club & negara', 'ready jersey bola grade ori dan player issue club & negara pria,wanita,anak couple dan kaos bola.\nharga mulai 115.000\nselengkapnya kunjungi website resmi kami http://www.emdestore.com\nfanspage FB http://www.facebook.com/emdes\nuntuk pertanyaan dan pemesanan :\n085649438119\n081286413101\npin BB 324424D9 - 312ADAE9\nwilayah surabaya gratis ongkir', '2015-04-13 10:28:53', '1', '1', 'a:3:{i:0;s:36:"2f263bf840ac2abc71f2d43a8e1d0597.jpg";i:1;s:36:"135af8bba5aff07d7e4ae1a2239a15fe.jpg";i:2;s:36:"ea85c783af038bc7f1e0c3e2e9f9fd76.jpg";}'),
(2, 2, 29, 'Jual HDD External USB 3.0 WD My Passport Ultra 1TB', 'Jenis barang : Media penyimpanan komputers\nTipe : Hardisk / HDD, eksternal\nUkuran : 1 TB / 1000 GB.\nBerat : 1,5 kg setelah pengemasan pengiriman.\nKondisi baru, bukan bekas.\nLokasi toko : Sumenep - Madura.\nMelayani COD di toko saya, silahkan hubungi nomor kontak saya.\nBerhubung saya masih dalam proses kuliah, tidak akan selalu online.\nMohon jika berminat, hubungi / sms saya dulu di 082 337 886 882.', '2015-04-13 10:47:38', '1', '1', 'a:1:{i:0;s:36:"240e167d4f9408b70b3baeaebd1d162f.jpg";}'),
(3, 2, 29, 'JUAL CEPAT! Laptop Acer Aspire', 'JUAL CEPAT! Laptop Acer Aspire E1 -471, Core i3 2,2 Ghz, RAM 2GB, HDD 500GB, LED 14", kondisi 98%,... Rp. 3.400.000,-\r\nCOD langsung aja, posisi Pangarangan.\r\nCP: 082 337 886 882', '2015-04-13 10:59:51', '1', '1', 'a:1:{i:0;s:36:"e1496596283597e836399d5fddfd18c7.jpg";}'),
(4, 3, 12, 'Jual HP Nokia 6020', 'Sebagai perdana, Admin ingin tawarkan salah satu barang teman ane,.. Sebuah Nokia 6020 with VGA Camera and Radio, spek bisa dilihat di mbah google.\r\nNegatif :\r\n1. Entah Dosbooknya kemana, hilang mungkin Gan katanya, jadi cuma HP+Charger.\r\n2. KeyPadnya 60% buram.\r\nHarga Pas Rp. 100.000\r\nYang gak minat gak usah koment.', '2015-04-13 11:26:11', '1', '1', 'a:1:{i:0;s:36:"4d6c0bc8fb0dd84a1d0fc9cdd19dee3f.jpg";}'),
(5, 3, 22, 'Mencari motor honda Beat Injeksi', 'Assalamualaikum wr. wb.\r\n\r\nSalam Sejahtera dek seluruh taretan dhibi'' se bedheh eMadureh maupun diluar MAdureh.... Anak baru neh, mw cari barang. barangkali ada yang minat \r\n\r\nHONDA BEAT\r\nBukan Barang Curian, Murni Barang Gadai yg tidak ditebus sama orangnya,,,\r\nsudah setahun lebih ini motor ane pakai,,,\r\nJual Adanya,,,', '2015-04-13 11:32:30', '2', '1', 'a:1:{i:0;s:36:"1696a37ba14ece70fba0575c1cc51d2f.jpg";}'),
(6, 4, 8, 'T-shirt fotographer dan adventure Series', 'bahan catton combed 30s, jahit rantai rapi, sablon rubber mix sw/vasde\r\nharga @65 ribu,(belum termasuk ongkir buat luar kota semarang)\r\nReady juga Jumper dan jaket kerennya ya...@125 ribu (cek album foto)\r\nreseller welcome\r\npin bb: 7d2ab5b9\r\nHp: 085640692221', '2015-04-17 09:37:18', '1', '1', 'a:2:{i:0;s:36:"3e2836fcf1133ca13092fa36b9e2eebe.jpg";i:1;s:36:"12c1d639e070530d44535de083ac6065.jpg";}'),
(7, 4, 19, 'Kopi unik, kopi biji salak (koplak)', 'Kopi unik, kopi biji salak (koplak) \r\nKhas Jember.\r\nHp : 08990578274, 085237482717\r\nPin bb : 75357810', '2015-04-17 09:39:54', '1', '1', 'a:2:{i:0;s:36:"f68a906115295099c26fba0e03f5dcad.jpg";i:1;s:36:"d495b50fe67ded822de07be0d40acb1e.jpg";}'),
(8, 4, 8, 'Sarung BHS berkualitas tinggi', 'siang....\r\ndapatkan koleksi terbaru sarung BHS berkualitas tinggi ...\r\ndengan bahan sutra yang nyaman dipakai....\r\nhanya di toko syafia plaza jln sultan agung 21 jember \r\nmore info \r\n26AFC391 FENI\r\n27DB01A7 DEWI', '2015-04-17 09:41:29', '1', '1', 'a:1:{i:0;s:36:"6175be020a313a597fe91dbf76094f24.jpg";}'),
(9, 4, 8, 'Atasan Blus Denim', 'Malem all.....\r\nAtasan Blus Denim\r\nDengan bahan yg nyaman dipakai cocok dikenakan saat bersantai di rumah atau unt jalan-jalan\r\nMinat?\r\nBisa datang langsung ke Syafia Plaza\r\nJl.Raya Sultan Agung no.21 Jember\r\nMore info add pin\r\nFeni :26AFC391\r\nDewi : 27DB01A7', '2015-04-17 09:48:31', '2', '1', 'a:1:{i:0;s:36:"d11bb141df9bf5855ab4368466fdd31d.jpg";}'),
(10, 2, 3, 'Barang Antik Tidak Dijual', 'Barang antik yang sangat oke. alert(1)', '2015-06-03 13:20:02', '1', '0', 'a:1:{i:0;s:36:"9603b628be7c7c4f5e6fe8d2cc0a8fee.jpg";}'),
(11, 2, 7, 'Alat Elektronik Terlengkap', 'Ini adalah alat-alat elektronik terlengkap dan termurah', '2015-06-08 19:21:40', '1', '1', 'a:3:{i:0;s:36:"dc571696c23efe33330b7fda52e95510.jpg";i:1;s:36:"e8a293d8f0af6686a07c0a955c1beaba.jpg";i:2;s:36:"6fbbbb74e760bdd793e1c4ebd45c7eaf.jpg";}'),
(12, 2, 14, 'Web Design', 'Menerima pembuatan jasa web design yang unik dan menarik', '2015-06-16 18:18:11', '1', '1', 'a:3:{i:0;s:36:"3b2be3b170eb2e4f460622a22501977a.jpg";i:1;s:36:"196ac9ed630e2e103b4ae2b86b293435.jpg";i:2;s:36:"5b60e06ce61d7b97a79a33b4d67e48ec.jpg";}');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE IF NOT EXISTS `produk` (
  `ID_PRODUK` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_DIREKTORI` int(11) DEFAULT NULL,
  `ID_KATPRODUK` smallint(6) DEFAULT NULL,
  `NAMA_PRODUK` varchar(80) DEFAULT NULL,
  `HARGA_PRODUK` decimal(10,0) DEFAULT NULL,
  `INFO_PRODUK` text,
  `FOTO_PRODUK` text,
  `STATUS_PRODUK` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_PRODUK`),
  KEY `FK_KATEGORI_PRODUK` (`ID_KATPRODUK`),
  KEY `FK_PRODUK_DIREKTORI` (`ID_DIREKTORI`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`ID_PRODUK`, `ID_DIREKTORI`, `ID_KATPRODUK`, `NAMA_PRODUK`, `HARGA_PRODUK`, `INFO_PRODUK`, `FOTO_PRODUK`, `STATUS_PRODUK`) VALUES
(1, 7, 8, 'Batik Songket Khas Madura', 500000, 'Batik unik khas Madura', 'a:3:{i:0;s:36:"6abc1cc3ae45b3efd592fe4855a1e2b8.jpg";i:1;s:36:"fdb20257b3bc98385ef6dcff3bfeef07.jpg";i:2;s:36:"8253672ad5c7de709d508efc6b7c0e1c.jpg";}', '1'),
(2, 7, 8, 'Batik Ekor Baru', 450000, 'Batik unik dengan motif ekor baru', 'a:1:{i:0;s:36:"c4075f6ca3e9360452efce8cc200a319.jpg";}', '1'),
(3, 11, 8, 'Tas Batik', 45000, 'Tas yang terbuat dari batik', 'a:1:{i:0;s:36:"271562722d88f6bd7a482faf60823c4f.jpg";}', '1');

-- --------------------------------------------------------

--
-- Table structure for table `produkutama`
--

CREATE TABLE IF NOT EXISTS `produkutama` (
  `ID_PRODUKUTAMA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_KATPRODUK` smallint(6) DEFAULT NULL,
  `NAMA_PRODUKUTAMA` varchar(80) DEFAULT NULL,
  `HARGA_PRODUKUTAMA` decimal(10,0) DEFAULT NULL,
  `STOK_PRODUKUTAMA` int(11) DEFAULT NULL,
  `INFO_PRODUKUTAMA` text,
  `BERAT_PRODUKUTAMA` float DEFAULT NULL,
  `FOTO_PRODUKUTAMA` text,
  `STATUS_PRODUKUTAMA` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_PRODUKUTAMA`),
  KEY `FK_KATEGORI_FEATUREDP` (`ID_KATPRODUK`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `produkutama`
--

INSERT INTO `produkutama` (`ID_PRODUKUTAMA`, `ID_KATPRODUK`, `NAMA_PRODUKUTAMA`, `HARGA_PRODUKUTAMA`, `STOK_PRODUKUTAMA`, `INFO_PRODUKUTAMA`, `BERAT_PRODUKUTAMA`, `FOTO_PRODUKUTAMA`, `STATUS_PRODUKUTAMA`) VALUES
(1, 8, 'Kain Batik', 450000, 2, 'Batik asli Madura dengan motif beragam dan elegan. Setiap motif dibuat dengan tangan tanpa bantuan mesin cetak', 0.2, 'a:5:{i:0;s:36:"1062839278403a36ad7f7c1361d9d6ee.jpg";i:1;s:36:"7c086d78fcffae9676380824e0e98cbf.jpg";i:2;s:36:"bdaedeb171631e6909c7db5da619e1c9.jpg";i:3;s:36:"682cc0333bd85a66156eb9f5e83d6a1d.jpg";i:4;s:36:"e75555405496d5e32dd776ec7da264c4.jpg";}', '1'),
(2, 19, 'Kripik Ketela', 2000, 1, 'Kripik renyah dari ketela pilihan', 0.1, 'a:2:{i:0;s:36:"383bfd0f7081f9556ffa8087fade21a9.jpg";i:1;s:36:"68f6a13a349c53bad46c622f75f08713.jpg";}', '1'),
(3, 12, 'Nokia Jadul', 100000, 1, 'Nokia jadul mau dijual', 0.01, 'a:1:{i:0;s:36:"2e81622a50bd7c6bf43b83ea5bd79178.jpg";}', '0'),
(4, 8, 'Tas Batik', 50000, 10, 'Tas asesoris yang terbuat dari batik, bagus dan unik', 0.8, 'a:2:{i:0;s:36:"1eca5f866e18426d3b0d4f1f9ec2ad04.jpg";i:1;s:36:"646d5e326c759dc709d3eb77fd2b3511.jpg";}', '1'),
(5, 17, 'Anyaman Bambu', 100000, 6, 'Anyaman dari bambu yang murah dan meriah, bagus dan unik', 6, 'a:2:{i:0;s:36:"ab4c2918b524d29512696ba06162cf10.jpg";i:1;s:36:"65e697b35ee76b38933f03f59ccd7214.jpg";}', '1');

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE IF NOT EXISTS `rekening` (
  `ID_REKENING` smallint(6) NOT NULL AUTO_INCREMENT,
  `BANK_REKENING` varchar(60) DEFAULT NULL,
  `NOMOR_REKENING` varchar(60) DEFAULT NULL,
  `AN_REKENING` varchar(40) DEFAULT NULL,
  `STATUS_REKENING` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_REKENING`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`ID_REKENING`, `BANK_REKENING`, `NOMOR_REKENING`, `AN_REKENING`, `STATUS_REKENING`) VALUES
(1, 'Bank Mandiri KC Pamekasan', '909.8456.123.7777', 'Zulkifli Lubis', '1'),
(2, 'BCA KC Pamekasan', '033.5342.40000', 'Zulkifli Lubis', '1');

-- --------------------------------------------------------

--
-- Table structure for table `rekeningb`
--

CREATE TABLE IF NOT EXISTS `rekeningb` (
  `ID_REKENINGB` bigint(20) NOT NULL,
  `ID_REKENING` smallint(6) DEFAULT NULL,
  `TANGGAL_REKENINGB` datetime DEFAULT NULL,
  `INFO_REKENINGB` text,
  `PENGIRIM_REKENINGB` varchar(30) DEFAULT NULL,
  `PENERIMA_REKENINGB` varchar(30) DEFAULT NULL,
  `STATUS_REKENINGB` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_REKENINGB`),
  KEY `FK_REKENING_REKENINGB` (`ID_REKENING`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reviewproduk`
--

CREATE TABLE IF NOT EXISTS `reviewproduk` (
  `ID_REVIEWPRODUK` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PRODUK` bigint(20) DEFAULT NULL,
  `ID_ANGGOTA` int(11) DEFAULT NULL,
  `ISI_REVIEWPRODUK` text,
  `SKOR_REVIEWPRODUK` tinyint(1) DEFAULT NULL,
  `TANGGAL_REVIEWPRODUK` datetime DEFAULT NULL,
  `STATUS_REVIEWPRODUK` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_REVIEWPRODUK`),
  KEY `FK_REVIEWPRODUK_ANGGOTA` (`ID_ANGGOTA`),
  KEY `FK_REVIEWPRODUK_PRODUK` (`ID_PRODUK`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `reviewproduk`
--

INSERT INTO `reviewproduk` (`ID_REVIEWPRODUK`, `ID_PRODUK`, `ID_ANGGOTA`, `ISI_REVIEWPRODUK`, `SKOR_REVIEWPRODUK`, `TANGGAL_REVIEWPRODUK`, `STATUS_REVIEWPRODUK`) VALUES
(4, 1, 4, 'aq suka produk ini, terima kasih', 4, '2015-04-28 22:32:32', '2'),
(5, 1, 3, 'Oke, bagus', 3, '2015-05-24 12:19:00', '1'),
(6, 1, 2, 'aku suka banget, seneng juga anak2 dengan produk ini :)', 4, '2015-05-30 14:53:48', '0');

-- --------------------------------------------------------

--
-- Table structure for table `rincipenjualan`
--

CREATE TABLE IF NOT EXISTS `rincipenjualan` (
  `ID_RINCIPENJUALAN` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PENJUALAN` int(11) DEFAULT NULL,
  `ID_PRODUKUTAMA` int(11) DEFAULT NULL,
  `JUMLAH_RINCIPENJUALAN` smallint(6) DEFAULT NULL,
  `BIAYA_RINCIPENJUALAN` float DEFAULT NULL,
  PRIMARY KEY (`ID_RINCIPENJUALAN`),
  KEY `FK_RINCIANPENJUALAN_PRODUKUTAMA` (`ID_PRODUKUTAMA`),
  KEY `FK_RINCIAN_PENJUALAN` (`ID_PENJUALAN`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `rincipenjualan`
--

INSERT INTO `rincipenjualan` (`ID_RINCIPENJUALAN`, `ID_PENJUALAN`, `ID_PRODUKUTAMA`, `JUMLAH_RINCIPENJUALAN`, `BIAYA_RINCIPENJUALAN`) VALUES
(1, 1, 1, 1, 450000),
(2, 1, 2, 1, 2000),
(20, 11, 1, 1, 450000),
(21, 11, 4, 1, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE IF NOT EXISTS `testimoni` (
  `ID_TESTIMONI` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ANGGOTA` int(11) DEFAULT NULL,
  `PENGIRIM_TESTIMONI` int(11) DEFAULT NULL,
  `ISI_TESTIMONI` text,
  `TANGGAL_TESTIMONI` datetime DEFAULT NULL,
  `STATUS_TESTIMONI` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_TESTIMONI`),
  KEY `FK_ANGGOTA_TESTIMONI` (`ID_ANGGOTA`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `testimoni`
--

INSERT INTO `testimoni` (`ID_TESTIMONI`, `ID_ANGGOTA`, `PENGIRIM_TESTIMONI`, `ISI_TESTIMONI`, `TANGGAL_TESTIMONI`, `STATUS_TESTIMONI`) VALUES
(1, 4, 2, 'Penjual yang baik dan jujur....', '2015-06-03 09:50:43', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tipstrik`
--

CREATE TABLE IF NOT EXISTS `tipstrik` (
  `ID_TIPSTRIK` int(11) NOT NULL AUTO_INCREMENT,
  `ISI_TIPSTRIK` text,
  `FOTO_TIPSTRIK` varchar(120) DEFAULT NULL,
  `JENIS_TIPSTRIK` char(1) DEFAULT '1',
  `STATUS_TIPSTRIK` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_TIPSTRIK`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tipstrik`
--

INSERT INTO `tipstrik` (`ID_TIPSTRIK`, `ISI_TIPSTRIK`, `FOTO_TIPSTRIK`, `JENIS_TIPSTRIK`, `STATUS_TIPSTRIK`) VALUES
(3, 'Pulau Madura besarnya kurang lebih 5.250 km2 (lebih kecil daripada pulau Bali), dengan penduduk sekitar 4 juta jiwa.', NULL, '1', '1'),
(4, 'Bungkuslah produk yang Anda jual dengan menarik sehingga memberikan kesan yang baik bagi pelanggan Anda', '', '2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `ID_TOKEN` bigint(20) NOT NULL AUTO_INCREMENT,
  `EMAIL_TOKEN` varchar(40) DEFAULT NULL,
  `DATA_TOKEN` text,
  `EXPIRED_TOKEN` datetime DEFAULT NULL,
  `INGAT_TOKEN` char(1) DEFAULT NULL,
  `SOURCE_TOKEN` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ID_TOKEN`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`ID_TOKEN`, `EMAIL_TOKEN`, `DATA_TOKEN`, `EXPIRED_TOKEN`, `INGAT_TOKEN`, `SOURCE_TOKEN`) VALUES
(5, 'ceylon.rizan@gmail.com', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjMiLCJlbWFpbCI6ImNleWxvbi5yaXphbkBnbWFpbC5jb20iLCJ0b2tlbmlkIjo1LCJ1c2VyIjoibWVtYmVyIiwibGV2ZWwiOiIxIiwic291cmNlIjoid2ViIn0.pmIunTiZoGmy-Z6EkCG5SUW3R0ZQZURO5-4JB9MK9KE', '2015-04-18 20:44:54', '1', 'web'),
(74, 'admin@madura.bz', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEiLCJlbWFpbCI6ImFkbWluQG1hZHVyYS5ieiIsInRva2VuaWQiOjc0LCJ1c2VyIjoiYWRtaW4iLCJsZXZlbCI6IjEiLCJzb3VyY2UiOiJ3ZWIifQ.2X2D0y_aro9NZTUM4a-i3RABDODBfvFWTLlzTCEauTg', '2015-06-16 21:07:40', '1', 'web'),
(77, 'dyiela_sweet@yahoo.co.id', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjIiLCJlbWFpbCI6ImR5aWVsYV9zd2VldEB5YWhvby5jby5pZCIsInRva2VuaWQiOjc3LCJ1c2VyIjoibWVtYmVyIiwibGV2ZWwiOiIyIiwic291cmNlIjoid2ViIn0.cjAOKwgNsrLEpskD_18dfF9mjUQsvL83043LyDER2_A', '2015-06-23 13:03:41', '1', 'web');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aduanpost`
--
ALTER TABLE `aduanpost`
  ADD CONSTRAINT `FK_ANGGOTA_ADUANPOST` FOREIGN KEY (`ID_ANGGOTA`) REFERENCES `anggota` (`ID_ANGGOTA`),
  ADD CONSTRAINT `FK_POST_ADUANPOST` FOREIGN KEY (`ID_POSTANGGOTA`) REFERENCES `postanggota` (`ID_POSTANGGOTA`);

--
-- Constraints for table `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `FK_BERITA_ADMIN` FOREIGN KEY (`ID_ADMIN`) REFERENCES `admin` (`ID_ADMIN`);

--
-- Constraints for table `biayakurir`
--
ALTER TABLE `biayakurir`
  ADD CONSTRAINT `FK_KURIR_BIAYA` FOREIGN KEY (`ID_KURIR`) REFERENCES `kurir` (`ID_KURIR`),
  ADD CONSTRAINT `FK_KURIR_KOTA` FOREIGN KEY (`ID_KOTA`) REFERENCES `kota` (`ID_KOTA`);

--
-- Constraints for table `caridirektori`
--
ALTER TABLE `caridirektori`
  ADD CONSTRAINT `FK_ANGGOTA_CARIDIREKTORI` FOREIGN KEY (`ID_ANGGOTA`) REFERENCES `anggota` (`ID_ANGGOTA`);

--
-- Constraints for table `cariproduk`
--
ALTER TABLE `cariproduk`
  ADD CONSTRAINT `FK_PENCARIAN_ANGGOTA` FOREIGN KEY (`ID_ANGGOTA`) REFERENCES `anggota` (`ID_ANGGOTA`);

--
-- Constraints for table `direktori`
--
ALTER TABLE `direktori`
  ADD CONSTRAINT `FK_DIREKTORI_KATEGORI` FOREIGN KEY (`ID_KATDIR`) REFERENCES `katdir` (`ID_KATDIR`),
  ADD CONSTRAINT `FK_DIREKTORI_KOTA` FOREIGN KEY (`ID_KOTA`) REFERENCES `kota` (`ID_KOTA`);

--
-- Constraints for table `info`
--
ALTER TABLE `info`
  ADD CONSTRAINT `FK_INFO_ADMIN` FOREIGN KEY (`ID_ADMIN`) REFERENCES `admin` (`ID_ADMIN`);

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `FK_KOMENTAR_ANGGOTA` FOREIGN KEY (`ID_ANGGOTA`) REFERENCES `anggota` (`ID_ANGGOTA`),
  ADD CONSTRAINT `FK_KOMENTAR_POSTANGGOTA` FOREIGN KEY (`ID_POSTANGGOTA`) REFERENCES `postanggota` (`ID_POSTANGGOTA`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `FK_PENJUALAN_ANGGOTA` FOREIGN KEY (`ID_ANGGOTA`) REFERENCES `anggota` (`ID_ANGGOTA`);

--
-- Constraints for table `postanggota`
--
ALTER TABLE `postanggota`
  ADD CONSTRAINT `FK_KATEGORI_POST` FOREIGN KEY (`ID_KATPRODUK`) REFERENCES `katproduk` (`ID_KATPRODUK`),
  ADD CONSTRAINT `FK_POSTING_ANGGOTA` FOREIGN KEY (`ID_ANGGOTA`) REFERENCES `anggota` (`ID_ANGGOTA`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `FK_KATEGORI_PRODUK` FOREIGN KEY (`ID_KATPRODUK`) REFERENCES `katproduk` (`ID_KATPRODUK`),
  ADD CONSTRAINT `FK_PRODUK_DIREKTORI` FOREIGN KEY (`ID_DIREKTORI`) REFERENCES `direktori` (`ID_DIREKTORI`);

--
-- Constraints for table `produkutama`
--
ALTER TABLE `produkutama`
  ADD CONSTRAINT `FK_KATEGORI_FEATUREDP` FOREIGN KEY (`ID_KATPRODUK`) REFERENCES `katproduk` (`ID_KATPRODUK`);

--
-- Constraints for table `rekeningb`
--
ALTER TABLE `rekeningb`
  ADD CONSTRAINT `FK_REKENING_REKENINGB` FOREIGN KEY (`ID_REKENING`) REFERENCES `rekening` (`ID_REKENING`);

--
-- Constraints for table `reviewproduk`
--
ALTER TABLE `reviewproduk`
  ADD CONSTRAINT `FK_REVIEWPRODUK_ANGGOTA` FOREIGN KEY (`ID_ANGGOTA`) REFERENCES `anggota` (`ID_ANGGOTA`),
  ADD CONSTRAINT `FK_REVIEWPRODUK_PRODUK` FOREIGN KEY (`ID_PRODUK`) REFERENCES `produk` (`ID_PRODUK`);

--
-- Constraints for table `rincipenjualan`
--
ALTER TABLE `rincipenjualan`
  ADD CONSTRAINT `FK_RINCIANPENJUALAN_PRODUKUTAMA` FOREIGN KEY (`ID_PRODUKUTAMA`) REFERENCES `produkutama` (`ID_PRODUKUTAMA`),
  ADD CONSTRAINT `FK_RINCIAN_PENJUALAN` FOREIGN KEY (`ID_PENJUALAN`) REFERENCES `penjualan` (`ID_PENJUALAN`);

--
-- Constraints for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD CONSTRAINT `FK_ANGGOTA_TESTIMONI` FOREIGN KEY (`ID_ANGGOTA`) REFERENCES `anggota` (`ID_ANGGOTA`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
