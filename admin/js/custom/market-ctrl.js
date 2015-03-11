/* market controller */
app.controller('MarketCtrl', function($scope, $location, $http, notify) {
	if ($scope.token) $scope.me();
	
	$scope.type = ($location.path().split('/')[2] == 'jual' ? 'Jual' : 'Beli');
	$scope.page = {
		cpage: 0, 
		numpage: 0, 
		query: '', 
		date: '', 
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
	
	// load data anggota
	$scope.postList = [];
	$scope.loadData = function() {
		$http.get($scope.server + '/emarket/' + $scope.type.toLowerCase() + '?' + jQuery.param($scope.page)).
		success(function(d) {
			$scope.postList = d.kiriman;
			$scope.page.numpage = d.numpage;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadData();
});