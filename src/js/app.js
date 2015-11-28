'use strict';

var app = angular.module('mdbz', ['ngRoute', 'ngAnimate', 'ngSanitize', 'ngStorage', 'angular-loading-bar']).
config(['$httpProvider', '$locationProvider', 'cfpLoadingBarProvider', function($httpProvider, $locationProvider, cfpLoadingBarProvider) {
	// loading-bar
	cfpLoadingBarProvider.includeSpinner = false;
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=utf-8';
	$httpProvider.defaults.transformRequest = [function(data) {
		return angular.isObject(data) && String(data) !== '[object File]' ? jQuery.param(data) : data;
	}];
	//$locationProvider.html5Mode(true).hashPrefix('#');
}]).
run(['$rootScope', '$location', function($rootScope, $location) {
	
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
