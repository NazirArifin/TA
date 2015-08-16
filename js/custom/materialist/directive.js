'use strict';

/* nav sidebar initialization */
app.directive('sideNavSlider', function() {
	return function($scope, elm, attrs) {
		elm.sideNav();
	};
});

/* tooltips */
app.directive('tooltipped', function() {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) { 
			return attrs.$observe('tooltip', function(v) {
				elm.tooltip(); 
			});
		}
	}
});

/* tabs */
app.directive('tabs', function() {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) { 
			elm.tabs();
		}
	}
});

/* modal trigger */
app.directive('modalTrigger', function() {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) { 
			elm.leanModal();
		}
	}
});

/* select initialization */
app.directive('select', function() {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) { 
			elm.material_select();
		}
	}
});

/* Select2 */
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

/* set kategori direktori */
app.directive('setKategoriDirektori', function() {
	return function($scope, elm, attrs) {
		elm.on('click', function() {
			var $form = $(this).closest('form'),
				$text = $(this).closest('ul').prev(),
				$input = $form.find('input:hidden');
			$text.html($(this).html());
			$input.val(attrs.id);
		});
	};
});

/* Scrollable */
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

/* muter2 :D */
app.directive('muter', function() {
	return function($scope, elm, attrs) {
		elm.hover(function() {
			$(this).transition({ rotate: '360deg' }, 'slow');
		}, function() {
			$(this).transition({ rotate: '0deg' }, 'slow');
		});
	};
});

/* datepicker */
app.directive('datepicker', function() {
	return function($scope, elm, attrs) {
		datepickr('#' + attrs.id, { dateFormat: 'd/m/Y' });
	};
});

/* scroller  */
app.directive('productScroller', function() {
	return function($scope, elm, attrs) {
		elm.slick({
			infinite: true,
			slidesToShow: 4,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 3000,
			cssEase: 'linear',
			prevArrow: '#product-scroller-left',
			nextArrow: '#product-scroller-right'
		});
	};
});

/* Masked input */
app.directive('maskedInput', function() {
	return function($scope, elm, attrs) { elm.mask(attrs.maskedInput); };
});

/* Price input */
app.directive('priceInput', function() {
	return function($scope, elm, attrs) { 
		elm.priceFormat({
			prefix: '',
			thousandsSeparator: '.',
			centsLimit: 0
		});
	};
});

/* scrollspy */
app.directive('scrollspy', function() {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) { 
			elm.scrollSpy();
		}
	}
});

/* check email apakah ada */
app.directive('checkEmailSaved', ['$http', 'notify', function($http, notify) {
	return function($scope, elm, attrs) {
		elm.on('change', function(e) {
			var $label = elm.next(),
				$text = $label.find('.default'),
				$loader = $label.find('.loader');
			if (angular.isDefined($scope.user.email) && $scope.user.email.length > 0) {
				$loader.toggleClass('hide');
				$text.toggleClass('hide');
				$http.get('/email/used?email=' + $(this).val()).
				success(function(d) {
					$loader.toggleClass('hide');
					$text.toggleClass('hide');
					if ( ! d.valid) {
						elm.val('').addClass('invalid');
						notify.slideTop.error('Maaf, email sudah pernah digunakan! Masukkan alamat email lain');
					} else {
						elm.removeClass('invalid');
					}
				});
			} else elm.addClass('invalid');
		});
	};
}]);

/* check email apakah ada */
app.directive('checkSubdomainSaved', ['$http', 'notify', function($http, notify) {
	return function($scope, elm, attrs) {
		elm.on('change', function(e) {
			var $label = elm.next(),
				$text = $label.find('.default'),
				$loader = $label.find('.loader');
			if ($scope.direktori.web.length > 3) {
				$loader.toggleClass('hide');
				$text.toggleClass('hide');
				$http.get('/subdomain/used?subdomain=' + $(this).val()).
				success(function(d) {
					$loader.toggleClass('hide');
					$text.toggleClass('hide');
					if ( ! d.valid) {
						elm.val('').addClass('invalid');
						notify.slideTop.error('Maaf, subdomain sudah pernah digunakan! Gunakan lama lain');
					} else {
						$scope.direktori.web = d.accept;
						elm.removeClass('invalid');
						notify.slideTop.info('Nama subdomain tersedia, Anda dapat menggunakan nama ini');
					}
				});
			} else {
				elm.addClass('invalid');
				notify.slideTop.error('Nama subdomain minimal 3 karakter');
			}
		});
	};
}]);

