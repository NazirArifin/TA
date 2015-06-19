'use strict';

/* main controller */
app.controller('MainCtrl', function($rootScope, $scope, $location, $http, notify, $localStorage) {
	// shopping cart
	if (angular.isUndefined($localStorage.item)) $localStorage.item = [];
	$scope.addItem = function(id) {
		if ($localStorage.item.indexOf(id) != -1) return;
		$localStorage.item.push(id);
		notify.bounce.info('Produk berhasil ditambahkan ke keranjang!');
	};
	$scope.itemTaken = function(id) {
		return $localStorage.item.indexOf(id) != -1;
	};
	$scope.itemRemove = function(id) {
		var index = $localStorage.item.indexOf(id);
		if (index != -1) $localStorage.item.splice(index, 1);
		notify.bounce.warning('Produk berhasil dihapus');
	};
	
	// load data direktori saat deretan huruf direktori di klik
	$scope.direktoriList = [];
	$scope.direktoriAlpha = '';
	$scope.setDirektori = function(a, d) { 
		$scope.direktoriAlpha = a;
		$scope.direktoriList = d; 
	};
	$scope.loadDirektoriList = function(a) {
		$http.get('/direktori/' + a).
		success(function(d) { $scope.setDirektori(a, d.direktori); }).
		error(function(e, s, h) { }); 
	};
	
	$scope.item = $localStorage.item;
	$scope.logout = function() {
		delete $localStorage.item;
		window.location.href = '/logout';
	};
	
	/**
	 * untuk pagination
	 */
	$scope.range = function(s, e) {
		var r = [];
		if ( ! e) { e = s; s = 0; }
		for (var i = s; i < e; i++) r.push(i);
		return r;
	};
	
	// untuk upload terserah
	$scope.file = null;
});

app.controller('LoginCtrl', function($scope) {
	$scope.registered = false;
	$scope.password = '';
	$scope.user = {
		email: '', nama: '', telepon: '', agree: false
	};
});

app.controller('FpassCtrl', function($scope) {
	$scope.submitted = false;
	$scope.email = '';
});

app.controller('AnggotaCtrl', function($scope, $http, notify) {
	var you = window.you,
		me = window.me;
	
	$scope.testiList = [];
	$scope.testi = '';
	$scope.loadTesti = function() {
		$http.get('/testimoni?me=' + me + '&you=' + you).
		success(function(d) { $scope.testiList = d.testimoni; });
	}; $scope.loadTesti();
	$scope.setStatus = function(id, status) {
		$http.post('/testimoni/' + id, { 'status': status, 'member': you }).
		success(function(d) { $scope.loadTesti(); });
	};
	
	$scope.postList = [];
	$scope.postPage = 0;
	$scope.loadPost = function() {
		$http.get('/post?member=' + you + '&page=' + $scope.postPage).
		success(function(d) { $scope.postList = d.kiriman; });
	}; $scope.loadPost();
	
	$scope.reviewList = [];
	$scope.loadReview = function() {
		$http.get('/review?member=' + you).
		success(function(d) { $scope.reviewList = d.review; });
	}; $scope.loadReview();
	
	$scope.message = {};
	$scope.setMessage = function(d) { $scope.message = d; };
});

app.controller('ProdukCtrl', function($scope, $http, notify) {
	var produk = window.produk || '',
		member = window.member || '';
	$scope.reviewList = [];
	$scope.review = '';
	$scope.rating = 0;
	$scope.setRating = function(i) { $scope.rating = i; };
	$scope.loadData = function() {
		$http.get('/review?produk=' + produk + '&member=' + member).
		success(function(d) { $scope.reviewList = d.review; });
	}; $scope.loadData();
	$scope.setStatus = function(id, status) {
		$http.post('/review/' + id, { 'status': status, 'member': member }).
		success(function(d) { $scope.loadData(); });
	};
});

app.controller('KomentarCtrl', function($scope, $http, notify) {
	var post = window.post,
		member = window.member,
		poster = window.poster;
	$scope.komentarList = [];
	$scope.komentar = '';
	$scope.loadData = function() {
		$http.get('/komentar?post=' + post + '&member=' + member + '&poster=' + poster).
		success(function(d) { $scope.komentarList = d.komentar; });
	}; $scope.loadData();
});

