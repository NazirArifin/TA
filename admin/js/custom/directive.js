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

/** make small navigation kiri */
app.directive('makeSmallNav', function() {
	return function($scope, elm) {
		elm.on('click', function() {
			$('#page-wrapper').toggleClass('nav-small');
		});
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
	return function($scope, elm, attrs) { 
		$.mask.definitions['f'] = '[0-9,\.]';
		if (attrs.placeholder) elm.mask(attrs.maskedInput, { placeholder: attrs.placeholder }); 
		else elm.mask(attrs.maskedInput);
	};
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
 * Sortable
 */
app.directive('sortable', function() {
	return function($scope, elm, attrs) { 
		var t = attrs.type;
		elm.sortable({
			update: function(event, ui) {
				var sorted = elm.sortable("toArray");
				for (var i = 0; i < sorted.length; i++)
					sorted[i] = 'upload/' + t + '/' + sorted[i].replace(/^foto_/, '').replace(/(jpg|jpeg|png)$/, '.$1');
				$scope.$apply(function() { $scope[t].foto = sorted; });
			}
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
 * Hapus foto di galery foto
 */
app.directive('removePhotoLink', function() {
	return {
		restrict: 'C',
		link: function($scope, elm, attrs) {
			elm.on('click', function(e) {
				var t = attrs.type;
				var $li = $(this).closest('li').fadeOut('slow', function() {
					var id = 'upload/' + t + '/' + $li.attr('id').replace(/^foto_/, '').replace(/(jpg|jpeg|png)$/, '.$1');
					var index = $scope[t].foto.indexOf(id);
					$scope.$apply(function() { $scope[t].foto.splice(index, 1); });
					$li.remove();
				});
			});
		}
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
		if (attrs.target == 'modal-0') {
			var $text = $('#modalInputNama');
			$(el).on('click', function(e) {
				$text.closest('.form-group').removeClass('has-error');
				$('#modalInputPassword').closest('.form-group').removeClass('has-error');
				$('#modalInputPassword2').closest('.form-group').removeClass('has-error');
				showModal();
				setTimeout(function() { $text.focus(); }, 500); 
			});
		}
		
		// kirim pesan ke anggota
		if (attrs.target == 'modal-2') {
			var $text = $('#modalInputText');
			$(el).on('click', function(e) {
				var r = (attrs.type == 'anggota' ? $scope.anggotaList[attrs.showModal] : $scope.adminList[attrs.showModal] );
				$text.closest('.form-group').removeClass('has-error');
				$scope.setMessage({ forCode: r.kode, forName: r.nama, type: attrs.type, message: '' });
				$scope.$apply(); showModal();
				setTimeout(function() { $text.focus(); }, 500); 
			});
		}
		
		// kirim rekening
		if (attrs.target == 'modal-3') {
			$(el).on('click', function(e) {
				$('#modal-3').find('.form-group').removeClass('has-error');
				if ( ! angular.isUndefined($scope.rekening[parseInt(attrs.showModal)])) {
					$scope.setRekening($scope.rekening[parseInt(attrs.showModal)]);
					$scope.$apply(); 
				} else $scope.rekeningReset();
				showModal();
			});
		}
		
		// kirim ongkir
		if (attrs.target == 'modal-4') {
			$(el).on('click', function(e) {
				$('#modal-4').find('.form-group').removeClass('has-error');
				if ( ! angular.isUndefined($scope.ongkir[parseInt(attrs.showModal)])) {
					$scope.setOngkir($scope.ongkir[parseInt(attrs.showModal)]);
					$scope.$apply(); 
				} else $scope.ongkirReset();
				showModal();
			});
		}
	};
}]);

/**
 * Modify User
 */
app.directive('modifyUser', ['$http', function($http) {
	return function($scope, elm, attrs) {
		elm.on('click', function(e) {
			if (attrs.type == 'validate') {
				var param = { valid: '1' },
					msg = '<h3 class="text-success"><i class="fa fa-check-circle fa-lg pull-left"></i> Validasi Anggota?</h3><p>Anggota akan dianggap valid dan terpercaya dan memiliki icon valid sebelum nama Anggota.</p>';
			}
			if (attrs.type == 'upgrade') {
				var param = { tipe: '2' },
					msg = '<h3 class="text-success"><i class="fa fa-user-plus fa-lg pull-left"></i> Upgrage Anggota?</h3><p>Anggota Premium akan memiliki halaman khusus untuk produknya dan dapat mengatur sendiri data direktorinya.</p>';
			}
			bootbox.setDefaults({ locale: "id" });
			bootbox.confirm(msg, function(r) {
				if (r) {
					$http.post($scope.server + '/anggota/' + attrs.modifyUser, param).
					success(function(d) {
						$scope.loadData();
					}).error(function(e, s, h) {
						alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
					});
				}
			});
		});
	};
}]);

/**
 * Show prompt
 */
app.directive('showPrompt', ['$http', 'notify', function($http, notify) {
	return function($scope, elm, attrs) {
		elm.on('click', function(e) {
			bootbox.setDefaults({ locale: "id" });
			bootbox.prompt({
				title: attrs.text,
				value: (attrs.showPrompt.length == 0 ? '' : $scope[attrs.scope][attrs.showPrompt].nama),
				callback: function(r) {
					if (r !== null) {
						var id = (attrs.showPrompt.length == 0 ? 0 : $scope[attrs.scope][attrs.showPrompt].id),
							url = $scope.server + '/data?t=' + attrs.scope;
						if (id != 0) url += '&id=' + id;
						$http.post(url, { nama: r }).
						success(function(d) { $scope.loadData(attrs.scope); });
					}
				}
			});
		});
	};
}]);

/**
 * Cancel Form
 */
app.directive('cancelForm', function() {
	return function($scope, elm, attrs) { 
		elm.on('click', function(e) {
			$('.form-group').removeClass('has-error');
			$scope.$apply(function() { $scope.cancel(); });
		});
	};
});

/**
 * Delete button
 */
app.directive('deleteButton', ['$http', function($http) {
	return function($scope, elm, attrs) {
		elm.on('click', function(e) {
			e.preventDefault();
				bootbox.setDefaults({ locale: "id" });
				bootbox.confirm('<h3 class="text-danger"><i class="fa fa-question-circle fa-lg pull-left"></i> Apakah Anda yakin?</h3><p><strong>Data yang sudah dihapus kemungkinan tidak dapat dikembalikan lagi dan dapat menghapus data lain yang berhubungan dengannya.</strong></p>', function(r) {
				if (r) {
					var url = $scope.server + '/' + attrs.type;
					if (attrs.deleteButton.match(/[^0-9]/)) url += attrs.deleteButton;
					else url += '/' + attrs.deleteButton;
					$http({
						url: url,
						method: 'DELETE'
					}).
					success(function(d) { 
						if (attrs.load) $scope.loadData(attrs.load);
						else $scope.loadData(); 
					}).
					error(function(e, s, h) {
						alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
					});
				}
			});
		});
	};
}]);