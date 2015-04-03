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
});

app.controller('LoginCtrl', function($scope) {
	$scope.registered = false;
	$scope.password = '';
	$scope.user = {
		email: '', nama: '', telepon: '', agree: false
	};
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
	$scope.loadData = function() {
		$http.get('/review?produk=' + produk + '&member=' + member).
		success(function(d) { $scope.reviewList = d.review; });
	}; $scope.loadData();
	$scope.setStatus = function(id, status) {
		$http.post('/review/' + id, { 'status': status, 'member': member }).
		success(function(d) { $scope.reviewList = d.review; });
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
	$scope.dataList = [];
	$scope.editing = false;
	$scope.maxUpload = (valid == '1' ? 5 : 3);
	$scope.loadData = function() {
		$http.get('/post?member=' + member + '&page=' + $scope.cpage).
		success(function(d) { $scope.dataList = d.kiriman; $scope.numpage = d.numpage; });
	}; $scope.loadData();
	$scope.post = {};
	$scope.file = null;
	$scope.resetData = function() {
		$scope.post = { id: '', tipe: '1', judul: '', isi: '', foto: [] };
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
});