/** untuk halaman home */
app.controller('HomePostCtrl', function($scope, $http, notify) {
	var member = window.member,
		valid = window.valid;
	$scope.cpage = 0;
	$scope.numpage = 0;
	$scope.query = '';
	$scope.categories = '';
	$scope.dataList = [];
	$scope.editing = false;
	$scope.maxUpload = (valid == '1' ? 5 : 3);
	$scope.loadData = function() {
		var param = {
			member: member, page: $scope.cpage,
			query: $scope.query, kategori: $scope.categories
		};
		$http.get('/post?' + jQuery.param(param)).
		success(function(d) { $scope.dataList = d.kiriman; $scope.numpage = d.numpage; });
	}; $scope.loadData();
	$scope.post = {};
	$scope.file = null;
	$scope.resetData = function() {
		$scope.post = { id: '', tipe: '1', kategori: '', judul: '', isi: '', foto: [], agree: false };
	}; $scope.resetData();
	$scope.setEdit = function(id) {
		$http.get('/post/' + id).
		success(function(d) { 
			$scope.post = d.kiriman;
			$scope.editing = true;
		});
	};
	$scope.cancel = function() {
		$scope.resetData();
		$scope.editing = false;
	};
	$scope.setStatus = function(id, status) {
		$http.post('/post/' + id, { status: status }).
		success(function(d) { $scope.loadData(); });
	};
	
	$scope.setPage = function() {
		if ($scope.cpage != this.n) {
			$scope.cpage = this.n; $scope.loadData();
		}
	};
	$scope.prevPage = function() {
		if ($scope.cpage > 0) {
			$scope.cpage--; $scope.loadData();
		}
	};
	$scope.nextPage = function() {
		if ($scope.cpage < $scope.numpage - 1) {
			$scope.cpage++; $scope.loadData();
		}
	};
	
	$scope.getFotoId = function(f) {
		return f.replace(/^\/upload\/post\//, '').replace(/\./, '')
	};
	$scope.kategori = [];
	$scope.loadTable = function() {
		$http.get('/data?t=kategori_produk').
		success(function(d) { $scope.kategori = d.kategori_produk; }).
		error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadTable();
});

/** untuk halaman home direktori **/
app.controller('HomeDirektoriCtrl', function($scope, $http, notify) {
	$scope.activeDirektori = '';
	$scope.namaDirektori = '';
	$scope.setActiveDirektori = function(id, nama) {
		$scope.activeDirektori = id;
		$scope.namaDirektori = nama.replace(/`/g, "'");
		$http.get('/admin/direktori/' + id).
		success(function(d) { 
			$scope.direktori = d.direktori;
			$scope.file = null;
			$scope.direktori.image = '/' + $scope.direktori.image;
		});
	};
	$scope.getDirektoriLink = function() {
		return '/direktori/' + $scope.activeDirektori + '/' + $scope.namaDirektori.toLowerCase().replace(/[^a-z0-9]/, '-');
	};
	$scope.cancel = function() {
		$scope.resetDirektori();
		$scope.activeDirektori = $scope.namaDirektori = '';
	};
	
	$scope.direktori = {};
	$scope.file = null;
	$scope.resetDirektori = function() {
		$scope.direktori = {
			id: 0,
			kategori: '',
			nama: '',
			pemilik: '',
			kota: '',
			alamat: '', alamat2: '',
			telepon: '', telepon2: '',
			info: '',
			image: '',
			email: '',
			web: '',
			koordinat: '', koordinat2: '',
			im: {
				wa: '', bbm: '', line: '', wechat: ''
			},
			sm: {
				fb: '', twitter: '', gplus: '', ig: ''
			}
		};
		$scope.file = null;
	}; $scope.resetDirektori();
	
	// load kota dan kategori
	$scope.kota = [];
	$scope.kategori = [];
	$scope.loadTable = function() {
		$http.get('/data?t=kota_direktori,kategori_direktori').
		success(function(d) {
			$scope.kota = d.kota_direktori;
			$scope.kategori = d.kategori_direktori;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadTable();
});

/** untuk halaman home produk **/
app.controller('HomeProdukCtrl', function($scope, $http, notify) {
	$scope.activeDirektori = '';
	$scope.namaDirektori = '';
	$scope.produkList = [];
	$scope.setActiveDirektori = function(id, nama) {
		$scope.activeDirektori = id;
		$scope.namaDirektori = nama.replace(/`/g, "'");
		$scope.loadData();
		$scope.cancel();
	};
	
	$scope.cpage = 0;
	$scope.numpage = 0;
	$scope.query = '';
	$scope.categories = '';
	
	$scope.loadData = function() {
		var param = {
			page: $scope.cpage, query: $scope.query, kategori: $scope.categories
		};
		$http.get('/direktori/' + $scope.activeDirektori + '?' + jQuery.param(param)).
		success(function(d) { 
			$scope.produkList = d.produk; $scope.numpage = d.numpage;
		});
	};
	$scope.getDirektoriLink = function() {
		return '/direktori/' + $scope.activeDirektori + '/' + $scope.namaDirektori.toLowerCase().replace(/[^a-z0-9]/, '-');
	};
	$scope.clear = function() {
		$scope.produkList = [];
		$scope.activeDirektori = $scope.namaDirektori = '';
	};
	
	$scope.setPage = function() {
		if ($scope.cpage != this.n) {
			$scope.cpage = this.n; $scope.loadData();
		}
	};
	$scope.prevPage = function() {
		if ($scope.cpage > 0) {
			$scope.cpage--; $scope.loadData();
		}
	};
	$scope.nextPage = function() {
		if ($scope.cpage < $scope.numpage - 1) {
			$scope.cpage++; $scope.loadData();
		}
	};
	
	$scope.produk = {};
	$scope.file = null;
	$scope.resetProduk = function() {
		$scope.produk = {
			id: '', kategori: '', nama: '', harga: '', info: '', foto: [], direktori: $scope.activeDirektori, agree: false
		};
	}; $scope.resetProduk();
	$scope.cancel = function() {
		$scope.resetProduk();
		$scope.editing = false;
		$scope.file = null;
	};
	$scope.editing = false;
	$scope.addProduk = function() { $scope.editing = true; };
	$scope.setEdit = function(id) {
		$scope.editing = true;
		$http.get('/produk/' + id).
		success(function(d) { $scope.produk = d.produk; });
	};
	$scope.setStatus = function(id, status) {
		$http.post('/produk/' + id, { id: id, status: status }).
		success(function(d) { $scope.loadData(); });
	};
	
	$scope.kategori = [];
	$scope.loadTable = function() {
		$http.get('/data?t=kategori_produk').
		success(function(d) { $scope.kategori = d.kategori_produk; }).
		error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadTable();
	
	$scope.getFotoId = function(f) {
		return f.replace(/^\/upload\/produk\//, '').replace(/\./, '')
	};
});

/** untuk home checkout **/
app.controller('HomeCheckoutCtrl', function($scope, $http, notify) {
	$scope.shipRate = 0;
	$scope.shipRateTemp = 0;
	$scope.subTotal = 0;
	$scope.grandTotal = 0;
	$scope.itemList = [];
	$scope.rekeningList = [];
	$scope.kota = [];
	$scope.tujuan = '';
	$scope.kurirList = [];
	$scope.kurir = '';
	$scope.berat = 0;
	$scope.shipping = 'kurir';
	$scope.codenable = false;
	$scope.setCOD = function() { 
		$scope.shipRateTemp = $scope.shipRate;
		$scope.shipRate = 0; 
		$scope.grandTotal -= $scope.shipRateTemp;
	};
	$scope.setKurir = function() {
		$scope.shipRate = $scope.shipRateTemp;
		$scope.shipRateTemp = 0;
		$scope.grandTotal += $scope.shipRate;
	};
	$scope.loadData = function() {
		$http.get('/data?t=fproduk,rekening,kota,kurir').
		success(function(d) {
			angular.forEach(d.fproduk, function(value, key) {
				var id = parseInt(value.id);
				if ($scope.item.indexOf(id) != -1) {
					var list = {
						id: parseInt(id),
						nama: value.nama,
						harga: parseInt(value.harga),
						jumlah: 1,
						berat: parseFloat(value.berat),
						total: parseInt(value.harga)
					};
					$scope.itemList.push(list);
					$scope.subTotal += parseInt(value.harga);
					$scope.berat += parseFloat(value.berat);
				}
			});
			$scope.grandTotal = $scope.subTotal + $scope.shipRate;
			$scope.rekeningList = d.rekening;
			$scope.kota = d.kota;
			$scope.kurirList = d.kurir;
		});
	}; $scope.loadData();
	$scope.loadOngkir = function() {
		$http.get('/ongkir?' + jQuery.param({ kota: $scope.tujuan, kurir: $scope.kurir, berat: $scope.berat })).
		success(function(d) { 
			$scope.shipRate = d.biaya;
			$scope.grandTotal = $scope.subTotal + $scope.shipRate;
			$scope.shipping = 'kurir';
			$scope.codenable = d.cod;
		});
	};
	$scope.reCalculate = function(i) {
		$scope.subTotal = 0;
		$scope.berat = 0;
		angular.forEach($scope.itemList, function(value, key) {
			if (value.jumlah == '') return;
			var jumlah = parseInt(value.jumlah),
				total = value.harga * jumlah,
				berat = value.berat * jumlah;
			value.total = total;
			$scope.subTotal += total;
			$scope.berat += berat;
		});
		$scope.loadOngkir();
	};
	$scope.removeItem = function(i, id) {
		$scope.itemList.splice(i, 1);
		$scope.itemRemove(id);
	};
});

/** untuk home order **/
app.controller('HomeOrderCtrl', function($scope, $http, notify) {
	$scope.orderList = [];
	$scope.rekeningList = [];
	$scope.loadData = function() {
		$http.get('/order').
		success(function(d) { $scope.orderList = d.order; });
		// load rekening
		$http.get('/data?t=rekening').
		success(function(d) { $scope.rekeningList = d.rekening; });
	}; $scope.loadData();
	$scope.setStatus = function(id, status) {
		$http.post('/order/' + id, { status: status }).
		success(function(d) {
			notify.bounce.info('Pemesanan berhasil dibatalkan');
			$scope.loadData();
		});
	};
});

/** untuk chat */
app.controller('HomeChatCtrl', function($scope, $http, notify, $interval) {
	$scope.foto = window.foto;
	$scope.nama = window.nama;
	
	// load member / admin di sebelah kiri
	$scope.chatList = [];
	$scope.loadChatList = function() {
		$http.get('/admin/pesan/daftar', { ignoreLoadingBar: true }).
		success(function(d) {
			$scope.chatList = d.daftar;
		});
	}; $scope.loadChatList();
	$scope.idSelected = '';
	$scope.fotoSelected = '';
	$scope.tipeSelected = '';
	$scope.newMessage = '';
	
	$scope.chat = [];
	$scope.loadPesan = function(id, tipe, foto) {
		$http.get('/admin/pesan/data?' + jQuery.param({ kode: id, tipe: tipe }), { ignoreLoadingBar: false }).
		success(function(d) {
			$scope.newMessage = '';
			$scope.idSelected = id;
			$scope.fotoSelected = foto;
			$scope.tipeSelected = tipe;
			$scope.chat = d.pesan;
		});
	};
	$scope.loadPesanAfter = function() {
		$http.get('/admin/pesan/data?' + jQuery.param({ kode: $scope.idSelected, tipe: $scope.tipeSelected }), { ignoreLoadingBar: false }).
		success(function(d) {
			$scope.newMessage = '';
			$scope.chat = d.pesan;
		});
	};
	
	/* periodically load chat */
	var count;
	var loadChat = function() {
		if ($scope.idSelected == '') return;
		$http.get('/admin/pesan/data?' + jQuery.param({ kode: $scope.idSelected, tipe: $scope.tipeSelected }), { ignoreLoadingBar: true }).
		success(function(d) {
			$scope.chat = d.pesan;
		});
	};
	$scope.callLoadChat = function() {
		if (angular.isDefined(count)) return;
		count = $interval(function() {
			loadChat();
		}, 3000);
	}; $scope.callLoadChat();
	$scope.$on('$destroy', function() {
		$interval.cancel(count);
		count = undefined;
	});
});