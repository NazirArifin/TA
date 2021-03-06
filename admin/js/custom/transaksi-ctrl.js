/* transaksi controller */
app.controller('TransaksiCtrl', function($scope, $location, $http, notify) {
	if ($scope.token) $scope.me();
	
	$scope.page = {
		cpage: 0, 
		numpage: 0,
		date: '',
		status: '',
		numdt: 25, 
		order: 'date', 
		sort: 'desc'
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
	
	// load data transaksi
	$scope.itemList = [];
	$scope.loadData = function() {
		$http.get($scope.server + '/transaksi/jual?' + jQuery.param($scope.page)).
		success(function(d) {
			$scope.itemList = d.transaksi;
			$scope.page.numpage = d.numpage;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadData();
	
	$scope.setStatus = function(i, s) {
		$http.post($scope.server + '/transaksi/jual/' + i, { status: s }).
		success(function(d) { $scope.loadData(); }).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	};
	$scope.getLabelStatus = function(f) {
		switch (f) {
			case 'Tertunda': return 'label-primary';
			case 'Dikonfirmasi': return 'label-success';
			case 'Lewat': return 'label-default';
			case 'Batal': return 'label-danger';
			case 'Diproses': return 'label-warning';
			case 'Dikirim': return 'label-primary';
			case 'Selesai': return 'label-success';
			default: return '';
		}
	};
});