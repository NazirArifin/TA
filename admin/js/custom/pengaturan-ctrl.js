/* pengaturan controller */
app.controller('PengaturanCtrl', function($scope, $location, $http, notify) {
	if ($scope.token) $scope.me();
	
	$scope.kota = [];
	$scope.kotaList = [];
	$scope.kotaPage = {	
		cpage: 0, 
		numpage: 0
	};
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
	$scope.ongkirPage = { 
		cpage: 0, 
		numpage: 0 
	};
	$scope.ongkirSelected = {};
	$scope.ongkirReset = function() {
		$scope.ongkirSelected = { id: '', ki: '', oi: '', b: '' };
	}; $scope.ongkirReset();
	$scope.setOngkir = function(d) {
		$scope.ongkirSelected = d;
	};
	$scope.kurir = [];
	$scope.loadData = function(t) {
		var all = false;
		if (angular.isUndefined(t)) {
			all = true;
			t = 'kategori_direktori,kategori_produk,kurir,rekening';
		}
		$http.get($scope.server + '/data?t=' + t).
		success(function(d) {
			// kategori_direktori
			if ( ! angular.isUndefined(d.kategori_direktori)) $scope.kategori_direktori = d.kategori_direktori;
			// kategori produk
			if ( ! angular.isUndefined(d.kategori_produk)) $scope.kategori_produk = d.kategori_produk;
			// rekening
			if ( ! angular.isUndefined(d.rekening)) $scope.rekening = d.rekening;
			// kurir
			if ( ! angular.isUndefined(d.kurir)) $scope.kurir = d.kurir;
		});
		// load kota
		if (all || t == 'kota') {
			$http.get($scope.server + '/kota?' + jQuery.param($scope.kotaPage)).
			success(function(d) {
				$scope.kotaPage.numpage = d.numpage;
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
			});
		}
		// load ongkir
		if (all || t == 'ongkir') {
			$http.get($scope.server + '/ongkir?' + jQuery.param($scope.ongkirPage)).
			success(function(d) {
				$scope.ongkirPage.numpage = d.numpage;
				$scope.ongkir = d.ongkir;
			});
		}
	}; $scope.loadData();
	
	$scope.setPage = function(f, t) {
		if ($scope[f].cpage != this.n) {
			$scope[f].cpage = this.n; $scope.loadData(t);
		}
	};
	$scope.prevPage = function(f, t) {
		if ($scope[f].cpage > 0) {
			$scope[f].cpage--; $scope.loadData(t);
		}
	};
	$scope.nextPage = function() {
		if ($scope[f].cpage < $scope[f].numpage - 1) {
			$scope[f].cpage++; $scope.loadData(t);
		}
	};
});