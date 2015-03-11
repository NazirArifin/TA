'use strict';

/* login controller */
app.controller('LoginCtrl', function($scope) {
	if ($scope.token) $scope.me();
});

/* home controller */
app.controller('HomeCtrl', function($scope, $location, $http, notify) {
	if ($scope.token) $scope.me();
	
	$scope.total = {
		direktori: '-',
		admin: '-',
		anggotapremium: '-',
		anggotareguler: '-',
		produk: '-',
		penjualan: '-',
		postjual: '-',
		postbeli: '-'
	};
	$scope.loadCount = function() {
		$http.get($scope.server + '/report/total').
		success(function(d) { $scope.total = d.total; }).error(function(e, s, h) { 
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadCount();
});