/* pengaturan controller */
app.controller('PengaturanCtrl', function($scope, $location, $http, notify) {
	if ($scope.token) $scope.me();
	
	$scope.kota = [];
	$scope.kategori_direktori = [];
	$scope.kategori_produk = [];
	
	$scope.loadData = function(t) {
		if (angular.isUndefined(t)) t = 'kota,kategori_direktori,kategori_produk';
		$http.get($scope.server + '/data?t=' + t).
		success(function(d) { 
			if ( ! angular.isUndefined(d.kota)) $scope.kota = d.kota; 
			if ( ! angular.isUndefined(d.kategori_direktori)) $scope.kategori_direktori = d.kategori_direktori;
			if ( ! angular.isUndefined(d.kategori_produk)) $scope.kategori_produk = d.kategori_produk;
		})
	}; $scope.loadData('kota,kategori_direktori,kategori_produk');
});