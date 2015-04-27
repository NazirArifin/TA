/* produk controller */
app.controller('ProdukCtrl', function($scope, $location, $http, notify) {
	if ($scope.token) $scope.me();
	
	$scope.editing = false;
	$scope.state = '';
	$scope.add = function() {
		$scope.editing = true;
		$scope.state = 'Tambah';
	};
	$scope.cancel = function() {
		$scope.resetProduk();
		$scope.editing = false;
		$scope.state = '';
	};
	$scope.setEdit = function(i) {
		$scope.state = 'Edit';
		$scope.loadDetail(i);
	};
	$scope.setStatus = function(i, s) {
		$http.post($scope.server + '/produk/' + i, { status: s }).
		success(function(d) { $scope.loadData(); }).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	};
	
	$scope.page = {
		cpage: 0,
		numpage: 0,
		query: '',
		status: '',
		sort: 'nama',
		order: 'asc',
		num: 25
	};
	$scope.sortingIcon = function(f) {
		return 'sorting' + (f == $scope.page.order ? '_' + $scope.page.sort : '');
	};
	$scope.sortOrder = function(f) {
		if (f == $scope.page.order) {
			if ($scope.page.sort == 'asc') $scope.page.sort = 'desc';
			else $scope.page.sort = 'asc';
		} else {
			$scope.page.sort = 'asc';
			$scope.page.order = f;
		}
		$scope.loadData();
	};
	$scope.setPage = function() {
		if ($scope.page.cpage != this.n) {
			$scope.page.cpage = this.n; $scope.loadData();
		}
	};
	$scope.prevPage = function() {
		if ($scope.page.cpage > 0) {
			$scope.page.cpage--; $scope.loadData();
		}
	};
	$scope.nextPage = function() {
		if ($scope.page.cpage < $scope.page.numpage - 1) {
			$scope.page.cpage++; $scope.loadData();
		}
	};
	
	// load data produk
	$scope.produkList = [];
	$scope.loadData = function() {
		$http.get($scope.server + '/produk?' + jQuery.param($scope.page)).
		success(function(d) {
			$scope.produkList = d.produk;
			$scope.page.numpage = d.numpage;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadData();
	
	// load kategori
	$scope.kategori = [];
	$scope.loadTable = function() {
		$http.get($scope.server + '/data?t=kategori_produk').
		success(function(d) {
			$scope.kategori = d.kategori_produk;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadTable();
	
	$scope.loadDetail = function(i) {
		$http.get($scope.server + '/produk/' + i).
		success(function(d) {
			$scope.produk = d.produk;
			$scope.editing = true;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	};
	
	$scope.getFotoId = function(f) {
		return f.replace(/^upload\/produk\//, '').replace(/\./, '')
	};
	$scope.produk = {};
	$scope.file = null;
	$scope.resetProduk = function() {
		$scope.produk = {
			id: '',
			kategori: '',
			nama: '',
			harga: '0',
			stok: '0',
			info: '',
			berat: '',
			foto: []
		};
		$scope.file = null;
	}; $scope.resetProduk();
});