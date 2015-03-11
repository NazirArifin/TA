/* berita controller */
app.controller('BeritaCtrl', function($scope, $location, $http, notify) {
	if ($scope.token) $scope.me();
	
	$scope.news = {};
	$scope.file = null;
	$scope.resetNews = function() {
		$scope.news = {
			id: '', judul: '', pengantar: '', isi: '', keyword: ''
		};
		$scope.file = null;
	}; $scope.resetNews();
	$scope.editing = false;
	$scope.mode = '';
	$scope.add = function() {
		$scope.editing = true;
		$scope.mode = 'Tambah';
	};
	$scope.cancel = function() {
		$scope.editing = false;
		$scope.resetNews();
		$scope.mode = '';
	};
	$scope.setEdit = function(i) {
		$scope.mode = 'Edit';
		$scope.loadDetail(i);
	};
	
	$scope.setStatus = function(i, s) {
		$http.post($scope.server + '/berita/' + $scope.type.toLowerCase() + '/' + i, { status: s }).
		success(function(d) { $scope.loadData(); }).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	};
	
	$scope.type = ($location.path().split('/')[2] == 'bisnis' ? 'Bisnis' : 'Info');
	$scope.page = {
		cpage: 0, 
		numpage: 0,
		date: '',
		query: '',
		numdt: 25, 
		order: 'date', 
		sort: 'desc',
		status: ''
	};
	$scope.sortingIcon = function(f) {
		return 'sorting' + (f == $scope.page.order ? '_' + $scope.page.sort : '');
	};
	$scope.sortOrder = function(f) {
		$scope.page.date = $scope.page.query = '';
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
	
	// load data berita
	$scope.newsList = [];
	$scope.loadData = function() {
		$http.get($scope.server + '/berita/' + $scope.type.toLowerCase() + '?' + jQuery.param($scope.page)).
		success(function(d) {
			$scope.newsList = d.berita;
			$scope.page.numpage = d.numpage;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadData();
	
	// load rincian data berita untuk diedit
	$scope.loadDetail = function(i) {
		$http.get($scope.server + '/berita/' + $scope.type.toLowerCase() + '/' + i).
		success(function(d) {
			$scope.news = d.berita;
			$scope.editing = true;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	};
});