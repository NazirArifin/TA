/* direktori controller */
app.controller('DirektoriCtrl', function($scope, $location, $http, notify) {
	if ($scope.token) $scope.me();
	
	$scope.editing = false;
	$scope.state = '';
	$scope.add = function() {
		$scope.editing = true;
		$scope.state = 'Tambah';
	};
	$scope.cancel = function() {
		$scope.resetDirektori();
		$scope.editing = false;
		$scope.state = '';
	};
	$scope.setEdit = function(i) {
		$scope.state = 'Edit';
		$scope.loadDetail(i);
	};
	$scope.setStatus = function(i, s) {
		$http.post($scope.server + '/direktori/' + i, { status: s }).
		success(function(d) { $scope.loadData(); }).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	};
	
	// pagination dan search
	$scope.page = {
		cpage: 0,
		numpage: 0,
		query: '',
		order: 'nama',
		sort: 'asc',
		num: 25,
		status: ''
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
	
	// load data direktori
	$scope.direktoriList = [];
	$scope.loadData = function() {
		$http.get($scope.server + '/direktori?' + jQuery.param($scope.page)).
		success(function(d) {
			$scope.direktoriList = d.direktori;
			$scope.page.numpage = d.numpage;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadData();
	
	// load kota dan kategori
	$scope.kota = [];
	$scope.kategori = [];
	$scope.loadTable = function() {
		$http.get($scope.server + '/data?t=kota,kategori_direktori').
		success(function(d) {
			$scope.kota = d.kota;
			$scope.kategori = d.kategori_direktori;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadTable();
	
	// load rincian data direktori untuk diedit
	$scope.loadDetail = function(i) {
		$http.get($scope.server + '/direktori/' + i).
		success(function(d) {
			$scope.direktori = d.direktori;
			$scope.editing = true;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
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
});