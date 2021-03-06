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
 * muter2 :D
 */
app.directive('muter', function() {
	return function($scope, elm, attrs) {
		elm.hover(function() {
			$(this).transition({ rotate: '360deg' }, 'slow');
		}, function() {
			$(this).transition({ rotate: '0deg' }, 'slow');
		});
	};
});

/**
 * set kategori direktori
 */
app.directive('setKategoriDirektori', function() {
	return function($scope, elm, attrs) {
		elm.on('click', function() {
			var $form = $(this).closest('form'),
				$text = $form.find('span.text'),
				$input = $form.find('input:hidden');
			$text.html($(this).html());
			$input.val(attrs.id);
		});
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
 * zoomable
 */
app.directive('zoomableGallery', function() {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			if (attrs.src.match(/default\.(png|jpg)$/)) return;
			elm.elevateZoom({
				gallery:'gallery', cursor: 'pointer', galleryActiveClass: 'active',
				zoomWindowFadeIn: 500, zoomWindowFadeOut: 500, lensFadeIn: 500, lensFadeOut: 500,
				zoomWindowOffetx: 10
			});
			elm.bind("click", function(e) { var ez = elm.data('elevateZoom');	$.fancybox(ez.getGalleryList()); return false; });
		}
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
					sorted[i] = '/upload/' + t + '/' + sorted[i].replace(/^foto_/, '').replace(/(jpg|jpeg|png)$/, '.$1');
				$scope.$apply(function() { $scope[t].foto = sorted; });
			}
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
					var id = '/upload/' + t + '/' + $li.attr('id').replace(/^foto_/, '').replace(/(jpg|jpeg|png)$/, '.$1');
					var index = $scope[t].foto.indexOf(id);
					$scope.$apply(function() { $scope[t].foto.splice(index, 1); });
					$li.remove();
				});
			});
		}
	};
});

/**
 * Input maksimal
 */
app.directive('typeMaximal', function() {
	return function($scope, elm, attrs) {
		elm.on('keyup', function(e) {
			var len = $(this).val().length,
				max	= parseInt(attrs.typeMaximal),
				rest = max - len;
			$('.type-maximal-counter').html(rest < 0 ? 0 : rest);
			if (len > max) {
				$(this).val($(this).val().substr(0, 159));
			}
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
		
		// kirim pesan ke anggota
		if (attrs.target == 'modal-2') {
			var $text = $('#modalInputText');
			$(el).on('click', function(e) {
				$text.closest('.form-group').removeClass('has-error');
				$scope.setMessage({ forCode: you, forName: attrs.nama, fromCode: me, type: attrs.type, message: '' });
				$scope.$apply(); showModal();
				setTimeout(function() { $text.focus(); }, 500); 
			});
		}
		
		// edit profil
		if (attrs.target == 'modal-3') {
			$(el).on('click', function(e) {
				$('#form-edit-profil').find('.form-group').removeClass('has-error');
				showModal();
			});
		}
		
		// konfirmasi order
		if (attrs.target == 'modal-4') {
			$(el).on('click', function(e) {
				var order = $scope.orderList[attrs.index];
				$('#order-id').val(order.id);
				var t = ''
				for (var i in order.produk) t += '<li>' + order.produk[i] + '</li>';
				$('#order-produk').html(t);
				$('#order-bayar').val(order.total);
				showModal();
			});
		}
		
		// laporkan post ke admin
		if (attrs.target == 'modal-5') {
			$(el).on('click', function(e) {
				showModal();
			});
		}
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
 * check email apakah ada
 */
app.directive('checkEmailSaved', ['$http', 'notify', function($http, notify) {
	return function($scope, elm, attrs) {
		elm.on('change', function(e) {
			var $loader = $($(this).prev().find('span')[0]);
			if (angular.isDefined($scope.user.email) && $scope.user.email.length > 0) {
				$loader.toggleClass('hide');
				$http.get('/email/used?email=' + $(this).val()).
				success(function(d) {
					$loader.toggleClass('hide');
					if ( ! d.valid) {
						elm.val('').closest('.form-group').addClass('has-error');
						notify.slideTop.error('Maaf, email sudah pernah digunakan!. Masukkan alamat email lain');
					} else {
						elm.closest('.form-group').removeClass('has-error');
					}
				});
			} else $(this).closest('.form-group').addClass('has-error');
		});
	};
}]);

/**
 * Hapus testimoni
 */
app.directive('deleteTesti', ['$http', 'notify', function($http, notify) {
	return function($scope, elm, attrs) {
		elm.on('click', function(e) {
			bootbox.setDefaults({ locale: "id" });
			bootbox.confirm('<h3 class="text-danger"><i class="fa fa-question-circle fa-lg pull-left"></i> Apakah Anda yakin?</h3><p><strong>Data testimoni yang sudah dihapus kemungkinan tidak dapat dikembalikan lagi.</strong></p>', function(r) {
				if (r) {
					$http({ url: '/testimoni/' + attrs.deleteTesti, method: 'DELETE' }).
					success(function(d) {
						$scope.loadTesti();
					});
				}
			});
		});
	};
}]);

/**
 * Hapus data
 */
app.directive('deleteData', ['$http', 'notify', function($http, notify) {
	return function($scope, elm, attrs) {
		elm.on('click', function(e) {
			bootbox.setDefaults({ locale: "id" });
			bootbox.confirm('<h3 class="text-danger"><i class="fa fa-question-circle fa-lg pull-left"></i> Apakah Anda yakin?</h3><p><strong>Data yang sudah dihapus kemungkinan tidak dapat dikembalikan lagi.</strong></p>', function(r) {
				if (r) {
					$http({ url: '/' + attrs.type + '/' + attrs.deleteData, method: 'DELETE' }).
					success(function(d) {
						$scope.loadData();
						notify.bounce.error('Data berhasil dihapus!');
					});
				}
			});
		});
	};
}]);