/* pengaturan controller */
app.controller('PengaturanCtrl', function($scope, $location, $http, notify) {
	if ($scope.token) $scope.me();
	
	$scope.kota = [];
	$scope.kotaList = [];
	$scope.kategori_direktori = [];
	$scope.kategori_produk = [];
	$scope.rekening = [];
	$scope.rekeningSelected = {};
	$scope.rekeningReset = function() {
		$scope.rekeningSelected = { id: '', an: '', nomor: '', bank: '' };
	}; $scope.rekeningReset();
	$scope.setRekening = function(d) {
		$scope.rekeningSelected = d;
	};
	$scope.ongkir = [];
	$scope.ongkirSelected = {};
	$scope.ongkirReset = function() {
		$scope.ongkirSelected = { id: '', ki: '', oi: '', b: '' };
	}; $scope.ongkirReset();
	$scope.setOngkir = function(d) {
		$scope.ongkirSelected = d;
	};
	$scope.kurir = [];
	$scope.loadData = function(t) {
		if (angular.isUndefined(t)) t = 'kota,kategori_direktori,kategori_produk';
		$http.get($scope.server + '/data?t=' + t).
		success(function(d) { 
			// kota
			if ( ! angular.isUndefined(d.kota)) {
				// bentuk jajar 3
				var row = [];
				$scope.kotaList = [];
				angular.forEach(d.kota, function(value, key) {
					if (row.length == 3) {
						$scope.kotaList.push(row);
						row = [];
					}
					value.index = key;
					row.push(value);
				});
				if (row.length > 0) $scope.kotaList.push(row);
				$scope.kota = d.kota; 
			}
			// kategori_direktori
			if ( ! angular.isUndefined(d.kategori_direktori)) $scope.kategori_direktori = d.kategori_direktori;
			// kategori produk
			if ( ! angular.isUndefined(d.kategori_produk)) $scope.kategori_produk = d.kategori_produk;
			// rekening
			if ( ! angular.isUndefined(d.rekening)) $scope.rekening = d.rekening;
			// kurir
			if ( ! angular.isUndefined(d.kurir)) $scope.kurir = d.kurir;
			// ongkir
			if ( ! angular.isUndefined(d.ongkir)) $scope.ongkir = d.ongkir;
		})
	}; $scope.loadData('kota,kategori_direktori,kategori_produk');
});