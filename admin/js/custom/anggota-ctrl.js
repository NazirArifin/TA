/* anggota controller */
app.controller('AnggotaCtrl', function($scope, $location, $http, notify) {
	if ($scope.token) $scope.me();
	
	$scope.setStatus = function(i, s) {
		$http.post($scope.server + '/anggota/' + i, { status: s }).
		success(function(d) { $scope.loadData(); }).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	};
	
	$scope.page = {
		cpage: 0,
		numpage: 0,
		query: '',
		order: 'nama',
		sort: 'asc',
		num: 25,
		type: '',
		status: '',
		date: '',
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
	
	// load data anggota
	$scope.anggotaList = [];
	$scope.loadData = function() {
		$http.get($scope.server + '/anggota?' + jQuery.param($scope.page)).
		success(function(d) {
			$scope.anggotaList = d.anggota;
			$scope.page.numpage = d.numpage;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadData();
});