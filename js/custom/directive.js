'use strict';

/** tooltips **/
app.directive('tooltips', function() {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) { 
			return attrs.$observe('title', function(v) {
				elm.tooltip({ placement: (attrs.placement || 'top') }); 
			});
		}
	}
});

/** popover */
app.directive('popovers', function() {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			return attrs.$observe('content', function(v) {
				elm.popover({
					placement: attrs.placement || 'top',
					animation: false,
					trigger: 'hover',
					html: true,
				});
			});
		}
	}
});

/** dropdown toggle untuk menu sidebar */
app.directive('dropdownToggle', function() {
	return {
		restrict: 'C',
		link: function($scope, elm, attrs) {
			elm.on('click', function() {
				var $ul = elm.next().slideToggle(150, function() {
					var $i = $(elm.find('.drop-icon')[0]);
					if ($ul.is(':visible')) {
						$i.transition({ rotate: '90deg' }, 'fast');
					} else {
						$i.transition({ rotate: '0deg' }, 'fast');
					}
				});
			});
		}
	};
});

/**
 * Select2
 */
app.directive('select2', function() {
	return {
		restrict: 'CA',
		require: '?ngModel',
		link: function($scope, elm, attrs, ctrl) {
			elm.select2();
			return attrs.$observe('value', function(v) {
				elm.select2();
			});
		}
	};
});

/**
 * date picker
 */
app.directive('datePicker', function() {
	return function($scope, elm, attrs) {
		elm.datepicker({
			format: 'dd/mm/yyyy', language: 'id', autoclose: true
		});
	};
});

/**
 * date range picker
 */
app.directive('dateRangePicker', function() {
	return function($scope, elm, attrs) {
		elm.daterangepicker({
			format: 'DD/MM/YYYY',
			opens: 'left',
			locale: {
				cancelLabel: 'Batal', applyLabel: 'Simpan', fromLabel: 'DARI', toLabel: 'KE', weekLabel: 'M'
			}
		});
	};
});

/**
 * Masked input
 */
app.directive('maskedInput', function() {
	return function($scope, elm, attrs) { elm.mask(attrs.maskedInput); };
});

/**
 * Masked input
 */
app.directive('priceInput', function() {
	return function($scope, elm, attrs) { 
		elm.priceFormat({
			prefix: '',
			thousandsSeparator: '.',
			centsLimit: 0
		});
	};
});

/**
 * Scrollable
 */
app.directive('scrollable', function() {
	return function($scope, elm, attrs) {
		elm.slimScroll({
			height: attrs.height,
			railVisible: true,
			alwaysVisible: true,
			railColor: '#f00',
			start: attrs.start || 'top'
		});
	};
});

/**
 * Input file sederhana, diset $scope.file
 */
app.directive('simpleFileInput', ['notify', function(notify) {
	return function($scope, elm, attrs) {
		var resetButton = function(e) {
			e.prev().html('<i class="fa fa-file-o"></i> Pilih Berkas').
			closest('.btn').addClass('btn-success').removeClass('btn-warning').removeClass('btn-danger');
			e.val('');
		};
		
		elm.on('change', function(e) {
			var valid = true, temp = [];
			for (var i in e.target.files) {
				var f = e.target.files[i];
				if (i.match(/[^0-9]/)) continue;
				if (temp.length == 5) break;
				
				temp.push(f);
				var	a = f.name.split('.');
				if (a.length === 1 || (a[0] == "" && a.length === 2)) { valid = false; break; } 
				else {
					var b = '.' + a.pop().toLowerCase();
					if (attrs.accept.split(',').indexOf(b) === -1) { valid = false; break; }
					if (f.size > (2 * 1024 * 1024)) { valid = false; break; }
				}
			}
			
			if ( ! valid) {
				resetButton($(this));
				notify.flip.warning('File terlalu besar atau tidak valid, gunakan file lain');
				return false;
			}
			if (temp.length == 0) {
				resetButton($(this));
				$scope.file = null;
				return false;
			} else {
				if (attrs.multiple) { 
					$scope.file = temp;
					$(this).prev().html('<i class="fa fa-file-o"></i> ' + $scope.file.length + ' file terpilih').
					closest('.btn').removeClass('btn-success').addClass('btn-danger');
				} else {
					$scope.file = temp[0]; 
					a = $scope.file.name.split('.'); 
					$(this).prev().html('<i class="fa fa-file-o"></i> ' + a[0].substr(0, 12) + '__').
					closest('.btn').removeClass('btn-success').addClass('btn-warning');
				}
			}
		});
	}
}]);

/**
 * Animasi modal effect
 */
app.directive('showModal', ['$http', 'notify', function($http, notify) {
	return function($scope, elm, attrs) {
		var el = elm[0], showModal = function() {
			var $target = $('#' + attrs.target);
			$target.addClass('md-show').find('.btn-default').on('click', function() {
				$target.removeClass('md-show');
			});
			$('.md-overlay, .md-close').on('click', function() {
				$target.removeClass('md-show');
			});
			if( classie.has( el, 'md-setperspective' ) ) {
				setTimeout( function() { classie.add( document.documentElement, 'md-perspective' ); }, 25 );
			}
		}
		
		// data untuk pengaturan profil
		if (attrs.target == 'modal-1') {
			$(el).on('click', function(e) {
				$http.get('/direktori/' + attrs.showModal).
				success(function(d) {
					$scope.setDirektori(attrs.showModal, d.direktori);
					showModal();
				}).error(function(e, s, h) { }); 
			});
		}
	};
}]);