/* zoomable */
app.directive('zoomableGallery', function() {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			if (attrs.src.match(/default\.(png|jpg)$/)) return;
			elm.elevateZoom({
				gallery:'gallery', cursor: 'pointer', galleryActiveClass: 'active',
				zoomWindowFadeIn: 500, zoomWindowFadeOut: 500, lensFadeIn: 500, lensFadeOut: 500,
				zoomWindowOffetx: 10, scrollZoom: true
			});
			elm.bind("click", function(e) { var ez = elm.data('elevateZoom');	$.fancybox(ez.getGalleryList()); return false; });
		}
	};
});

/* Sortable */
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

/* rating input */
app.directive('ratingInput', function() {
	return {
		restrict: 'AC',
		link: function($scope, elm, attrs, ctrl) {
			var $parent = elm.parent(),
				$rating = $parent.find('.rating');
			$parent.css('position', 'relative');
			elm.css('visibility', 'hidden');
			$rating.css({ 'position': 'absolute', 'top': '10px', 'left': '55px' });
		}
	}
});

/**
 * Input file sederhana, diset $scope.file
 */
app.directive('simpleFileInput', function() {
	return function($scope, elm, attrs) {
		var resetButton = function(e) {
			elm.val('');
			elm.closest('.btn').prev().val('');
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
					if (f.size > (1024 * 1024)) { valid = false; break; }
				}
			}
			
			if ( ! valid) {
				resetButton();
				Materialize.toast('File terlalu besar atau tidak valid, gunakan file lain', 4000);
				return false;
			}
			if (temp.length == 0) {
				resetButton();
				$scope.file = null;
				return false;
			} else {
				if (attrs.multiple) { 
					$scope.file = temp;
				} else {
					$scope.file = temp[0]; 
				}
			}
		});
	}
});

/* Animasi modal effect */
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
				for (var i in order.produk) t += '<li><i class="fa fa-fw fa-check"></i> ' + order.produk[i] + '</li>';
				if ($('#order-produk').length) $('#order-produk').html(t);
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
		
		// upgrade keanggotaan
		if (attrs.target == 'modal-6') {
			$(el).on('click', function(e) {
				showModal();
			});
		}
	};
}]);

/* Cancel Form */
app.directive('cancelForm', function() {
	return function($scope, elm, attrs) { 
		elm.on('click', function(e) {
			$('input,textarea').removeClass('invalid');
			$scope.$apply(function() { $scope.cancel(); });
		});
	};
});

/* joyride */
app.directive('joyride', function() {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) { 
			elm.on('click', function(e) {
				$('#joyRideTipContent').joyride({
					autoStart: true, modal: true
				});
			});
		}
	}
});

/* baca tos saat pendaftaran */
app.directive('tosRead', function() {
	return function($scope, elm, attrs) {
		elm.bind('scroll', function() {
			if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
				$scope.readTos = true;
			}
		});
	};
});

/* Hapus testimoni */
app.directive('deleteTesti', ['$http', 'notify', function($http, notify) {
	return function($scope, elm, attrs) {
		var $modal = $('#modal0');
		var del = function() {
			$http({ url: '/testimoni/' + attrs.deleteTesti, method: 'DELETE' }).
			success(function(d) {
				$scope.loadTesti();
				$modal.closeModal();
				Materialize.toast('Data berhasil dihapus!', 4000);
			});
		};
		elm.on('click', function(e) {
			$modal.openModal();
			var yes = $modal.find('.modal-action')[0];
			$(yes).off().on('click', del);
		});
	};
}]);

/* Hapus data */
app.directive('deleteData', ['$http', 'notify', function($http, notify) {
	return function($scope, elm, attrs) {
		var $modal = $('#modal0');
		var del = function() {
			$http({ url: '/' + attrs.type + '/' + attrs.deleteData, method: 'DELETE' }).
			success(function(d) {
				$scope.loadData();
				$modal.closeModal();
				Materialize.toast('Data berhasil dihapus!', 4000);
			});
		};
		
		elm.on('click', function(e) {
			$modal.openModal();
			var yes = $modal.find('.modal-action')[0];
			$(yes).off().on('click', del);
		});
	};
}]);

