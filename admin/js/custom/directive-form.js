'use strict';

/** simpan directori */
app.directive('simpanDirektori', ['notify', '$http', '$localStorage', '$timeout', function(notify, $http, $localStorage, $timeout) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			var t = '<i class="fa fa-lg fa-check-square-o"></i> SIMPAN DATA DIREKTORI';
			var successCallback = function() {
				notify.slideTop.info('Data direktori berhasil ditambahkan dan tersimpan!');
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				
				// reset input
				$scope.resetDirektori();
				$timeout(function() {
					$("#kategori").select2('val', '');
					$scope.loadData();
					if ($scope.state == 'Edit') $scope.cancel();
				}, 0);
			};
			var errorCallback = function(status) {
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				if (angular.isUndefined(status)) {
					notify.slideTop.error('Data gagal diproses, ulangi pengisian data');
				}
				if (status == 403 || status == 401) {
					notify.slideTop.error('Tidak ada hak akses, silakan login ulang!');
					$scope.logout();
				}
			};
			
			// elemen diklik
			elm.on('click', function() {
				var d = $scope.direktori,
					f = [];
				if (d.kategori === null || d.kategori == '') f.push('kategori');
				if (d.nama === null || d.nama.length < 5) f.push('nama');
				if (d.kota === null || d.kota == '') f.push('kota');
				if (d.alamat === null || d.alamat.length < 5) f.push('alamat');
				if (d.telepon === null || d.telepon.length < 3) f.push('telepon');
				if (d.info === null || d.info.length < 5) f.push('info');
				// hapus semua class has-error
				$('.form-group').removeClass('has-error');
				// jika ada yang error
				if (f.length > 0) {
					angular.forEach(f, function(value, key) {
						$('#' + value).closest('.form-group').addClass('has-error');
					});
					$("html, body").animate({ scrollTop: 0 }, "slow");
					if (f[0] == 'kategori') $('#kategori').select2('open');
					else $('#' + f[0]).focus();
					notify.bounce.error('Input tidak lengkap atau invalid. Periksa bagian bertanda kesalahan');
					return false;
				}
				// animasi di tombol
				elm.html('<i class="fa fa-refresh fa-spin"></i> HARAP TUNGGU...').prop('disabled', true).removeClass('btn-primary').addClass('btn-danger');
				if ($scope.file !== null) {
					// upload file juga
					var fd = new FormData();
					fd.append('file', $scope.file);
					angular.forEach($scope.direktori, function(value, key) {
						if ( ! angular.isObject(value))
							fd.append(key, value);
						else {
							angular.forEach(value, function(v, k) {
								var ks = key + '[' + k + ']';
								fd.append(ks, v);
							});
						}
					});
					
					var url = $scope.server + '/direktori' + ($scope.direktori.id != '' ? '/' + $scope.direktori.id : '');
					var xhr = new XMLHttpRequest();
					xhr.open('POST', url, true);
					xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
					xhr.setRequestHeader('Authorization', 'Bearer ' + $localStorage.token);
					xhr.onload = function() {
						var d = angular.fromJson(this.responseText);
						if (d.type == true) successCallback();
						else errorCallback();
					};
					xhr.onerror = function() { errorCallback(); };
					xhr.send(fd);
				} else {
					// gunakan $http
					var url = $scope.server + '/direktori' + ($scope.direktori.id != '' ? '/' + $scope.direktori.id : '');
					$http({ url: url, method: 'POST', data: $scope.direktori }).
					success(function(d) { 
						if (d.type == true) successCallback();
						else errorCallback();
					}).
					error(function(e, s, h) { errorCallback(s); });
				}
			});
		}
	};
}]);

