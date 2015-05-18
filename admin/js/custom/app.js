'use strict';

var app = angular.module('mdbz', ['ngRoute', 'ngAnimate', 'ngSanitize', 'ngStorage', 'angular-loading-bar', 'summernote']).
config(function($routeProvider, $httpProvider, $locationProvider, cfpLoadingBarProvider) {
	// router
	$routeProvider
	.when('/', { 
		templateUrl: 'html/login.html', 
		controller: 'LoginCtrl' 
	})
	.when('/home', { 
		templateUrl: 'html/home.html', 
		controller: 'HomeCtrl' 
	})
	.when('/pesan', { 
		templateUrl: 'html/home.html', 
		controller: 'PesanCtrl' 
	})
	.when('/produk', { 
		templateUrl: 'html/home.html', 
		controller: 'ProdukCtrl' 
	})
	.when('/direktori', { 
		templateUrl: 'html/home.html', 
		controller: 'DirektoriCtrl' 
	})
	.when('/anggota', { 
		templateUrl: 'html/home.html', 
		controller: 'AnggotaCtrl' 
	})
	.when('/pengguna/anggota', { 
		templateUrl: 'html/home.html', 
		controller: 'AnggotaCtrl' 
	})
	.when('/pengguna/admin', { 
		templateUrl: 'html/home.html', 
		controller: 'AdminCtrl' 
	})
	.when('/market/:type', { 
		templateUrl: 'html/home.html', 
		controller: 'MarketCtrl' 
	})
	.when('/transaksi/jual', { 
		templateUrl: 'html/home.html', 
		controller: 'TransaksiCtrl' 
	})
	.when('/berita/:type', { 
		templateUrl: 'html/home.html', 
		controller: 'BeritaCtrl' 
	})
	.when('/pengaturan', { 
		templateUrl: 'html/home.html', 
		controller: 'PengaturanCtrl' 
	})
	.otherwise({ redirectTo: '/' });
	
	// loading-bar
	cfpLoadingBarProvider.includeSpinner = false;
	// interceptor untuk set Header
	$httpProvider.interceptors.push(['$q', '$location', '$localStorage', function($q, $location, $localStorage) {
		return {
			'request': function(config) {
				config.headers = config.headers || {};
				if ($localStorage.token) {
					config.headers.Authorization = 'Bearer ' + $localStorage.token;
				}
				return config;
			},
			'responseError': function(response) {
				if (response.status === 401 || response.status === 403) {
					$location.path('/login');
				}
				return $q.reject(response);
			}
		};
	}]);
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=utf-8';
	$httpProvider.defaults.transformRequest = [function(data) {
		return angular.isObject(data) && String(data) !== '[object File]' ? jQuery.param(data) : data;
	}];
}).
run(['$rootScope', '$location', function($rootScope, $location) {
	// server url
	var protocol 	= 'http',
		host		= 'nazirarifin.16mb.com/admin',
		port		= '80';
	$rootScope.server = protocol + '://' + host + (port != '80' ? ':' + port : '');
	
	// ketika routing error
	$rootScope.$on("$routeChangeError", function(event, current, previous, rejection) { $location.path('/').replace(); });
	// include file template setelah login
	$rootScope.getIncludeFile = function() {
		var d = 'html', path = $location.path();
		switch (path) {
			case '/home': 
				return d + '/dashboard.html'; break;
			case '/market/jual': case '/market/beli': 
				return d + '/market.html'; break;
			case '/transaksi/jual': 
				return d + '/transaksi-jual.html'; break;
			case '/berita/bisnis': case '/berita/info': 
				return d + '/berita.html'; break;
			case '/berita/tips':
				return d + '/tips.html'; break;
			case '/pengguna/anggota':
				return d + '/anggota.html'; break;
			case '/pengguna/admin':
				return d + '/admin.html'; break;
			default: return d + path + '.html';
		}
	};
	// set menu active atau tidak
	$rootScope.menuClass = function(p, s) {
		var path = $location.path().split('/');
		if (angular.isUndefined(s)) {
			if (p == path[1]) return 'active';
			return '';
		}
		if (p == path[1] && s == path[2]) return 'active';
		return '';
	};
}]).
filter('rootserver', function() {
	return function(input) {
		input = input || '';
		return input.replace(/\/admin$/, '');
	};
}).
factory('Main', ['$http', '$localStorage', function($http, $localStorage) {
	var baseUrl = 'http://nazirarifin.16mb.com/admin';
	function changeUser(user) {
		angular.extend(currentUser, user);
	}
	
	function urlBase64Decode(str) {
		var output = str.replace('-', '+').replace('_', '/');
		switch (output.length % 4) {
			case 0: break;
			case 2:
				output += '=='; break;
			case 3:
				output += '='; break;
			default:
				throw 'Illegal base64url string!';
		}
		return window.atob(output);
	}
	
	function getUserFromToken() {
		var token = $localStorage.token;
		var user = {};
		if (typeof token !== 'undefined') {
			var encoded = token.split('.')[1];
			user = JSON.parse(urlBase64Decode(encoded));
		}
		return user;
	}
	
	var currentUser = getUserFromToken();
	
	return {
		save: function(data, success, error) {
			$http.post(baseUrl + '/signin', data).success(success).error(error);
		},
		signin: function(data, success, error) {
			$http.post(baseUrl + '/authenticate', data).success(success).error(error);
		},
		me: function(success, error) {
			$http.get(baseUrl + '/me').success(success).error(error);
		},
		logout: function(success) {
			$http.get(baseUrl + '/signout/' + $localStorage.token).success(success);
			changeUser({});
			delete $localStorage.token;
			success();
		}
	};
}]).
factory('notify', function() {
	function animate(layout, effect, message, type, close) {
		switch (type) {
			case 'error':
				var icon = '<span class="icon fa fa-lg fa-ban"></span>'; break;
			case 'warning':
				var icon = '<span class="icon fa fa-lg fa-warning"></span>'; break;
			case 'notice':
				var icon = '<span class="icon fa fa-lg fa-info-circle"></span>'; break;
		}
		message = (effect == 'flip' ? '' : icon) + '<p>' + message + '</p>';
		
		new NotificationFx({
			message: message,
			layout: layout,
			effect: effect,
			type: type,
			onClose: close || function() {}
		}).show();
	}
	
	return {
		bounce: {
			error: function(t, c) { animate('attached', 'bouncyflip', t, 'error', c); },
			warning: function(t, c) { animate('attached', 'bouncyflip', t, 'warning', c); },
			info: function(t, c) { animate('attached', 'bouncyflip', t, 'notice', c); },
		},
		flip: {
			error: function(t, c) { animate('attached', 'flip', t, 'error', c); },
			warning: function(t, c) { animate('attached', 'flip', t, 'warning', c); },
			info: function(t, c) { animate('attached', 'flip', t, 'notice', c); },
		},
		slideTop: {
			error: function(t, c) { animate('bar', 'slidetop', t, 'error', c); },
			warning: function(t, c) { animate('bar', 'slidetop', t, 'warning', c); },
			info: function(t, c) { animate('bar', 'slidetop', t, 'notice', c); },
		},
		exploader: {
			error: function(t, c) { animate('bar', 'exploader', t, 'error', c); },
			warning: function(t, c) { animate('bar', 'exploader', t, 'warning', c); },
			info: function(t, c) { animate('bar', 'exploader', t, 'notice', c); },
		}
	};
});
