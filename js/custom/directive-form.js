'use strict';

/** simpan pendaftaran */
app.directive('saveRegister', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function(e) {
				var valid = true;
				if (angular.isUndefined($scope.user.email) || $scope.user.email.length == 0) {
					$('#email').closest('.form-group').addClass('has-error');
					valid = false;
				}
				if ($scope.user.nama.length < 3) {
					$('#nama').closest('.form-group').addClass('has-error');
					valid = false;
				}
				if ($scope.user.telepon.length < 8) {
					$('#telp').closest('.form-group').addClass('has-error');
					valid = false;
				}
				if (valid) {
					if ( ! $scope.user.agree) return notify.slideTop.info('Anda harus menyetujui peraturan layanan di MADURA.BZ');
				} else {
					if ( ! valid) return notify.slideTop.error('Input Tidak Lengkap, Ulangi Bagian Bertanda Kesalahan');
				}
				$('.form-group').removeClass('has-error');
				elm.html('<i class="fa fa-refresh fa-spin"></i> MEMPROSES DATA...').prop('disabled', true).removeClass('btn-primary').addClass('btn-default');
				$http.post('/daftar', $scope.user).
				success(function(d) {
					elm.html('<i class="fa fa-check-circle-o"></i> Daftar Sekarang').prop('disabled', false).addClass('btn-primary').removeClass('btn-default');
					if (d.type) {
						$scope.registered = true;
						$scope.password = d.password;
						notify.slideTop.info('Selamat! Anda berhasil terdaftar');
					}
				});
			});
		}
	};
}]);

/** simpan testimoni */
app.directive('saveTestimoni', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function() {
				if ($scope.testi.length < 15) return notify.bounce.error('Testimoni dianggap terlalu sedikit!');
				elm.html('<i class="fa fa-refresh fa-spin"></i> MEMPROSES DATA...').prop('disabled', true).removeClass('btn-primary').addClass('btn-default');
				$http.post('/testimoni', { sender: me, member: you, data: $scope.testi }).
				success(function(d) {
					elm.html('<i class="fa fa-check"></i> Tambahkan Testimoni').prop('disabled', false).addClass('btn-primary').removeClass('btn-default');
					if (d.type) {
						$scope.testi = '';
						$scope.loadTesti();
						notify.slideTop.info('Testimoni berhasil ditambahkan');
					} else {
						$scope.testi = '';
						notify.slideTop.error(d.data);
					}
				});
			});
		}
	};
}]);

/** simpan review **/
app.directive('saveReview', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attr) {
			elm.on('click', function() {
				if ($scope.review.length < 15) return notify.bounce.error('Review produk dianggap terlalu sedikit!');
				elm.html('<i class="fa fa-refresh fa-spin"></i> MEMPROSES DATA...').prop('disabled', true).removeClass('btn-primary').addClass('btn-default');
				$http.post('/review', { sender: member, produk: produk, data: $scope.review }).
				success(function(d) {
					elm.html('<i class="fa fa-check"></i> Tambahkan Review').prop('disabled', false).addClass('btn-primary').removeClass('btn-default');
					if (d.type) {
						$scope.review = '';
						$scope.loadData();
						notify.slideTop.info('Review berhasil ditambahkan');
					} else {
						$scope.review = '';
						notify.slideTop.error(d.data);
					}
				});
			});
		}
	};
}]);

/** simpan komentar **/
app.directive('saveKomentar', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attr) {
			elm.on('click', function() {
				if ($scope.komentar.length < 2) return notify.bounce.error('Komentar harus terisi');
				elm.html('<i class="fa fa-refresh fa-spin"></i> MEMPROSES DATA...').prop('disabled', true).removeClass('btn-primary').addClass('btn-default');
				$http.post('/komentar', { sender: member, post: post, data: $scope.komentar }).
				success(function(d) {
					elm.html('<i class="fa fa-check"></i> Tambahkan Komentar').prop('disabled', false).addClass('btn-primary').removeClass('btn-default');
					if (d.type) {
						$scope.komentar = '';
						$scope.loadData();
						notify.slideTop.info('Komentar berhasil ditambahkan');
					} else {
						$scope.komentar = '';
						notify.slideTop.error(d.data);
					}
				});
			});
		}
	};
}]);

/** simpan data kiriman */
app.directive('saveKiriman', ['$http', 'notify', function($http, notify) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attr) {
			var t = '<i class="fa fa-check"></i> SIMPAN KIRIMAN';
			var successCallback = function() {
				notify.slideTop.info('Data kiriman berhasil tersimpan!');
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$scope.resetData();
				$scope.loadData();
				$scope.cancel();
				if ($scope.file !== null) $scope.file = null;
			};
			var errorCallback = function(status) {
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				if (angular.isUndefined(status)) {
					notify.slideTop.error('Data gagal diproses, ulangi pengisian data');
				} else {
					if( ! status.type) notify.bounce.error(status.data);
				}
			};
			
			elm.on('click', function() {
				var b = $scope.post, f = [];
				if (b.judul === null || b.judul.length < 3) f.push('judul');
				if (b.isi === null || b.isi.length < 10) f.push('isi');
				// hapus semua class has-error
				$('.form-group').removeClass('has-error');
				if (f.length > 0) {
					angular.forEach(f, function(value, key) {
						$('#' + value).closest('.form-group').addClass('has-error');
					});
					notify.bounce.error('Input tidak lengkap atau invalid. Periksa bagian bertanda kesalahan');
					return false;
				}
				elm.html('<i class="fa fa-refresh fa-spin"></i> HARAP TUNGGU...').prop('disabled', true).removeClass('btn-primary').addClass('btn-danger');
				var url = '/post' + ($scope.post.id != '' ? '/' + $scope.post.id : '');
				if ($scope.file !== null) {
					var fd = new FormData();
					if (angular.isArray($scope.file)) {
						for (var i in $scope.file) fd.append('file_' + i, $scope.file[i]);
					} else fd.append('file_0', $scope.file);
					
					angular.forEach($scope.post, function(value, key) {
						if (angular.isArray(value)) {
							for (var i in value) {
								fd.append(key + '[]', value[i]);
							}
						} else fd.append(key, value);
					});
					var xhr = new XMLHttpRequest();
					xhr.open('POST', url, true);
					xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
					xhr.onload = function() {
						var d = angular.fromJson(this.responseText);
						if (d.type == true) successCallback();
						else errorCallback(d);
					};
					xhr.onerror = function() { errorCallback(); };
					xhr.send(fd);
				} else {
					$http({ url: url, method: 'POST', data: $scope.post }).
					success(function(d) { 
						if (d.type == true) successCallback();
						else errorCallback(d);
					}).
					error(function(e, s, h) { errorCallback(s); });
				}
			});
		}
	};
}]);

/** simpan pesan dari modal */
app.directive('saveMessageModal', ['notify', '$http', function(notify, $http) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			var $text = $('#modalInputText');
			elm.on('click', function(ev) {
				if ($text.val().length < 3) {
					$text.focus();
					return $text.closest('.form-group').addClass('has-error');
				}
				$http.post('/pesan', $scope.message).
				success(function(d) {
					$('#modal-2').removeClass('md-show');
					notify.flip.info('Pesan yang Anda kirim berhasil tersimpan');
				}).error(function(e, s, h) {
					$('#modal-2').removeClass('md-show');
					alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
				});
			});
		}
	};
}]);