/** simpan berita */
app.directive('simpanBerita', ['notify', '$http', '$localStorage', function(notify, $http, $localStorage) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			var t = '<i class="fa fa-lg fa-check-square-o"></i> SIMPAN BERITA';
			var successCallback = function() {
				notify.slideTop.info('Data berita berhasil ditambahkan dan tersimpan!');
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				
				// reset input
				$scope.resetNews();
				$scope.loadData();
				if ($scope.mode == 'Edit') $scope.cancel();
			};
			var errorCallback = function(status) {
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				if (angular.isUndefined(status)) {
					notify.slideTop.error('Data gagal diproses, ulangi pengisian data');
				}
				if (status == 403 || status == 401) {
					notify.slideTop.error('Tidak ada hak akses, silakan login ulang!');
					$scope.logout();
				}
			};
			
			elm.on('click', function() {
				var b = $scope.news, f = [];
				if (b.judul === null || b.judul.length < 5) f.push('judul');
				if (b.isi === null || b.isi.length < 5) f.push('isi');
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
				var url = $scope.server + '/berita/' + $scope.type.toLowerCase() + ($scope.news.id != '' ? '/' + $scope.news.id : '');
				if ($scope.file !== null) {
					var fd = new FormData();
					fd.append('file', $scope.file);
					angular.forEach($scope.news, function(value, key) {
						fd.append(key, value);
					});
					var xhr = new XMLHttpRequest();
					xhr.open('POST', url, true);
					xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
					xhr.setRequestHeader('Authorization', 'Bearer ' + $localStorage.token);
					xhr.onload = function() {
						var d = angular.fromJson(this.responseText);
						if (d.type == true) successCallback();
						else errorCallback();
					};
					xhr.onerror = function() { errorCallback(); };
					xhr.send(fd);
				} else {
					$http({ url: url, method: 'POST', data: $scope.news }).
					success(function(d) { 
						if (d.type == true) successCallback();
						else errorCallback();
					}).
					error(function(e, s, h) { errorCallback(s); });
				}
			});
		}
	};
}]);

/** simpan produk */
app.directive('simpanProduk', ['notify', '$http', '$localStorage', function(notify, $http, $localStorage) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			var t = '<i class="fa fa-lg fa-check-square-o"></i> SIMPAN PRODUK';
			var successCallback = function() {
				notify.slideTop.info('Data produk berhasil ditambahkan dan tersimpan!');
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				
				$scope.resetProduk();
				$scope.loadData();
				if ($scope.state == 'Edit') $scope.cancel();
				if ($scope.file !== null) $scope.file = null;
			};
			var errorCallback = function(status) {
				elm.html(t).prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
				if (angular.isUndefined(status)) {
					notify.slideTop.error('Data gagal diproses, ulangi pengisian data');
				}
				if (status == 403 || status == 401) {
					notify.slideTop.error('Tidak ada hak akses, silakan login ulang!');
					$scope.logout();
				}
			};
			
			elm.on('click', function() {
				var b = $scope.produk, f = [];
				if (b.kategori === null || b.kategori.length < 1) f.push('kategori');
				if (b.nama === null || b.nama.length < 3) f.push('nama');
				if (b.info === null || b.info.length < 5) f.push('info');
				if (b.harga === null || b.harga == 0) f.push('harga');
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
				var url = $scope.server + '/produk' + ($scope.produk.id != '' ? '/' + $scope.produk.id : '');
				
				if ($scope.file !== null) {
					var fd = new FormData();
					if (angular.isArray($scope.file)) {
						for (var i in $scope.file) fd.append('file_' + i, $scope.file[i]);
					} else fd.append('file_0', $scope.file);
					
					angular.forEach($scope.produk, function(value, key) {
						if (angular.isArray(value)) {
							for (var i in value) {
								fd.append(key + '[]', value[i]);
							}
						} else fd.append(key, value);
					});
					var xhr = new XMLHttpRequest();
					xhr.open('POST', url, true);
					xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
					xhr.setRequestHeader('Authorization', 'Bearer ' + $localStorage.token);
					xhr.onload = function() {
						var d = angular.fromJson(this.responseText);
						if (d.type == true) successCallback();
						else errorCallback();
					};
					xhr.onerror = function() { errorCallback(); };
					xhr.send(fd);
				} else {
					$http({ url: url, method: 'POST', data: $scope.produk }).
					success(function(d) { 
						if (d.type == true) successCallback();
						else errorCallback();
					}).
					error(function(e, s, h) { errorCallback(s); });
				}
			});
		}
	};
}]);

