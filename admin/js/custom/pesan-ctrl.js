'use strict';

/* home controller */
app.controller('PesanCtrl', function($scope, $location, $http, notify, $interval) {
	if ($scope.token) $scope.me();
	
	// load member / admin di sebelah kiri
	$scope.chatList = [];
	$scope.loadChatList = function() {
		$http.get($scope.server + '/pesan/daftar', { ignoreLoadingBar: true }).
		success(function(d) {
			$scope.chatList = d.daftar;
		});
	}; $scope.loadChatList();
	$scope.idSelected = '';
	$scope.fotoSelected = '';
	$scope.tipeSelected = '';
	$scope.newMessage = '';
	
	$scope.chat = [];
	$scope.loadPesan = function(id, tipe, foto) {
		$http.get($scope.server + '/pesan/data?' + jQuery.param({ kode: id, tipe: tipe }), { ignoreLoadingBar: false }).
		success(function(d) {
			$scope.newMessage = '';
			$scope.idSelected = id;
			$scope.fotoSelected = foto;
			$scope.tipeSelected = tipe;
			$scope.chat = d.pesan;
		});
	};
	$scope.loadPesanAfter = function() {
		$http.get($scope.server + '/pesan/data?' + jQuery.param({ kode: $scope.idSelected, tipe: $scope.tipeSelected }), { ignoreLoadingBar: false }).
		success(function(d) {
			$scope.newMessage = '';
			$scope.chat = d.pesan;
		});
	};
	
	
	
	/* periodically load chat */
	var count;
	var loadChat = function() {
		if ($scope.idSelected == '') return;
		$http.get($scope.server + '/pesan/data?' + jQuery.param({ kode: $scope.idSelected, tipe: $scope.tipeSelected }), { ignoreLoadingBar: true }).
		success(function(d) {
			$scope.chat = d.pesan;
		});
	};
	$scope.callLoadChat = function() {
		if (angular.isDefined(count)) return;
		count = $interval(function() {
			loadChat();
		}, 3000);
	}; $scope.callLoadChat();
	$scope.$on('$destroy', function() {
		$interval.cancel(count);
		count = undefined;
	});
});