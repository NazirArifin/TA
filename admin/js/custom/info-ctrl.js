'use strict';

/* info controller */
app.controller('InfoCtrl', function($scope, $location, $http, notify, $interval) {
	if ($scope.token) $scope.me();
	
	$scope.page = {
		cpage: 0, 
		numpage: 0,
		date: '',
		jenis: '',
		numdt: 25, 
		order: 'date', 
		sort: 'desc'
	};
	$scope.sortingIcon = function(f) {
		return 'sorting' + (f == $scope.page.order ? '_' + $scope.page.sort : '');
	};
	$scope.sortOrder = function(f) {
		$scope.page.date = '';
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
	
	$scope.check = false;
	$scope.checkAll = function() {
		$scope.check = ! $scope.check;
		for (var i = 0; i < $scope.infoList.length; i++) {
			$scope.infoList[i].check = $scope.check;
		}
	};
	
	var setNewDirektori = function(id, status) {
		$http.post($scope.server + '/newdirektori', { id: id, status: 1 }).
		success(function(d) {
			if (d.type) {
				alertify.success('Direktori berhasil diproses');
				$scope.loadData();
			} else alertify.error('Direktori gagal diproses');
		});
	};
	$scope.setApprove = function(id) {
		setNewDirektori(id, 1);
	};
	$scope.setReject = function(id) {
		setNewDirektori(id, 0);
	};
	
	// load data pemberitahuan
	$scope.infoList = [];
	$scope.loadData = function() {
		$http.get($scope.server + '/info/data?' + jQuery.param($scope.page)).
		success(function(d) {
			$scope.infoList = d.info;
			$scope.page.numpage = d.numpage;
		}).error(function(e, s, h) {
			alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
		});
	}; $scope.loadData();
});