/** simpan pesan dari modal */
app.directive('simpanPesanModal', ['notify', '$http', function(notify, $http) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			var $text = $('#modalInputText');
			elm.on('click', function(ev) {
				if ($text.val().length < 3) {
					$text.focus();
					return $text.closest('.form-group').addClass('has-error');
				}
				$http.post($scope.server + '/pesan', $scope.message).
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

/** simpan pesan */
app.directive('simpanPesan', ['$http', function($http) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function(e) {
				if ($scope.newMessage.length < 2) return false;
				elm.html('<i class="fa fa-refresh fa-spin"></i> HARAP TUNGGU...').prop('disabled', true).removeClass('btn-primary').addClass('btn-danger');
				$http.post($scope.server + '/pesan', { forCode: $scope.idSelected, forName: '', type: $scope.tipeSelected.toLowerCase(), message: $scope.newMessage }).
				success(function(d) {
					elm.html('<i class="fa fa-send"></i> KIRIMKAN').prop('disabled', false).addClass('btn-primary').removeClass('btn-danger');
					$scope.newMessage = '';
					$scope.loadPesanAfter();
				});
			});
		}
	};
}]);

/** simpan admin */
app.directive('simpanAdmin', ['notify', '$http', function(notify, $http) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function(ev) {
				// validasi
				var valid = true, fields = [];
				if ($scope.admin.nama.length < 3) {
					valid = false; fields.push('nama');
				}
				if (angular.isUndefined($scope.admin.email) || $scope.admin.email.length == 0) {
					valid = false; fields.push('email');
				}
				if ($scope.admin.pass.length < 6) {
					valid = false; fields.push('password');
				}
				if ($scope.admin.pass != $scope.admin.pass2) {
					valid = false; fields.push('password2');
				}
				if ( ! valid) {
					angular.forEach(fields, function(value, key) {
						$('#' + value).closest('.form-group').addClass('has-error');
					});
					return;
				}
				$http.post($scope.server + '/admin', $scope.admin).
				success(function(d) {
					notify.flip.info('Data admin berhasil tersimpan');
					$scope.cancel();
					$scope.loadData();
				}).error(function(e, s, h) {
					alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
				});
			});
		}
	};
}]);

/** simpan profil admin */
app.directive('simpanProfil', ['notify', '$http', '$localStorage', function(notify, $http, $localStorage) {
	return {
		restrict: 'CA',
		link: function($scope, elm, attrs) {
			elm.on('click', function(ev) {
				// validasi
				var $nama = $('#modalInputNama'),
					$pass = $('#modalInputPassword'),
					$pass2 = $('#modalInputPassword2'), valid = true, fields = [];
				if ($nama.val().length < 3) {
					valid = false; fields.push($nama);
				}
				if ($pass.val() > 0 && $pass.val().length < 6) {
					valid = false; fields.push($pass);
				}
				if ($pass.val() != $pass2.val()) {
					valid = false; fields.push($pass2);
				}
				if ( ! valid) {
					angular.forEach(fields, function(value, key) {
						value.closest('.form-group').addClass('has-error');
					});
					return;
				}
				
				var url = $scope.server + '/me';
				if ($scope.file !== null) {
					var fd = new FormData;
					fd.append('file', $scope.file);
					angular.forEach($scope.myInputDetails, function(value, key) {
						fd.append(key, value);
					});
					var xhr = new XMLHttpRequest();
					xhr.open('POST', url, true);
					xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
					xhr.setRequestHeader('Authorization', 'Bearer ' + $localStorage.token);
					xhr.onload = function() {
						var d = angular.fromJson(this.responseText);
						if (d.type == true) {
							notify.flip.info('Data profil berhasil tersimpan');
							$scope.me();
						} else {
							alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
						}
						$('#modal-0').removeClass('md-show');
					};
					xhr.onerror = function() {};
					xhr.send(fd);
				} else {
					$http.post(url, $scope.myInputDetails)
					.success(function(d) {
						notify.flip.info('Data profil berhasil tersimpan');
						$scope.me();
						$('#modal-0').removeClass('md-show');
					}).error(function(e, s, h) { 
						alertify.error('Terjadi kesalahan. Periksa koneksi internet Anda');
						$('#modal-0').removeClass('md-show');
					});
				}
			});
		}
	};
}]);