'use strict';

/* main controller */
app.controller('MainCtrl', function($rootScope, $scope, $location, $localStorage, $http, $interval, notify, Main) {
	// validasi token jika ada
	$scope.login = { email: '', password: '', remember: true, source: 'web' };
	$scope.myDetails = false;
	$scope.file = null;
	$scope.myInputDetails = { nama: '', pass: '', pass2: '' };
	
	// signin, signup, dll
	$scope.signin = function() {
		var formData = $scope.login;
		Main.signin(formData, function(res) {
			if (res.type == false) alertify.error(res.data);
			else {
				$localStorage.token = res.data.token;
				$location.path('/home').replace();
				$scope.me();
			}
		}, function() {
			$rootScope.error = 'Gagal untuk signin';
			$scope.logout();
		});
	};
	
	$scope.signup = function() {
		var formData = {
			email: $scope.email,
			password: $scope.password
		};
		
		Main.save(formData, function(res) {
			if (res.type == false) alertify.error(res.data);
			else {
				$localStorage.token = res.data.token;
				$location.path('/home').replace();
			}
		}, function() {
			$rootScope.error = 'Gagal untuk signup';
			$scope.logout();
		});
	};
	
	$scope.me = function() {
		Main.me(function(res) {
			// redirect jika token valid
			if (res.type == true) {
				$scope.myDetails = res.data;
				$scope.myInputDetails.nama = res.data.nama;
				if ($location.path() == '/')
					$location.path('/home').replace();
			}
			if (res.type == false) $scope.logout();
		}, function() {
			$rootScope.error = 'Gagal mendapatkan data';
			$scope.logout();
		});
	};
	
	$scope.logout = function() {
		Main.logout(function() {
			$location.path('/').replace();
			// buang interval pesan
			$interval.cancel(count);
			count = undefined;
		}, function() {
			alertify.error('Gagal logout!');
		});
	};
	
	$scope.token = $localStorage.token;
	
	/**
	 * untuk pagination
	 */
	$scope.range = function(s, e) {
		var r = [];
		if ( ! e) { e = s; s = 0; }
		for (var i = s; i < e; i++) r.push(i);
		return r;
	};
	
	/**
	 * untuk modal info
	 */
	$scope.infoData = {};
	$scope.setInfoData = function(d) { $scope.infoData = d; };
	
	/**
	 * untuk modal kirim pesan
	 */
	$scope.message = { forCode: '', forName: '', type: '', message: '' };
	$scope.setMessage = function(d) { $scope.message = d; };
	
	/**
	 * summernote options
	 */
	$scope.summernoteOptions = {
		toolbar: [
			['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
			['textsize', ['fontsize']],
            ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
			['table', ['table']],
			['view', ['fullscreen']],
            ['help', ['help']]
		]
	};
	
	/**
	 * load pesan per 1 detik
	 */
	$scope.pesan = { item: [], baru: 0 };
	var count;
	var loadMessages = function() {
		if ($scope.myDetails === false) return;
		$http.get($scope.server + '/pesan?view=newest', { ignoreLoadingBar: true }).
		success(function(d) {
			$scope.pesan.item = d.pesan;
			$scope.pesan.baru = d.baru;
		});
	};
	$scope.callLoadMessages = function() {
		if (angular.isDefined(count)) return;
		count = $interval(function() {
			loadMessages();
		}, 5000);
	}; $scope.callLoadMessages();
	$scope.$on('$destroy', function() {
		$interval.cancel(count);
		count = undefined;
	});
	$scope.setTerbaca = function() {
		var id = [];
		for (var i = 0; i < $scope.pesan.item.length; i++) { 
			if ($scope.pesan.item[i].status == 'Baru')
				id.push($scope.pesan.item[i].id); 
		}
		$http.post($scope.server + '/pesan', { status: 2, ids: id.join(',') }, { ignoreLoadingBar: true }).
		success(function(d) { loadMessages(); });
	};
});