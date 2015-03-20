'use strict';

/* main controller */
app.controller('MainCtrl', function($rootScope, $scope, $location, $localStorage, $http, notify) {
	// shopping cart
	$scope.item = [];
	$scope.addItem = function(id) {
		if ($scope.item.indexOf(id) != -1) return;
		$scope.item.push(id);
		notify.bounce.info('Produk berhasil ditambahkan ke keranjang!');
	};
	$scope.itemTaken = function(id) {
		return $scope.item.indexOf(id) != -1;
	};
	
	// direktori modal
	$scope.direktoriList = [];
	$scope.direktoriAlpha = '';
	$scope.setDirektori = function(a, d) { 
		$scope.direktoriAlpha = a;
		$scope.direktoriList = d; 
	};
});